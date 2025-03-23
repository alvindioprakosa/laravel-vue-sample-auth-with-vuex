<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    /**
     * Login API
     */
    public function login(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        // Proses login
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();
            $token = $user->createToken('MyApp')->accessToken;

            return response()->json([
                'success' => true,
                'message' => 'User login successfully.',
                'token' => $token,
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                ],
            ], 200);
        }

        return response()->json(['error' => 'Unauthorized'], 401);
    }

    /**
     * Logout API
     */
    public function logout(Request $request)
    {
        if (Auth::check()) {
            $request->user()->token()->revoke(); // Menghapus token (Laravel Passport)
            return response()->json(['message' => 'Successfully logged out'], 200);
        }

        return response()->json(['error' => 'User not authenticated'], 401);
    }
}
