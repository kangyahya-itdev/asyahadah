<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('handphone', 15)->unique();
            $table->string('email', 100)->unique();
            $table->string('password',150);
            $table->string('referral_code',10)->unique()->nullable(); // Kode referral unik
            $table->string('referred_by',10)->nullable(); // Kode referral dari upline (opsional)
            $table->unsignedBigInteger('upline_id')->nullable(); // ID pengguna upline
            $table->timestamps();
            $table->foreign('upline_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::dropIfExists('users');
    }
}
