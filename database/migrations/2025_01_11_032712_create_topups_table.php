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
        Schema::create('topups', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->unsignedBigInteger('user_id'); // ID pengguna yang melakukan top-up
            $table->decimal('amount', 15, 2); // Jumlah nominal transfer
            $table->string('proof_image')->nullable(); // Path bukti transfer
            $table->enum('status', ['pending', 'confirmed', 'rejected'])->default('pending'); // Status top-up
            $table->timestamps(); // Created_at dan Updated_at

            // Foreign key untuk user
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('topups');
    }
};
