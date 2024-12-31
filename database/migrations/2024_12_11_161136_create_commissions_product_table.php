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
        Schema::create('commission_products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id')->unique(); // Setiap produk hanya memiliki satu komisi
            $table->decimal('personal_commission', 8, 2); // Komisi untuk pengguna
            $table->decimal('referral_commission', 8, 2); // Komisi untuk upline
            $table->timestamps();

            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('commission_products');
    }
};
