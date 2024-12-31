<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReferralBonusesTable extends Migration
{
    public function up()
    {
        Schema::create('referral_bonuses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // Penerima bonus
            $table->unsignedBigInteger('referred_user_id'); // Pengguna yang direferensikan
            $table->decimal('bonus_amount', 10, 2); // Jumlah bonus
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('referred_user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('referral_bonuses');
    }
}
