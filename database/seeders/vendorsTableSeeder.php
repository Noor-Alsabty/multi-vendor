<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class vendorsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //






        // تأكد من وجود مستخدمين أولاً
        $users = DB::table('users')->where('role', 'vendor')->get();
        
        if ($users->isEmpty()) {
            $this->command->error('⚠️  لا يوجد مستخدمون من نوع vendor في قاعدة البيانات!');
            $this->command->info('يرجى تشغيل UsersTableSeeder أولاً.');
            return;
        }

        // بيانات المتاجر
        $vendors = [
            // 1. متجر إلكترونيات (مُتحقق)
            [
                'user_id' => $users->where('email', 'vendor@example.com')->first()->id ?? $users->first()->id,
                'store_name' => 'متجر الإلكترونيات الذكية',
                'store_email' => 'electronics@store.com',
                'store_phone' => '+201001001001',
                'store_logo' => 'vendors/electronics-logo.jpg',
                'description' => 'متجر متخصص في بيع الأجهزة الإلكترونية الحديثة والهواتف الذكية والكمبيوترات.',
                'verification_status' => 'verified',
                'verification_date' => Carbon::now()->subDays(30),
                'created_at' => Carbon::now()->subMonths(6),
                'updated_at' => Carbon::now()->subDays(10),
            ],

            // 2. متجر ملابس (في انتظار التحقق)
            [
                'user_id' => $users->skip(1)->first()->id ?? $users->first()->id,
                'store_name' => 'أزياء الموضة العصرية',
                'store_email' => 'fashion@store.com',
                'store_phone' => '+201002002002',
                'store_logo' => 'vendors/fashion-logo.jpg',
                'description' => 'أحدث صيحات الموضة والأزياء للرجال والنساء بأجود الخامات.',
                'verification_status' => 'pending',
                'verification_date' => null,
                'created_at' => Carbon::now()->subDays(15),
                'updated_at' => Carbon::now()->subDays(5),
            ],

            // 3. متجر كتب (مرفوض)
            [
                'user_id' => $users->skip(2)->first()->id ?? $users->first()->id,
                'store_name' => 'مكتبة المعرفة',
                'store_email' => 'books@store.com',
                'store_phone' => '+201003003003',
                'store_logo' => 'vendors/books-logo.jpg',
                'description' => 'أكبر تشكيلة من الكتب العربية والأجنبية في جميع المجالات.',
                'verification_status' => 'rejected',
                'verification_date' => Carbon::now()->subDays(7),
                'created_at' => Carbon::now()->subDays(25),
                'updated_at' => Carbon::now()->subDays(7),
            ],

            // 4. متجر أدوات منزلية (مُتحقق)
            [
                'user_id' => $users->skip(3)->first()->id ?? $users->first()->id,
                'store_name' => 'منتجات المنزل الذكي',
                'store_email' => 'home@store.com',
                'store_phone' => '+201004004004',
                'store_logo' => null,
                'description' => 'كل ما تحتاجه لتجهيز منزلك بأفضل المنتجات وأعلى جودة.',
                'verification_status' => 'verified',
                'verification_date' => Carbon::now()->subDays(20),
                'created_at' => Carbon::now()->subMonths(3),
                'updated_at' => Carbon::now()->subDays(3),
            ],

            // 5. متجر رياضة (في انتظار التحقق)
            [
                'user_id' => $users->skip(4)->first()->id ?? $users->first()->id,
                'store_name' => 'عالم الرياضة',
                'store_email' => 'sports@store.com',
                'store_phone' => null,
                'store_logo' => 'vendors/sports-logo.png',
                'description' => 'معدات رياضية وملابس رياضية من أفضل الماركات العالمية.',
                'verification_status' => 'pending',
                'verification_date' => null,
                'created_at' => Carbon::now()->subDays(3),
                'updated_at' => Carbon::now(),
            ],
        ];

        // إدراج البيانات
        DB::table('vendors')->insert($vendors);
        
        // رسالة تأكيد
        $this->command->info('✅ تم إضافة ' . count($vendors) . ' متجر بنجاح!');
        
        // عرض البيانات المضافة
        $vendorsData = DB::table('vendors')
            ->select('id', 'store_name', 'store_email', 'verification_status', 'created_at')
            ->get()
            ->map(function ($vendor) {
                return [
                    $vendor->id,
                    $vendor->store_name,
                    $vendor->store_email ?? 'N/A',
                    $vendor->verification_status,
                    Carbon::parse($vendor->created_at)->format('Y-m-d'),
                ];
            })
            ->toArray();
        
        $this->command->table(
            ['ID', 'اسم المتجر', 'البريد', 'حالة التحقق', 'تاريخ الإنشاء'],
            $vendorsData
        );
 













// 

    }
}
