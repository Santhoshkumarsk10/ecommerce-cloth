<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\AttributeValue;
use App\Models\ProductVariant;
use App\Models\ProductVariantAttribute;

class ProductVariantSeeder extends Seeder
{
    public function run()
    {
        $products = Product::all();
        $sizeValues = AttributeValue::whereHas('attribute', fn($q) => $q->where('slug', 'size'))->pluck('id')->toArray();
        $colorValues = AttributeValue::whereHas('attribute', fn($q) => $q->where('slug', 'color'))->pluck('id')->toArray();

        foreach ($products as $product) {
            foreach ($sizeValues as $size) {
                foreach ($colorValues as $color) {
                    $variant = ProductVariant::create([
                        'product_id' => $product->id,
                        'sku' => 'SKU-' . $product->id . '-' . $size . '-' . $color,
                        'price' => rand(500, 2000),
                        'stock_qty' => rand(10, 50)
                    ]);

                    ProductVariantAttribute::create([
                        'product_variant_id' => $variant->id,
                        'attribute_id' => 1, // size
                        'attribute_value_id' => $size
                    ]);
                    ProductVariantAttribute::create([
                        'product_variant_id' => $variant->id,
                        'attribute_id' => 2, // color
                        'attribute_value_id' => $color
                    ]);
                }
            }
        }
    }
}
