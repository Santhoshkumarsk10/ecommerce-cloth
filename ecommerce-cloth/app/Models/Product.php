<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'description',
        'status',
        'min_price',
        'max_price',
        'total_stock',
    ];

    protected $casts = [
        'status' => 'boolean',
        'min_price' => 'float',
        'max_price' => 'float',
    ];

    /* 🔗 Relations */

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Future ready 🔥
    public function variants()
    {
        return $this->hasMany(ProductVariant::class);
    }
}
