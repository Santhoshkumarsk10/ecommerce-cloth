<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index()
    {
        return Product::with('category')->latest()->get();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string',
            'description' => 'nullable'
        ]);

        $data['slug'] = Str::slug($data['name']);

        return Product::create($data);
    }

    public function show(Product $product)
    {
        return $product->load('variants.variantAttributes.value');
    }

    public function update(Request $request, Product $product)
    {
        $product->update($request->only('name', 'description', 'status'));
        return $product;
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return response()->json(['message' => 'Deleted']);
    }
}
