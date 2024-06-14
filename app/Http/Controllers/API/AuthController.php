<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // Proses Login pada controller auth
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if ($user && Hash::check($request->password, $user->password)) {
            $token = $user->createToken('SanctumAuthToken')->plainTextToken;

            return response()->json([
                'status' => true,
                'data' => ['token' => $token],
                'message' => 'Login berhasil'
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'data' => null,
                'message' => 'Login gagal'
            ], 401);
        }
    }


    // Proses get profil user yang sudah login
    public function getProfile(Request $request)
    {
        $user = Auth::user();

        if ($user) {
            return response()->json([
                'status' => true,
                'data' => $user,
                'message' => 'Get sukses'
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'data' => null,
                'message' => 'Data kosong'
            ], 401);
        }
    }

    // Proses update profil
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json([
                'status' => false,
                'data' => null,
                'message' => 'User tidak ditemukan'
            ], 404);
        }

        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|string',
        ]);

        // Update data user
        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return response()->json([
            'status' => true,
            'data' => ['id' => $user->id],
            'message' => 'Update profil berhasil'
        ], 200);
    }
}
