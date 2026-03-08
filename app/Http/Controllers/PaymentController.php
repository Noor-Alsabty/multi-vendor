<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use App\Models\Payment;
use App\Models\Transaction;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function checkout(Request $request)
    {
        // 1. إعداد مفتاح سترايب من ملف الـ .env
        Stripe::setApiKey(env('STRIPE_SECRET'));

        // 2. إنشاء جلسة الدفع
        $session = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => ['name' => 'طلب رقم #' . $request->order_id],
                    'unit_amount' => $request->total_amount * 100, // تحويل للدولار (السنت)
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            // نمرر رقم الطلب في الرابط لنعرفه عند العودة
            'success_url' => route('payment.success') . "?order_id=" . $request->order_id,
            'cancel_url' => route('payment.cancel'),
        ]);
        return redirect($session->url);
    }

public function success(Request $request)
    {
        $orderId = $request->get('order_id');
        $order = Order::with('items.product.vendor')->findOrFail($orderId);

        // 1. تحديث حالة الطلب إلى "مدفوع"
        $order->update(['payment_status' => 'paid']);

        // 2. توزيع الأرباح على المحافظ (Wallets)
        foreach ($order->items as $item) {
            $vendor = $item->product->vendor;
            
            // زيادة رصيد محفظة البائع في جدول wallets
            $vendor->wallet->increment('balance', $item->price);

            // 3. تسجيل العملية في جدول الحركات (Transactions)
            Transaction::create([
                'wallet_id' => $vendor->wallet->id,
                'amount' => $item->price,
                'type' => 'deposit',
                'description' => 'ربح من الطلب رقم: ' . $order->id,
            ]);
        }

        return view('payments.success', compact('order'));
    }
}