<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ShippingAddress;
use Illuminate\Support\Facades\Auth;

class ShippingAddressController extends Controller

{
    public function get_shipping_addresses()
    {
        $addresses = Auth::user()->addresses;

        return response([
            'message' => 'Successfully fetched data ',
            'data' => $addresses
        ]);
    }

    public function add_shipping_address(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'state' => 'required|json',
            'city' => 'required|json',
            'delivery_address' => 'required|string|max:255',
            'additional_information' => 'nullable|string|max:255',
            'phone_number' => 'required|string',
            'is_default' => 'sometimes|boolean'
        ]);

        Auth::user()->addresses()->create($request->all());

        return response([
            'message' => 'Shipping addresss created successfully',
        ]);
    }
    public function edit_shipping_addresses(Request $request, $id)
    {
        $request->validate([
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'state' => 'required|json',
            'city' => 'required|json',
            'delivery_address' => 'required|string|max:255',
            'additional_information' => 'nullable|string|max:255', // Allow null values
            'phone_number' => 'required|string',
            'is_default' => 'sometimes|boolean'
        ]);

        $addresses =
            Auth::user()->addresses()->findOrFail($id);

        $addresses->update($request->all());

        // Save the updated user
        $addresses->save();

        return response([
            'message' => 'Edited Successfully  ',

        ]);
    }

    public function single_shipping_address_detail($id)
    {
        $single_addresses =
            Auth::user()->addresses()->findOrFail($id);

        return response([
            'message' => 'Successfully fetched data ',
            'data' =>  $single_addresses
        ]);
    }
    public function set_address_toDefault(ShippingAddress $id)
    {
        $user = Auth::user();

        // set other addrress to false
        $user->addresses()->update(['is_default' => false]);

        // Set the selected address to default
        $id->update(['is_default' => true]);


        return response([
            'message' => 'Set as default address ',

        ]);
    }
    public function getDefaultAddress()
    {
        $user = Auth::user();

        // set other addrress to false
        $defaultAddress = $user->addresses()->where('is_default', true)->first();


        return response()->json([
            'message' => 'Default address retrieved successfully',
            'data' => $defaultAddress,
        ]);
    }
    public function Delete_address(ShippingAddress $id)
    {
        $user = Auth::user();

        if ($id->is_default == 1) {
            return response()->json(['message' => 'Cannot delete the default address'], 400);
        }

        $id->delete();

        return response([
            'message' => 'Deleted successfully ',

        ]);
    }
}
