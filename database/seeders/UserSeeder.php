<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Upazila;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $sadar = Upazila::where('slug', 'narsingdi-sadar')->first();

        // 1. Super Admin
        User::firstOrCreate(
            ['phone' => '01700000000'],
            [
                'name' => 'অ্যাডমিন (নরসিংদী সেবা)',
                'email' => 'admin@narsingdisheba.com',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'upazila_id' => $sadar ? $sadar->id : null,
            ]
        );

        // 2. Demo Seller
        User::firstOrCreate(
            ['phone' => '01800000000'],
            [
                'name' => 'মেসার্স নরসিংদী ফ্যাশন (সেলার)',
                'email' => 'seller@narsingdisheba.com',
                'password' => Hash::make('password'),
                'role' => 'seller',
                'upazila_id' => $sadar ? $sadar->id : null,
            ]
        );
    }
}

