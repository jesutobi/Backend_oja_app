<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function get_featured_product()
    {
        $products = Product::where('featured', 1)->with('images')->get();

        return response()->json(['message' => 'Featured product fetched successfully', 'data' => $products]);
    }
    public function new_arrival()
    {
        $dateThreshold = now()->subDays(1);

        $new_arrival = Product::where('created_at', '>=', $dateThreshold)->with('images')->get();

        return response()->json(['message' => 'new arrival successfully fetched', 'data' => $new_arrival]);
    }
}
