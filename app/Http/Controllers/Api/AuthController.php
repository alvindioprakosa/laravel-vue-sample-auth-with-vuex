<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class AuthController extends Controller
{
    /**
     * Handle user login and issue access token
     */
    public function login(Request $request)
    {
        // Validate the request
        $validator = Validator::make($request->all(), [
            'email'    => 'required|email',
            'password' => 'required|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors'  => $validator->errors()
            ], 422);
        }

        // Attempt login
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();

            // Generate access token
            $token = $user->createToken('MyApp')->accessToken;

            return response()->json([
                'success' => true,
                'message' => 'User logged in successfully.',
                'token'   => $token,
                'user'    => [
                    'id'    => $user->id,
                    'name'  => $user->name,
                    'email' => $user->email,
                ],
            ], 200);
        }

        return response()->json([
            'success' => false,
            'error'   => 'Unauthorized'
        ], 401);
    }

    /**
     * Logout user (revoke access token)
     */
    public function logout(Request $request)
    {
        if ($request->user()) {
            $request->user()->token()->revoke();

            return response()->json([
                'success' => true,
                'message' => 'Successfully logged out.'
            ], 200);
        }

        return response()->json([
            'success' => false,
            'error'   => 'User not authenticated.'
        ], 401);
    }
}
