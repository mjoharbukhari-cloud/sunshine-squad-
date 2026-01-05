<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder {
    public function run(): void {
        Product::create([
            'shop_id' => 1,
            'title' => 'Solar Panel 300W',
            'description' => 'High efficiency monocrystalline solar panel',
            'price' => 25000,
            'color' => 'Black',
            'quantity' => 50,
            'image_path' => 'products/solar_panel.jpg',
            'status' => 'approved',
        ]);
    }
}
