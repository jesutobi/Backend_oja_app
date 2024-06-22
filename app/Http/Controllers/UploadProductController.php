<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Support\Str;
use App\Models\ProductImage;
use Illuminate\Http\Request;


class UploadProductController extends Controller
{
    public function UploadProduct(Request $request)
    {
        $data =  $request->validate([
            'product_title' => 'required|string',
            'product_price' => 'required|string',
            'product_description' => 'required|string',
            'product_quantity' => 'required|string',
            'product_brand' => 'required|string',
            'product_category' => 'required|json',
            'featured' => 'boolean',
            'selected_product_feature' => 'required|json',
            'product_images' => 'required|array',
            'product_images.*' => 'max:2048',

        ]);

        $slug = Str::slug($data['product_title'], '_');

        $products = Product::create([
            'product_title' => $data['product_title'],
            'slug' => $slug,
            'product_price' => $data['product_price'],
            'product_description' => $data['product_description'],
            'product_quantity' => $data['product_quantity'],
            'product_brand' => $data['product_brand'],
            'product_category' => $data['product_category'],
            'featured' => $data['featured'],
            'selected_product_feature' => $data['selected_product_feature'],
        ]);

        $allowedFileExtensions = ['jpeg', 'jpg', 'png', 'gif', 'avif'];

        // Handle the product images
        if ($request->hasFile('product_images')) {
            foreach ($request->file('product_images') as $image) {
                $extension = $image->getClientOriginalExtension();
                if (!in_array($extension, $allowedFileExtensions)) {
                    return response()->json(['error' => 'Images must be jpeg, jpg, png, gif, or avif!'], 422);
                }
                $path = $image->store('uploads/product_images', 'public');
                ProductImage::create([
                    'product_id' => $products->id,
                    'image_path' => $path,
                ]);
            }
        }


        return response()->json(['message' => 'Product  created successfully', 'data' => $products->load('images')], 201);
    }
}
