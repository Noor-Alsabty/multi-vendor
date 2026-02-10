<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class VendorDocumentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
   

    public function run(): void
    {
        // تأكد من وجود متاجر أولاً
        $vendors = DB::table('vendors')->get();
        
        if ($vendors->isEmpty()) {
            $this->command->error('⚠️ لا يوجد متاجر في قاعدة البيانات!');
            $this->command->info('يرجى تشغيل VendorsTableSeeder أولاً.');
            return;
        }

        // أنواع الوثائق المختلفة
        $documentTypes = [
            'commercial_license' => 'رخصة تجارية',
            'tax_card' => 'بطاقة ضريبية',
            'id_card' => 'بطاقة هوية',
            'passport' => 'جواز سفر',
            'bank_statement' => 'كشف حساب بنكي',
            'lease_agreement' => 'عقد إيجار',
            'health_certificate' => 'شهادة صحية',
            'import_license' => 'رخصة استيراد',
            'export_license' => 'رخصة تصدير',
            'chamber_of_commerce' => 'شهادة غرفة تجارة',
        ];

        $documents = [];
        
        foreach ($vendors as $vendor) {
            // كل متجر يحتاج إلى 2-4 وثائق
            $numDocs = rand(2, 4);
            $selectedTypes = array_rand($documentTypes, $numDocs);
            
            if (!is_array($selectedTypes)) {
                $selectedTypes = [$selectedTypes];
            }
            
            foreach ($selectedTypes as $typeKey) {
                $status = $this->getRandomStatus();
                $isVerified = $status === 'verified';
                $isRejected = $status === 'rejected';
                
                $documents[] = [
                    'vendor_id' => $vendor->id,
                    'document_type' => $typeKey,
                    'document_path' => $this->generateDocumentPath($typeKey),
                    'document_number' => $this->generateDocumentNumber($typeKey),
                    'status' => $status,
                    'rejection_reason' => $isRejected ? $this->getRejectionReason() : null,
                    'uploaded_at' => Carbon::now()->subDays(rand(1, 60)),
                    'verified_at' => $isVerified ? Carbon::now()->subDays(rand(1, 30)) : null,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ];
            }
        }
        
        // إدراج البيانات
        DB::table('vendor_documents')->insert($documents);
        
        // رسالة تأكيد
        $this->command->info('✅ تم إضافة ' . count($documents) . ' وثيقة بنجاح!');
        
        // عرض البيانات المضافة
        $this->displayResults();
        
        // عرض إحصائيات
        $this->showStatistics();
    }
    
    /**
     * توليد حالة عشوائية للوثيقة
     */
    private function getRandomStatus(): string
    {
        $statuses = ['pending', 'verified', 'rejected'];
        $weights = [3, 5, 2]; // 30% pending, 50% verified, 20% rejected
        
        $random = rand(1, array_sum($weights));
        $current = 0;
        
        foreach ($weights as $index => $weight) {
            $current += $weight;
            if ($random <= $current) {
                return $statuses[$index];
            }
        }
        
        return 'pending';
    }
    
    /**
     * توليد مسار الوثيقة
     */
    private function generateDocumentPath($type): string
    {
        $extensions = ['pdf', 'jpg', 'png', 'jpeg'];
        $extension = $extensions[array_rand($extensions)];
        
        return "documents/vendors/{$type}/" . uniqid() . ".{$extension}";
    }
    
    /**
     * توليد رقم وثيقة واقعي
     */
    private function generateDocumentNumber($type): string
    {
        $prefixes = [
            'commercial_license' => 'CR',
            'tax_card' => 'TAX',
            'id_card' => 'ID',
            'passport' => 'PSP',
            'bank_statement' => 'BANK',
            'lease_agreement' => 'LEASE',
            'health_certificate' => 'HLTH',
            'import_license' => 'IMP',
            'export_license' => 'EXP',
            'chamber_of_commerce' => 'COC',
        ];
        
        $prefix = $prefixes[$type] ?? 'DOC';
        $year = date('Y');
        $randomNum = str_pad(rand(1, 99999), 5, '0', STR_PAD_LEFT);
        
        return "{$prefix}-{$year}-{$randomNum}";
    }
    
    /**
     * أسباب الرفض المحتملة
     */
    private function getRejectionReason(): string
    {
        $reasons = [
            'الصورة غير واضحة أو مقطوعة',
            'الوثيقة منتهية الصلاحية',
            'المعلومات غير مقروءة',
            'الوثيقة غير مكتملة',
            'يتطلب ختم رسمي',
            'التوقيع غير واضح',
            'يتطلب ترجمة معتمدة',
            'الوثيقة غير مطابقة للمعلومات المسجلة',
            'يتطلب تحديث المعلومات',
            'الوثيقة غير رسمية',
        ];
        
        return $reasons[array_rand($reasons)];
    }
    
    /**
     * عرض النتائج في جدول
     */
    private function displayResults(): void
    {
        $documentsData = DB::table('vendor_documents')
            ->join('vendors', 'vendor_documents.vendor_id', '=', 'vendors.id')
            ->select(
                'vendor_documents.id',
                'vendors.store_name',
                'vendor_documents.document_type',
                'vendor_documents.status',
                'vendor_documents.uploaded_at'
            )
            ->limit(10)
            ->get()
            ->map(function ($doc) {
                return [
                    $doc->id,
                    substr($doc->store_name, 0, 20) . (strlen($doc->store_name) > 20 ? '...' : ''),
                    $doc->document_type,
                    $this->getStatusBadge($doc->status),
                    Carbon::parse($doc->uploaded_at)->format('Y-m-d'),
                ];
            })
            ->toArray();
        
        if (!empty($documentsData)) {
            $this->command->table(
                ['ID', 'المتجر', 'نوع الوثيقة', 'الحالة', 'تاريخ الرفع'],
                $documentsData
            );
        }
    }
    
    /**
     * عرض إحصائيات الوثائق
     */
    private function showStatistics(): void
    {
        // إحصائيات حسب الحالة
        $statusStats = DB::table('vendor_documents')
            ->select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->get();
        
        $this->command->info("\n📊 إحصائيات الوثائق:");
        foreach ($statusStats as $stat) {
            $badge = $this->getStatusBadge($stat->status);
            $this->command->line("   {$badge}: {$stat->count} وثيقة");
        }
        
        // إحصائيات حسب النوع
        $typeStats = DB::table('vendor_documents')
            ->select('document_type', DB::raw('count(*) as count'))
            ->groupBy('document_type')
            ->orderBy('count', 'desc')
            ->limit(5)
            ->get();
        
        $this->command->info("\n📊 أكثر أنواع الوثائق شيوعاً:");
        foreach ($typeStats as $stat) {
            $this->command->line("   {$stat->document_type}: {$stat->count} وثيقة");
        }
        
        $total = DB::table('vendor_documents')->count();
        $this->command->info("\n✅ المجموع الكلي: {$total} وثيقة");
    }
    
    /**
     * إرجاع شارة للحالة بألوان
     */
    private function getStatusBadge($status): string
    {
        $badges = [
            'pending' => '⏳ معلق',
            'verified' => '✅ مفعل',
            'rejected' => '❌ مرفوض',
        ];
        
        return $badges[$status] ?? $status;
    }
}











        // 

