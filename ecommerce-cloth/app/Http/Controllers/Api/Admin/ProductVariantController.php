<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\{
    Product,
    ProductVariant,
    ProductVariantAttribute
};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductVariantController extends Controller
{
    public function store(Request $request, Product $product)
    {
        DB::transaction(function () use ($request, $product) {

            $variant = ProductVariant::create([
                'product_id' => $product->id,
                'sku' => $request->sku,
                'price' => $request->price,
                'stock_qty' => $request->stock_qty
            ]);

            foreach ($request->attributes as $attr) {
                ProductVariantAttribute::create([
                    'product_variant_id' => $variant->id,
                    'attribute_id' => $attr['attribute_id'],
                    'attribute_value_id' => $attr['value_id'],
                ]);
            }
        });

        return response()->json(['message' => 'Variant created']);
    }

    public function destroy(ProductVariant $variant)
    {
        $variant->delete();
        return response()->json(['message' => 'Deleted']);
    }

    public function bulkStore(Request $request, Product $product)
    {
        $request->validate([
            'attributes' => 'required|array',
            'attributes.*' => 'required|array',
            'attributes.*.*' => 'required|exists:attribute_values,id',
            'base_price' => 'required|numeric',
            'stock_qty' => 'required|integer',
        ]);

        $combinations = generateCombinations($request->attributes);

        DB::transaction(function () use ($combinations, $product, $request) {
            foreach ($combinations as $combo) {

                // Check duplicate
                $exists = ProductVariant::where('product_id', $product->id)
                    ->whereHas('variantAttributes', function ($q) use ($combo) {
                        foreach ($combo as $value_id) {
                            $q->where('attribute_value_id', $value_id);
                        }
                    })->exists();

                if ($exists) continue;

                // Create Variant
                $variant = ProductVariant::create([
                    'product_id' => $product->id,
                    'sku' => generateSKU($product->id, $combo),
                    'price' => $request->base_price,
                    'stock_qty' => $request->stock_qty
                ]);

                // Save pivot
                foreach ($combo as $value_id) {
                    $attribute_id = \App\Models\AttributeValue::find($value_id)->attribute_id;
                    ProductVariantAttribute::create([
                        'product_variant_id' => $variant->id,
                        'attribute_id' => $attribute_id,
                        'attribute_value_id' => $value_id
                    ]);
                }
            }
        });

        return response()->json(['message' => 'Bulk variants created']);
    }

    public function bulkStockPriceUpdate(Request $request, Product $product)
    {
        $request->validate([
            'variants' => 'required|array',
            'variants.*.id' => 'required|exists:product_variants,id',
            'variants.*.price' => 'nullable|numeric',
            'variants.*.stock_qty' => 'nullable|integer',
        ]);

        DB::transaction(function () use ($request, $product) {
            foreach ($request->variants as $v) {
                $variant = $product->variants()->find($v['id']);
                if (!$variant) continue;

                $updateData = [];
                if (isset($v['price'])) $updateData['price'] = $v['price'];
                if (isset($v['stock_qty'])) $updateData['stock_qty'] = $v['stock_qty'];

                if (!empty($updateData)) {
                    $variant->update($updateData);
                }
            }
        });

        return response()->json(['message' => 'Variants updated successfully']);
    }
}
