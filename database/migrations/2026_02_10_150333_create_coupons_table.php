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
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->string('code'); 
            $table->string('discount_type');
            $table->decimal('discount_value',10,2); 
            $table->timestamp('start_date')->nullable();
            $table->timestamp('end_date')->nullable(); 
            $table->integer('usage_limit');
            $table->integer('used_count')->default(0);
            $table->string('applies_to');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coupons');
    }
};
