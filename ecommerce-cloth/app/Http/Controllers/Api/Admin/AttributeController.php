<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attribute;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AttributeController extends Controller
{
    public function index()
    {
        return Attribute::with('values')->get();
    }

    public function store(Request $request)
    {
        $attr = Attribute::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name)
        ]);

        foreach ($request->values as $value) {
            $attr->values()->create(['value' => $value]);
        }

        return $attr->load('values');
    }

    public function update(Request $request, Attribute $attribute)
    {
        $attribute->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name)
        ]);

        return $attribute;
    }

    public function destroy(Attribute $attribute)
    {
        $attribute->delete();
        return response()->json(['message' => 'Deleted']);
    }
}
