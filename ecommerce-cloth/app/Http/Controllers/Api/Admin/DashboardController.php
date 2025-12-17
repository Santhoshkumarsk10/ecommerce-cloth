<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $totalCategories = Category::count();
        $totalProducts = Product::count();
        $totalVariants = ProductVariant::count();
        // Low stock variants (threshold = 10)
        $lowStockVariants = ProductVariant::where('stock_qty', '<', 10)->count();
        // Stock summary for charts (optional)
        $stockSummary = ProductVariant::select(
            DB::raw("CASE
                WHEN stock_qty = 0 THEN 'Out of Stock'
                WHEN stock_qty < 10 THEN 'Low Stock'
                ELSE 'In Stock' END as stock_status"),
            DB::raw("count(*) as total")
        )
            ->groupBy('stock_status')
            ->get();
        return response()->json([
            'total_categories' => $totalCategories,
            'total_products' => $totalProducts,
            'total_variants' => $totalVariants,
            'low_stock_variants' => $lowStockVariants,
            'stock_summary' => $stockSummary
        ]);
    }
}
