<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class UpdateUserController extends Controller
{
    // Retrieve the authenticated user
    public function user()
    {

        $user = Auth::user();

        return response()->json($user);
    }
    // Update the authenticated user data
    public function update_user(Request $request)
    {
        // Log the incoming request data
        Log::info('Update User Request Data:', $request->all());

        // Validate the request data
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'phone_number' => 'string|min:11',
            'state' => 'json',
            'home_address' => 'string|max:255',
        ]);

        // Get the authenticated user
        $user = Auth::user();

        // Update user's name and other fields
        $user->first_name = $request->input('first_name');
        $user->last_name  = $request->input('last_name');
        // $user->email = $request->input('email'); // Uncomment if you want to update email
        $user->phone_number = $request->input('phone_number');
        $user->state = $request->input('state');
        $user->home_address = $request->input('home_address');

        // Save the updated user
        $user->save();

        return response()->json(['message' => 'User updated successfully']);
    }
}
