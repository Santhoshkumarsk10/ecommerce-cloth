<?php

use App\Http\Controllers\Api\AuthController;
use Illuminate\Support\Facades\Route;


Route::post('login', [AuthController::class, 'login']);

Route::middleware('auth:api')->group(function () {
    Route::get('me', [AuthController::class, 'me']);
    Route::post('logout', [AuthController::class, 'logout']);
});

use App\Http\Controllers\Api\Admin\{
    CategoryController,
    AttributeController,
    ProductController,
    ProductVariantController,
    ProductImageController,
    DashboardController
};

// Route::middleware(['auth:api', 'admin'])->prefix('admin')->group(function () {
    Route::get('dashboard-stats', [DashboardController::class, 'index']);
    // Category
    Route::apiResource('categories', CategoryController::class);

    // Attribute + Values
    Route::apiResource('attributes', AttributeController::class);

    // Product
    Route::apiResource('products', ProductController::class);
    Route::post('products/{product}/bulk-variants', [ProductVariantController::class, 'bulkStore']);
    Route::post('products/{product}/bulk-stock-price', [ProductVariantController::class, 'bulkStockPriceUpdate']);
    Route::middleware(['auth:api', 'permission:create-product'])->post('/admin/products', [ProductController::class, 'store']);

    // Variants
    Route::post('products/{product}/variants', [ProductVariantController::class, 'store']);

    Route::post('products/{product}/images', [ProductImageController::class, 'store']);
    Route::delete('product-images/{image}', [ProductImageController::class, 'destroy']);

    Route::delete('variants/{variant}', [ProductVariantController::class, 'destroy']);
// });
