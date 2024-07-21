<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller {
    public function register(Request $request) {
        $data = $request->validate([
            'username' => 'required|unique:users',
            'name' => 'required',
            'email' => 'required|unique:users',
            'password' => 'required|confirmed|min:8',
            'role' => 'in:admin,staff,user',
        ]);

        $userData = array_merge($data, ['role' => $data['role'] ?? 'user']);

        $user = User::create($userData);
        $token = $user->createToken('user-token')->plainTextToken;

        return response()->json([
            'token' => $token,
            'Type' => 'Bearer'
        ]);
    }

    public function login(Request $request) {
        $fields = $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $user = User::where('username', $fields['username'])->first();

        if (!$user || !Hash::check($fields['password'], $user->password)) {
            return response()->json([
                'message' => 'Invalid username or password',
            ], 401);
        }

        $token = $user->createToken('my-token')->plainTextToken;

        return response()->json([
            'token' => $token,
            'Type' => 'Bearer',
            'role' => $user->role
        ]);
    }
}
