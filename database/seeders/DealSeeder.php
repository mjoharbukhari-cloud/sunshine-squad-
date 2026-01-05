<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Deal;

class DealSeeder extends Seeder {
    public function run(): void {
        Deal::create([
            'shop_id' => 1,
            'title' => 'Solar Installation Package',
            'description' => 'Includes 2 panels + installation service',
            'service_range' => 'Islamabad & Rawalpindi',
            'product_price' => 50000,
            'service_price' => 10000,
            'status' => 'pending',
        ]);
    }
}
