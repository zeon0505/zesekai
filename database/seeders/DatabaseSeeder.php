<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Create Admin User (Using ID 1 or a specific email pattern usually distinguished by role logic, 
        // but since we don't have roles table yet, we assume first user or specific email is admin for now 
        // OR you can add 'role' column later. For now, let's just make the users.)
        
        // Note: In a real app, you should have a 'role' column. 
        // I will assume for now that standard auth is used and you might manually protect admin routes 
        // with a middleware checking email or a specific ID, or we add a role column.
        // Let's add a quick 'is_admin' to users table via migration to be safe? 
        // Or just seed them for now.
        
        // Let's create the users first.

        // Admin
        User::updateOrCreate(['email' => 'admin@zesekai.com'], [
            'name' => 'Admin Zesekai',
            'email' => 'admin@zesekai.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
            'is_premium' => true,
        ]);

        // Premium User
        User::updateOrCreate(['email' => 'premium@zesekai.com'], [
            'name' => 'Sultan Zesekai',
            'email' => 'premium@zesekai.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
            'is_premium' => true,
            'subscription_ends_at' => now()->addMonth(),
        ]);

        // Regular User
        User::updateOrCreate(['email' => 'user@zesekai.com'], [
            'name' => 'Wibu Zesekai',
            'email' => 'user@zesekai.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
            'is_premium' => false,
        ]);

        $this->call([
            GenreSeeder::class,
            StudioSeeder::class,
            AnimeSeeder::class,
        ]);
    }
}
