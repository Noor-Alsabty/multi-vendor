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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vendor_id')->constrained();
            $table->foreignId('category_id')->constrained();
            $table->string('name');
            $table->text('description')->nullable();
            $table->decimal('price', 10, 2);
            //   العمودالمعنىslugرابط المنتجstatusحالة المنتجviewsعدد المشاهدات
            $table->string('slug')->unique()->nullable();

            $table->integer('views')->default(0);
            $table->timestamps();
        });



        // 'products', function (Blueprint $table) { $table->string('slug')->unique(); $table->string('status')->default('draft'); $table->integer('views')->default(0)









    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
