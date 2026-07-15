<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Regular user account
        User::updateOrCreate(
            ['email' => 'user@zesekai.com'],
            [
                'name' => 'Wibu Zesekai',
                'password' => Hash::make('password'),
                'is_admin' => false,
                'is_premium' => false,
                'email_verified_at' => now(),
            ]
        );

        // Optional: Premium user account
        User::updateOrCreate(
            ['email' => 'premium@zesekai.com'],
            [
                'name' => 'Sultan Zesekai',
                'password' => Hash::make('password'),
                'is_admin' => false,
                'is_premium' => true,
                'subscription_ends_at' => now()->addMonth(),
                'email_verified_at' => now(),
            ]
        );
    }
}
