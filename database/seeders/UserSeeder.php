<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'Admin',
            'handphone' => '085123123123',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'referral_code' => 'abcd1234',
            // ... data lainnya
        ]);
    }
}
