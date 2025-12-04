<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User; // Pastikan model User diimpor

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // Ambil user berdasarkan email
        $user = User::where('email', $request->email)->first();

        // Periksa apakah user ditemukan DAN password cocok
        if (! $user ) {
            return response()->json([
                'message' => 'Invalid credentials'
            ], 401);
        }
        return response()->json([
            'message' => 'Login successful',
            'token_type' => 'Bearer', // Opsional
            'user' => $user // Opsional: kembalikan data user
        ]);
    }

    // Jika kamu menambahkan logout
    public function logout(Request $request)
    {
        // Ambil user yang sedang login berdasarkan token Sanctum
        $user = $request->user(); // Ini bekerja karena middleware 'auth:sanctum'

        if ($user) {
            // Hapus token yang sedang digunakan
            $user->currentAccessToken()->delete();
            return response()->json(['message' => 'Logged out successfully']);
        }

        return response()->json(['message' => 'No active session'], 401);
    }
}