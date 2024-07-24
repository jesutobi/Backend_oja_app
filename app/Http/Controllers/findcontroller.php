<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

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
}
