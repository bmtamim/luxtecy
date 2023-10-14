<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $category_ids = Category::query()->pluck('id')->toArray();
        Product::factory(20)->create()->each(function ($product) use ($category_ids) {
            $product->categories()->sync([$category_ids[rand(1, count($category_ids) - 1)]]);
        });
    }
}
