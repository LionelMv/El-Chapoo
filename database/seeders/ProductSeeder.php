<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            ['name' => 'Smocha', 'price' => 60.00],
            ['name' => 'Mango Juice', 'price' => 50.00],
            ['name' => 'Passion Juice', 'price' => 50.00],
            ['name' => 'Sugarcane Juice', 'price' => 100.00],
            ['name' => 'Mango & Passion Cocktail', 'price' => 100.00],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
