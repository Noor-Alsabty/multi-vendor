<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class vendorBankAccountsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
  


// 

    public function run(): void
    {
        $bankAccounts = [
            // حساب للمتجر الأول
            [
                'vendor_id' => 1,
                'bank_name' => 'البنك الأهلي التجاري',
                'iban' => 'SA0380000000608010167519',
                'account_holder_name' => 'متجر الإلكترونيات الذكية',
                'account_number' => '608010167519',
                'status' => 'verified',
                'verified_at' => now()->subDays(30),
                'created_at' => now()->subDays(45),
                'updated_at' => now(),
            ],
            // حساب للمتجر الثاني
            [
                'vendor_id' => 2,
                'bank_name' => 'الرياض',
                'iban' => 'SA0320000001234567891234',
                'account_holder_name' => 'أزياء الموضة العصرية',
                'account_number' => '1234567891234',
                'status' => 'pending',
                'verified_at' => null,
                'created_at' => now()->subDays(20),
                'updated_at' => now(),
            ],
            // حساب للمتجر الثالث (مرفوض)
            [
                'vendor_id' => 3,
                'bank_name' => 'سامبا',
                'iban' => 'SA0350000009876543210987',
                'account_holder_name' => 'مكتبة المعرفة',
                'account_number' => '9876543210987',
                'status' => 'rejected',
                'verified_at' => now()->subDays(10),
                'created_at' => now()->subDays(25),
                'updated_at' => now(),
            ],
            // حساب إضافي للمتجر الأول
            [
                'vendor_id' => 1,
                'bank_name' => 'الانماء',
                'iban' => 'SA0360000005555666677778',
                'account_holder_name' => 'أحمد محمد',
                'account_number' => '5555666677778',
                'status' => 'verified',
                'verified_at' => now()->subDays(15),
                'created_at' => now()->subDays(30),
                'updated_at' => now(),
            ],
        ];
        
        DB::table('vendor_bank_accounts')->insert($bankAccounts);
        
        $this->command->info('✅ تم إضافة ' . count($bankAccounts) . ' حساب بنكي بنجاح!');
    }
}