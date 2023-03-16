<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ApiAuthController extends Controller
{
     public function register(Request $request)
    {
        $fields = $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|unique:users,email',
            'password' => 'required|string|confirmed',
        ]);

        $user = User::create([
            'name' => $fields['name'],
            'email' => $fields['email'],
            'password' => Hash::make($fields['password'])
        ]);

        $token = $user->createToken('appToken')->plainTextToken;

        return response(['user' => $user, 'token' => $token]);
    }
    public function login(Request $request)
    {
        $fields = $request->validate([
            'email' => 'required|string',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $fields['email'])->first();
        if ($user && Auth::attempt(['email' => $fields['email'], 'password' => $fields['password']])) {
            return response(['user' => $user, 'token' => $user->createToken('appToken')->plainTextToken]);
        }

        return response(["message" => "Invalid authentication credentials"], 401);
    }

    public function logout()
    {
        Auth::user()->tokens()->delete();
        return ['message' => 'See ya, latter, aligater...'];
    }
}

