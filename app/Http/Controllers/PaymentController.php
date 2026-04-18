<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\ProductVariant;
use App\Models\Transaction;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Stripe\Checkout\Session as StripeSession;
use Stripe\Stripe;

class PaymentController extends Controller
{
    public function showCheckoutPage()
    {
        $cart = $this->getCartForUser(Auth::id());

        if (!$cart || $cart->items->isEmpty()) {
            return redirect()->route('carts.index')->with('error', 'سلتك فارغة!');
        }
        $totalAmount = $cart->items->sum(function ($item) {
            return $this->getItemPrice($item) * $item->quantity;
        });
        return view('checkout', compact('totalAmount'));
    }

    public function checkout()
    {
        try {
            $this->setStripeApiKey();
            $user = Auth::user();
            $cart = $this->getCartForUser($user->id);
            if (!$cart || $cart->items->isEmpty()) {
                return redirect()->route('carts.index')->with('error', 'سلتك فارغة!');
            }

            $session = StripeSession::create([
                'payment_method_types' => ['card'],
                'line_items' => $this->buildStripeLineItems($cart),
                'mode' => 'payment',
                'metadata' => [
                    'user_id' => $user->id,
                    'cart_id' => $cart->id,
                ],
                'success_url' => route('payment.success') . '?session_id={CHECKOUT_SESSION_ID}',
                'cancel_url' => route('payment.cancel'),
            ]);

            return redirect()->away($session->url);
        } catch (\Throwable $exception) {
            report($exception);
            $errorMessage = 'حدث خطأ أثناء إنشاء الدفع. الرجاء المحاولة مرة أخرى لاحقاً.';

            if (config('app.debug')) {
                $errorMessage = 'Stripe error: ' . $exception->getMessage();
            }

            return redirect()->route('checkout.show')->with('error', $errorMessage);
        }
    }

    public function success(Request $request)
    {
        try {
            $this->setStripeApiKey();

            $session = StripeSession::retrieve($request->get('session_id'));

            if ($session->payment_status !== 'paid') {
                return redirect()->route('checkout.show')->with('error', 'لم يتم الدفع بنجاح.');
            }

            $cartId = $session->metadata->cart_id;
            $userId = $session->metadata->user_id;

            $cart = $this->getCartForUser($userId);
            if (!$cart || $cart->items->isEmpty()) {
                return redirect()->route('carts.index')->with('error', 'سلتك فارغة!');
            }

            DB::transaction(function () use ($session, $cart, $cartId, $userId) {
                $order = Order::create([
                    'customer_id' => $userId,
                    'total_amount' => $session->amount_total / 100,
                    'payment_status' => 'paid',
                    'status' => 'confirmed',
                ]);

                $this->deductStockAndDeactivateIfNeeded($cart);
                $this->createOrderItems($order, $cart);
                $this->distributeVendorPayments($cart, $order);
                $this->createPaymentRecord($order, $session);
                CartItem::where('cart_id', $cartId)->delete();
            });

            return redirect()->route('carts.index')->with('success', 'تم الدفع بنجاح!');
        } catch (\Throwable $exception) {
            report($exception);
            return redirect()->route('checkout.show')->with('error', 'حدث خطأ أثناء معالجة الدفع. الرجاء المحاولة مرة أخرى لاحقاً.');
        }
    }

    public function cancel()
    {
        return redirect()->route('checkout.show')->with('error', 'تم إلغاء عملية الدفع، يمكنك المحاولة مرة أخرى إذا أردت.');
    }

    protected function getCartForUser(int $userId): ?Cart
    {
        return Cart::with('items.variant.product.vendor.wallet')
            ->where('user_id', $userId)
            ->first();
    }

    protected function getItemPrice($item): float
    {
        $price = data_get($item, 'variant.price');

        if ($price === null) {
            $price = data_get($item, 'variant.product.price', 0);
        }

        return (float) $price;
    }

    protected function buildStripeLineItems(Cart $cart): array
    {
        return $cart->items->map(function ($item) {
            $price = $this->getItemPrice($item);

            if ($price <= 0) {
                throw new \RuntimeException('هنالك عنصر في السلة بدون سعر صالح.');
            }

            return [
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => [
                        'name' => data_get($item, 'variant.product.name', 'Product'),
                    ],
                    'unit_amount' => (int) round($price * 100),
                ],
                'quantity' => $item->quantity,
            ];
        })->toArray();
    }

    protected function createOrderItems(Order $order, Cart $cart): void
    {
        foreach ($cart->items as $item) {
            $price = $this->getItemPrice($item);

            if ($price <= 0) {
                throw new \RuntimeException('سعر العنصر غير معرف في OrderItem.');
            }

            OrderItem::create([
                'order_id' => $order->id,
                'variant_id' => $item->variant_id,
                'quantity' => $item->quantity,
                'price' => $price,
            ]);
        }
    }

    protected function deductStockAndDeactivateIfNeeded(Cart $cart): void
    {
        foreach ($cart->items as $item) {
            $variant = ProductVariant::with('product')
                ->lockForUpdate()
                ->find($item->variant_id);

            if (! $variant) {
                throw new \RuntimeException('العنصر المطلوب غير متوفر.');
            }

            if ($variant->stock < $item->quantity) {
                throw new \RuntimeException('المخزون غير كافٍ لأحد العناصر في السلة.');
            }

            $variant->decrement('stock', $item->quantity);

            $product = $variant->product;
            if (! $product) {
                continue;
            }

            $hasAvailableStock = $product->variants()->where('stock', '>', 0)->exists();
            if (! $hasAvailableStock && $product->is_active) {
                $product->update(['is_active' => false]);
            }
        }
    }

    protected function distributeVendorPayments(Cart $cart, Order $order): void
    {
        foreach ($cart->items as $item) {
            $price = $this->getItemPrice($item);
            $totalItemAmount = $price * $item->quantity;
            $vendor = data_get($item, 'variant.product.vendor');

            if (!$vendor) {
                continue;
            }

            $commissionRate = $vendor->commission_rate ?? 0.10;
            $vendorAmount = $totalItemAmount * (1 - $commissionRate);
            $siteCommission = $totalItemAmount * $commissionRate;

            // إضافة الأرباح للبائع
            $vendorWallet = $vendor->wallet ?? $vendor->wallet()->create(['balance' => 0]);
            $vendorPreviousBalance = $vendorWallet->balance;
            $vendorWallet->increment('balance', $vendorAmount);
            $vendorWallet->refresh();

            Transaction::create([
                'wallet_id' => $vendorWallet->id,
                'amount' => $vendorAmount,
                'type' => 'deposit',
                'balance_before' => $vendorPreviousBalance,
                'balance_after' => $vendorWallet->balance,
                'description' => 'أرباح الطلب رقم: ' . $order->id,
            ]);

            // إضافة العمولة لمحفظة الموقع (Admin vendor)
            if ($siteCommission > 0) {
                $siteVendor = Vendor::where('commission_rate', 1.0)->first();
                if ($siteVendor && $siteVendor->wallet) {
                    $siteWallet = $siteVendor->wallet;
                    $sitePreviousBalance = $siteWallet->balance;
                    $siteWallet->increment('balance', $siteCommission);
                    $siteWallet->refresh();

                    Transaction::create([
                        'wallet_id' => $siteWallet->id,
                        'amount' => $siteCommission,
                        'type' => 'deposit',
                        'balance_before' => $sitePreviousBalance,
                        'balance_after' => $siteWallet->balance,
                        'description' => 'عمولة الموقع من الطلب رقم: ' . $order->id,
                    ]);
                }
            }
        }
    }

    protected function createPaymentRecord(Order $order, StripeSession $session): void
    {
        $paymentData = $this->getPaymentDetails($session);

        Payment::create([
            'order_id' => $order->id,
            'card_number_masked' => $paymentData['card_number_masked'],
            'card_holder_name' => $paymentData['card_holder_name'],
            'amount' => $order->total_amount,
            'status' => 'paid',
            'payment_date' => now(),
        ]);
    }

    protected function getPaymentDetails(StripeSession $session): array
    {
        $details = [
            'card_number_masked' => 'N/A',
            'card_holder_name' => 'N/A',
        ];

        if (empty($session->payment_intent)) {
            return $details;
        }

        $paymentIntent = \Stripe\PaymentIntent::retrieve($session->payment_intent, [
            'expand' => [
                'charges.data.payment_method_details.card',
                'charges.data.billing_details',
            ],
        ]);

        $charge = data_get($paymentIntent, 'charges.data.0');
        if (! $charge) {
            return $details;
        }

        $last4 = data_get($charge, 'payment_method_details.card.last4')
            ?: data_get($charge, 'payment_method_details.card.fingerprint');

        if ($last4) {
            $details['card_number_masked'] = str_starts_with($last4, '****')
                ? $last4
                : '**** **** **** ' . $last4;
        }

        $details['card_holder_name'] = data_get($charge, 'billing_details.name')
            ?: data_get($paymentIntent, 'charges.data.0.billing_details.name', $details['card_holder_name']);

        return $details;
    }

    protected function setStripeApiKey(): void
    {
        Stripe::setApiKey(config('services.stripe.secret'));
    }
}