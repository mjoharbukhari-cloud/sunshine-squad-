<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder {
    public function run(): void {
        User::create([
            'name' => 'Admin Johar',
            'email' => 'admin@sunshine.com',
            'password' => Hash::make('password123'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Ali',
            'email' => 'ali@gmail.com',
            'password' => Hash::make('password123'),
            'role' => 'shopkeeper',
        ]);

        User::create([
            'name' => 'Sara',
            'email' => 'sara@gmail.com',
            'password' => Hash::make('password123'),
            'role' => 'customer',
        ]);
    }
}
