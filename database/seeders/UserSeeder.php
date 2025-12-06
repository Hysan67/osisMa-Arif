<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'email' => 'admin@example.com',
            'password' => Hash::make('password123'), // ← Selalu hash password
        ]);

        User::create([
            'email' => 'user@example.com',
            'password' => Hash::make('password123'),
        ]);

    }
}