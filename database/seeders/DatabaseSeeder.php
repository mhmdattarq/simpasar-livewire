<?php

namespace Database\Seeders;

use App\Enums\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Akun Admin (Login pakai username: admin)
        User::create([
            'name' => 'Administrator Pasar',
            'username' => 'admin',
            'password' => Hash::make('password'),
            'role' => Role::Admin,
        ]);

        // 2. Akun Pedagang (Login pakai NIK: 3301012345670001)
        User::create([
            'name' => 'Pak Joko (Pedagang Sayur)',
            'nik' => '3301012345670001',
            'password' => Hash::make('password'),
            'role' => Role::Pedagang,
        ]);
    }
}
