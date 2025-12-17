<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $categories = ['Shirt', 'T-Shirt', 'Pant', 'Track'];

        foreach ($categories as $cat) {
            Category::create([
                'name' => $cat,
                'slug' => strtolower($cat)
            ]);
        }
    }
}
