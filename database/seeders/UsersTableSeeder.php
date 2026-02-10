<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        // بيانات المستخدمين الأساسية
        $users = [
            // 1. المستخدم الإداري
            [
                'name' => 'أحمد محمد',
                'first_name' => 'أحمد',
                'last_name' => 'محمد',
                'email' => 'admin@example.com',
                'email_verified_at' => Carbon::now(),
                'password' => Hash::make('12345678'), // كلمة مرور قوية
                'role' => 'admin',
                'phone' => '+201001234567',
                'avatar' => null,
                'status' => 'active',
                'date_of_birth' => '1990-05-15',
                'place_of_residence' => 'القاهرة، مصر',
                'gender' => 'male',
                'remember_token' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            
            // 2. بائع
            [
                'name' => 'محمد علي',
                'first_name' => 'محمد',
                'last_name' => 'علي',
                'email' => 'vendor@example.com',
                'email_verified_at' => Carbon::now(),
                'password' => Hash::make('12345678'),
                'role' => 'vendor',
                'phone' => '+201112345678',
                'avatar' => 'avatars/vendor1.jpg',
                'status' => 'active',
                'date_of_birth' => '1985-08-20',
                'place_of_residence' => 'الجيزة، مصر',
                'gender' => 'male',
                'remember_token' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            
            // 3. عميل (ذكر)
            [
                'name' => 'خالد حسين',
                'first_name' => 'خالد',
                'last_name' => 'حسين',
                'email' => 'customer1@example.com',
                'email_verified_at' => Carbon::now(),
                'password' => Hash::make('12345678'),
                'role' => 'customer',
                'phone' => '+201223456789',
                'avatar' => null,
                'status' => 'active',
                'date_of_birth' => '1995-03-10',
                'place_of_residence' => 'الإسكندرية، مصر',
                'gender' => 'male',
                'remember_token' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            
            // 4. عميلة (أنثى)
            [
                'name' => 'سارة أحمد',
                'first_name' => 'سارة',
                'last_name' => 'أحمد',
                'email' => 'customer2@example.com',
                'email_verified_at' => Carbon::now(),
                'password' => Hash::make('12345678'),
                'role' => 'customer',
                'phone' => '+201334567890',
                'avatar' => 'avatars/customer1.jpg',
                'status' => 'active',
                'date_of_birth' => '1998-12-05',
                'place_of_residence' => 'المنصورة، مصر',
                'gender' => 'female',
                'remember_token' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            
            // 5. عميل غير مفعل
            [
                'name' => 'عمر سعيد',
                'first_name' => 'عمر',
                'last_name' => 'سعيد',
                'email' => 'inactive@example.com',
                'email_verified_at' => null, // لم يتحقق من البريد
                'password' => Hash::make('12345678'),
                'role' => 'customer',
                'phone' => '+201445678901',
                'avatar' => null,
                'status' => 'inactive',
                'date_of_birth' => '2000-07-18',
                'place_of_residence' => 'أسوان، مصر',
                'gender' => 'male',
                'remember_token' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            
            // 6. عميل موقوف
            [
                'name' => 'نورا كمال',
                'first_name' => 'نورا',
                'last_name' => 'كمال',
                'email' => 'suspended@example.com',
                'email_verified_at' => Carbon::now()->subDays(30),
                'password' => Hash::make('12345678'),
                'role' => 'customer',
                'phone' => '+201556789012',
                'avatar' => null,
                'status' => 'suspended',
                'date_of_birth' => '1993-09-22',
                'place_of_residence' => 'بورسعيد، مصر',
                'gender' => 'female',
                'remember_token' => null,
                'created_at' => Carbon::now()->subDays(60),
                'updated_at' => Carbon::now()->subDays(15),
            ],
        ];
        
        // 7. إدراج البيانات في قاعدة البيانات
        DB::table('users')->insert($users);
        
        // 8. رسالة تأكيد
        $this->command->info('تم إضافة ' . count($users) . ' مستخدم بنجاح!');
        
        // 9. (اختياري) عرض البيانات المضافة
        $this->command->table(
            ['ID', 'Name', 'Email', 'Role', 'Status'],
            DB::table('users')
                ->select('id', 'name', 'email', 'role', 'status')
                ->get()
                ->toArray()
        );
    }
}



        // 
    

