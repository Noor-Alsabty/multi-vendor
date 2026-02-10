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
        Schema::create('vendors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id') ->constrained() ->cascadeOnDelete(); 
            $table->string('store_name'); 
            $table->string('store_email')->nullable();
            $table->string('store_phone')->nullable();
            $table->string('store_logo')->nullable();
            $table->text('description')->nullable();
            $table->enum('verification_status',['pending','verified','rejected'])->default('pending');
            $table->text('verification_reject_reason')->nullable(); // سبب الرفض

            $table->timestamp('verification_date')->nullable(); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vendors');
    }
};
// 
