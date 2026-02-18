<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@test.com',
            'phone' => '123456789',
            'username' => 'admin',
            'password' => Hash::make('admin123'),
            'referral_code' => 'ADMINCODE',
            'is_verified' => true,
            'is_admin' => true,
        ]);
    }
}
