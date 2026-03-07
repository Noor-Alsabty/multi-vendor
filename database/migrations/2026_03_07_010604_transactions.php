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
        Schema::create('transactions', function (Blueprint $blueprint) {
            $blueprint->id();
            
            // ربط العملية بصاحب المحفظة (البائع)
            $blueprint->foreignId('wallet_id')->constrained()->onDelete('cascade');
            
            // ربط العملية بالطلب (اختياري، في حال كان إيداع أرباح)
            $blueprint->foreignId('order_id')->nullable()->constrained()->onDelete('set null');

            // نوع العملية: هل هي إيداع أرباح (deposit) أم سحب أموال (withdraw)
            $blueprint->enum('type', ['deposit', 'withdraw', 'refund']);

            // المبلغ (دائماً استخدمي decimal للتعامل مع العملات بدقة)
            $blueprint->decimal('amount', 10, 2);

            // الرصيد "قبل" العملية والرصيد "بعد" العملية (مهم جداً للتدقيق المالي المحترف)
            $blueprint->decimal('balance_before', 10, 2);
            $blueprint->decimal('balance_after', 10, 2);

            // وصف بسيط يظهر للبائع (مثلاً: أرباح الطلب رقم #123)
            $blueprint->string('description')->nullable();

            $blueprint->timestamps();
    });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
