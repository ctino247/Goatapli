<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Contract;

class ContractSeeder extends Seeder
{
    public function run(): void
    {
        Contract::create([
            'name' => 'Basic Starter',
            'price' => 50.00,
            'benefits' => 'Earn 5% referral commission; Daily bonus $1',
            'duration_days' => 30,
        ]);

        Contract::create([
            'name' => 'Pro Recruiter',
            'price' => 150.00,
            'benefits' => 'Earn 10% referral commission; Daily bonus $4',
            'duration_days' => 30,
        ]);

        Contract::create([
            'name' => 'Elite Partner',
            'price' => 500.00,
            'benefits' => 'Earn 15% referral commission; Daily bonus $15',
            'duration_days' => 30,
        ]);
    }
}
