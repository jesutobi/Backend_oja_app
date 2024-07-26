<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\ProductReview;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function get_featured_product()
    {
        $products = Product::where('featured', 1)->with('images')->get();

        return response()->json(['message' => 'Featured product fetched successfully', 'data' => $products]);
    }
    public function new_arrival()
    {
        $dateThreshold = now()->subDays(2);

        $new_arrival = Product::where('created_at', '>=', $dateThreshold)->with('images')->get();

        return response()->json(['message' => 'new arrival successfully fetched', 'data' => $new_arrival]);
    }
    public function get_product_detail($id)
    {
        $product_detail = Product::with('images', 'savedItems')->findOrFail($id);
        return response()->json(['message' => 'Successfully fetched product detail', 'data' => $product_detail]);
    }

    public function post_product_review(Request $request, $id)
    {
        $request->validate([
            'content' => 'required|string|max:1000',
            'rating' => 'required|integer',
        ]);

        $product = Product::findOrFail($id);

        // Create a new review associated with the authenticated user and the specified product
        $review = Auth::user()->reviews()->create([
            'product_id' => $product->id,
            'user_id' => Auth::id(),
            'content' => $request->content,
            'rating' => $request->rating,
        ]);

        //    Auth::User
        return response()->json(['message' => 'Review Uploaded', 'data' => $review]);
    }
    public function get_product_review($id)
    {
        $product = Product::with(['reviews.user'])->findOrFail($id);

        return response()->json(['message' => 'Successfully fetched reviews ', 'data' => $product]);
    }
    public function get_similar_products($id)
    {
        // Fetch the product by ID
        $product = Product::find($id);

        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        // Fetch related products based on the same category title
        $categoryId = $product->category_id;

        $relatedProducts = Product::with('images')
            ->where('category_id', $categoryId) // Access JSON key
            ->where('id', '!=', $id) // Exclude the current product
            ->get();
        return response()->json(['message' => 'Successfully fetched related products', 'data' => $relatedProducts]);
    }
}
