<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Vendor;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\Shippment;
use App\Models\VendorDocument;
use App\Models\VendorBankAccount;
use App\Models\Wallet;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 0. إنشاء Admin user مع محفظة الموقع
        $adminUser = User::create([
            'name' => 'Platform Admin',
            'first_name' => 'Platform',
            'last_name' => 'Admin',
            'email' => 'admin@platform.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
            'status' => 'active',
        ]);

        $adminVendor = Vendor::create([
            'user_id' => $adminUser->id,
            'store_name' => 'Platform Commission Wallet',
            'verification_status' => 'verified',
            'verification_date' => now(),
            'commission_rate' => 1.0, // 100% (كل المال للموقع)
        ]);

        Wallet::create([
            'vendor_id' => $adminVendor->id,
            'balance' => 0,
        ]);

        // 1. إنشاء المستخدمين (زبائن ومدراء)
        $customers = User::factory(10)->create(['role' => 'customer']);
        User::factory()->create([
    'name' => 'Admin',
    'email' => 'admin@store.com',
    'password' => bcrypt('password123'), // تشفير كلمة السر ضروري
    'role' => 'admin', // رقم الأدمن في نظامك
]);
        // 2. إنشاء الأصناف (Categories)
        $categories = Category::factory(10)->create();

        // 3. إنشاء البائعين مع وثائقهم وحساباتهم البنكية
        $vendors = Vendor::factory(5)
            ->has(VendorDocument::factory()->count(2), 'documents')
            ->has(VendorBankAccount::factory()->count(1), 'bankAccounts')
            ->create();

        // إنشاء محافظ للبائعين
        foreach ($vendors as $vendor) {
            Wallet::create([
                'vendor_id' => $vendor->id,
                'balance' => 0,
            ]);
        }

        // 4. إنشاء الكوبونات
        $coupons = Coupon::factory(5)->create();

        // 5. إنشاء المنتجات مع الـ Variants (المقاسات والألوان)
        // هذا الجزء مهم جداً لأن الطلبات تعتمد على variant_id
        $products = Product::factory(30)->create([
            'vendor_id' => fn() => $vendors->random()->id,
            'category_id' => fn() => $categories->random()->id,
        ])->each(function ($product) {
            ProductVariant::factory(3)->create([
                'product_id' => $product->id
            ]);
        });

        // 6. إنشاء الطلبات (Orders) وعملياتها التابعة
        Order::factory(15)->create([
            'customer_id' => fn() => $customers->random()->id,
            'coupon_id' => fn() => $coupons->random()->id,
        ])->each(function ($order) {
            
            // أ) إضافة عناصر للطلب (Order Items) مرتبطة بـ Variants عشوائية
            $variants = ProductVariant::inRandomOrder()->limit(rand(1, 3))->get();
            foreach ($variants as $variant) {
                OrderItem::factory()->create([
                    'order_id' => $order->id,
                    'variant_id' => $variant->id,
                    'price' => $variant->product->price, // سعر المنتج الأصلي
                ]);
            }

            // ب) إنشاء عملية دفع لكل طلب
            Payment::factory()->create([
                'order_id' => $order->id,
                'amount' => $order->total_amount,
            ]);

            // ج) إذا كان حالة الطلب "shipped" أنشئ له سجل شحن
            if ($order->status === 'shipped') {
                Shippment::factory()->create([
                    'order_id' => $order->id
                ]);
            }
        });
    }
}