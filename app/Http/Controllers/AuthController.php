<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

use Illuminate\Http\Response;

use Illuminate\Support\Facades\Auth;

use Illuminate\Validation\Rules\Password;
use App\Services\EmailVerificationService;
use Illuminate\Validation\ValidationException;




class AuthController extends Controller
{
    //
    public function register(Request $request)
    {
        try {
            $data = $request->validate([
                'first_name' => 'required|string',
                'last_name' => 'required|string',
                'agree_terms_conditions' => 'required|boolean',
                'email' => 'required|email|string|unique:users,email',
                'password' => ['required', Password::min(8)->mixedCase()->numbers()],
            ]);

            // Create the user
            $user = User::create([
                'first_name' => $data['first_name'],
                'last_name' => $data['last_name'],
                'agree_terms_conditions' => $data['agree_terms_conditions'],
                'email' => $data['email'],
                'password' => bcrypt($data['password']),
            ]);

            $token = $user->createToken('main')->plainTextToken;

            // Send verification email
            EmailVerificationService::sendVerificationEmail($user);

            return response()->json(
                [
                    'user' => $user,
                    'message' => 'User created successfully. Please check your email to verify your account.',
                    'token' => $token,
                ],
                201
            ); // 201 Created

        } catch (ValidationException $e) {

            return response()->json(
                [
                    'message' => 'Validation errors',
                    'errors' => $e->errors(),
                ],
                422
            );
        } catch (\Exception $e) {

            return response()->json(
                [
                    'message' => 'An error occurred during registration. Please try again later.',
                ],
                500
            );
        }
    }

    public function login(Request $request)
    {
        try {
            $credentials = $request->validate([

                'email' => 'required|email|string|exists:users,email',
                'password' => [
                    'required',
                ],

            ]);

            if (!Auth::attempt($credentials)) {
                return response([
                    'error' => 'The Provided credentials are not correct'
                ], 422);
            }

            /** @var \App\Models\User $user */
            $user = Auth::user();
            $token = $user->createToken('main')->plainTextToken;

            return response([
                'message' => 'User Logged In Successfully',
                'user' => $user,
                'token' => $token
            ]);
        } catch (\Exception $e) {

            return response()->json(
                [
                    'message' => 'An error occurred while logging in, please try again',
                ],
                500
            );
        }
    }

    public function logout()
    {
        /** @var User $user */
        $user = Auth::user();
        // Revoke the token that was used to authenticate the current request...
        $user->currentAccessToken()->delete();

        // return response([
        //     'success' => true
        // ]);
        return response()->json(['message' => 'Logged out successfully'], Response::HTTP_OK);
        // }
        // return response()->json(['message' => 'User not authenticated'], Response::HTTP_UNAUTHORIZED);
    }

    // public function getUser()
    // {
    //     $user = Auth::user();

    //     return response([
    //         'message' => 'Successfully fetched data ',
    //         'data' => $user
    //     ]);
    // }
}
