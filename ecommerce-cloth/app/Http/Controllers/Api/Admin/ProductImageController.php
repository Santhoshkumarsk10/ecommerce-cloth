<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductImageController extends Controller
{
    public function store(Request $request, Product $product)
    {
        $request->validate([
            'images.*' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
            'variant_id' => 'nullable|exists:product_variants,id',
            'is_main' => 'nullable|boolean'
        ]);

        $uploaded = [];

        foreach ($request->file('images') as $file) {
            $path = $file->store('products', 'public');

            $image = ProductImage::create([
                'product_id' => $product->id,
                'product_variant_id' => $request->variant_id,
                'path' => $path,
                'is_main' => $request->is_main ?? false
            ]);

            $uploaded[] = $image;
        }

        return response()->json($uploaded);
    }

    public function destroy(ProductImage $image)
    {
        if (Storage::disk('public')->exists($image->path)) {
            Storage::disk('public')->delete($image->path);
        }

        $image->delete();
        return response()->json(['message' => 'Deleted']);
    }
}
