<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\productFeature;

class UploadFeatureController extends Controller
{
    public function UploadFeature(Request $request)
    {
        // Validate the request
        $request->validate([
            'feature_title' => 'required|string'
        ]);

        // Create the feature
        $feature = productFeature::create([
            'feature_title' => $request->feature_title
        ]);

        // Return a response with status code
        return response()->json([
            'message' => 'Feature added successfully',
            'data' => $feature,
        ], 201);
    }
    public function get_product_feature()
    {
        // Create the feature
        $feature = productFeature::all();

        // Return a response with status code
        return response()->json([
            'message' => 'Features retrieved successfully',
            'data' => $feature,
        ], 201);
    }
}
