<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function auth()
    {
        $user = Auth::user();
        return response()->json([
            'success' => true,
            'user' => $user,
        ]);
    }
    public function login(Request $request)
    {
        if (Auth::attempt($request->only('name', 'password'))) {
            $user = Auth::user();
            $token = User::find($user->id)->createToken('auth_token')->plainTextToken;
            return response()->json([
                'user' => $user,
                'success' => true,
                'token' => $token,
                'msg' => 'Welcome back !',

            ]);
        }
        return response()->json([
            'success' => false,
            'msg' => 'The credentials provided are incorrect',
        ], 401);
    }
    public function logout(Request $request)
    {
        if ($request->user()->currentAccessToken()->delete()) {

            return response()->json([
                'success' => true,
                'user' => $request->user(),
            ]);
        }
    }

}
