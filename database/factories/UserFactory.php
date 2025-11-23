<?php

namespace Database\Factories;

use App\Models\user;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    protected $model = user::class;

    public function definition()
    {
        return [
            'username' => $this->faker->userName(),
            'password' => Hash::make('password'),
            'role' => $this->faker->randomElement(['Admin', 'Ketua', 'Wakil', 'Anggota']),
        ];
    }
}