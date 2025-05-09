<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate(['email' => 'required|email', 'password' => 'required']);
        $user = User::where('email', $request->email)->first();
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['success' => false, 'message' => 'Invalid credentials'], 401);
        }
        $token = $user->createToken('app-token')->plainTextToken;
        return response()->json(['success' => true, 'message' => 'Login successful', 'token' => $token, 'data' => $user]);
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;
        return response()->json([
            'success' => true,
            'message' => 'User registered successfully',
            'token' => $token,
            'data' => $user
        ], 201);
    }

    public function user(Request $request)
    {
        return response()->json([
            'success' => true,
            'message' => 'User retrieved',
            'data' => $request->user()
        ], 200);
    }

    public function update(Request $request)
    {
        $user = $request->user();
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->user_id . ',user_id',
            'phone_number' => 'nullable|string|max:11',
        ]);

        $user->update($request->only(['name', 'email', 'phone_number']));
        return response()->json([
            'success' => true,
            'message' => 'Profile updated',
            'data' => $user
        ], 200);
    }
}