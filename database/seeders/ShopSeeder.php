<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Shop;

class ShopSeeder extends Seeder {
    public function run(): void {
        Shop::create([
            'user_id' => 2, // Ali the shopkeeper
            'name' => 'SolarTech Pvt Ltd',
            'location' => 'Islamabad',
            'contact_number' => '0300-1234567',
            'payment_number' => 'JazzCash 0300-1234567',
        ]);
    }
}
