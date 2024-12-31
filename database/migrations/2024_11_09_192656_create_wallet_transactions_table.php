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
        Schema::create('wallet_transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('wallet_id'); // Referensi ke wallet pengguna
            $table->enum('type', ['credit', 'debit']); // Jenis transaksi: 'credit' untuk penambahan, 'debit' untuk pengurangan
            $table->decimal('amount', 15, 2); // Jumlah transaksi
            $table->string('description')->nullable(); // Deskripsi transaksi
            $table->timestamps();

            $table->foreign('wallet_id')->references('id')->on('wallets')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wallet_transactions');
    }
};
