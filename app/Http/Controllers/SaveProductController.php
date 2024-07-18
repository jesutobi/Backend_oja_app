<?php

namespace App\Http\Controllers;

use App\Models\SaveProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SaveProductController extends Controller
{
    public function save_product(Request $request)
    {
        $request->validate([
            'user_id' => 'required|integer',
            'product_id' => 'required|integer'
        ]);

        $existingSavedItem = SaveProduct::where('product_id', $request->product_id)->first();

        if ($existingSavedItem) {
            $existingSavedItem->delete();

            return response()->json([
                'message' => 'Product unsaved successfully',
                'keyword' => 'unsaved',
                'deletedItem' => $existingSavedItem
            ], 201);
        } else {
            $savedProduct =  SaveProduct::create([
                'user_id' => $request->user_id,
                'product_id' => $request->product_id,

            ]);

            // Fetch all saved products for the user
            $savedProducts = SaveProduct::where('user_id', $request->user_id)->get();


            return response()->json([
                'message' => 'Product saved successfully',
                'keyword' => 'saved',
                'savedProducts' =>  $savedProducts
            ], 201);
        }
    }

    public function  get_saved_product($id)
    {
        $getsavedProducts =  SaveProduct::where('user_id', $id)->with('product.images')->get();

        return response()->json([
            'message' => 'Product saved successfully',
            'savedProductsDetails' => $getsavedProducts
        ], 201);
    }
}
