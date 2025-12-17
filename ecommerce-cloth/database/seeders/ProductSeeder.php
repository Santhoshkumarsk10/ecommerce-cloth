<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;

class ProductSeeder extends Seeder
{
    public function run()
    {
        $categories = Category::all();

        foreach ($categories as $cat) {
            for ($i = 1; $i <= 5; $i++) {
                Product::create([
                    'category_id' => $cat->id,
                    'name' => $cat->name . " Sample Product $i",
                    'slug' => strtolower($cat->name . "-sample-$i"),
                    'description' => "Description for $cat->name Sample Product $i",
                    'status' => 1
                ]);
            }
        }
    }
}
