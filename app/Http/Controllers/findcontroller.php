<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\productCategory;

class findcontroller extends Controller
{
    public function search(Request $request)
    {
        $query = $request->input('query');

        // Using 'like' for partial match search
        $searchQuery = Product::with(['images', 'category'])->where('product_title', 'like', "%{$query}%")
            ->orWhere('product_brand', 'like', "%{$query}%");

        $searchResults = $searchQuery->paginate(10);

        return response()->json(['products' => $searchResults], 200);
    }
    public function search_Products_By_Category(Request $request)
    {
        // $id = $request->input('id');
        $query = $request->input('query');


        $category = productCategory::findOrFail($request->id);
        $productsResult = $category->products()->with('images')->where('product_title', 'like', "%{$query}%");
        // ->orWhere('product_brand', 'like', "%{$query}%");

        $products = $productsResult->paginate(10);

        return response()->json(['category' => $category, 'products' => $products], 200);
    }
}
