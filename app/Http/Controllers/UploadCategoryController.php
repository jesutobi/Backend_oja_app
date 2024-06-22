<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\productCategory;

class UploadCategoryController extends Controller
{
    public function UploadCategory(Request $request)
    {
        $data = $request->validate([
            'category_title' => 'required|string',
            'hero_image' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
            'card_image' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);


        $heroImagePath = $request->hasFile('hero_image')
            ? $request->file('hero_image')->store('uploads/hero_images', 'public')
            : null;

        $cardImagePath = $request->hasFile('card_image')
            ? $request->file('card_image')->store('uploads/card_images', 'public')
            : null;

        $productCategory = productCategory::create([
            'category_title' => $data['category_title'],

            'hero_image' => $heroImagePath,
            'card_image' => $cardImagePath,
        ]);


        return response()->json(['message' => 'Product category created successfully', 'productCategory' => $productCategory], 201);
    }

    public function get_product_category()
    {
        $categories = productCategory::get();

        return response()->json(['categories' => $categories], 200);
    }
}
