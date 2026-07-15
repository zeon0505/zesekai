<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Membuat akun Admin utama
        User::updateOrCreate(
            ['email' => 'admin@zesekai.com'],
            [
                'name' => 'Super Admin Zesekai',
                'password' => Hash::make('password'), // Ganti 'password' sesuai keinginan
                'is_admin' => true,
                'is_premium' => true,
                'email_verified_at' => now(),
            ]
        );

        // Kamu bisa menambah admin lain di sini jika butuh
        /*
        User::updateOrCreate(
            ['email' => 'admin2@zesekai.com'],
            [
                'name' => 'Admin Kedua',
                'password' => Hash::make('admin123'),
                'is_admin' => true,
                'is_premium' => true,
                'email_verified_at' => now(),
            ]
        );
        */
    }
}
