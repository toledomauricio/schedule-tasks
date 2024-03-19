<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {

        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
        
        $user = User::where('email', $credentials['email'])->first();

        if ($user && Hash::check($credentials['password'], $user->password)) {

            // Auth::login($user);
            
            $token = $user->createToken('auth-token')->plainTextToken;

            return response()->json(['user' => $user, 'token' => $token], 200);
        }

        return response()->json(['message' => 'Invalid login credentials'], 401);
    }
}
