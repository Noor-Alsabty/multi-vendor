<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    Schema::table('products', function (Blueprint $table) {
        // إضافة عمود الحالة، والقيمة الافتراضية 1 (يعني نشط)
        $table->boolean('is_active')->default(true)->after('id'); 
    });
}

public function down(): void
{
    Schema::table('products', function (Blueprint $table) {
        // لحذف العمود في حال تراجعت عن العملية
        $table->dropColumn('is_active');
    });
}
};
