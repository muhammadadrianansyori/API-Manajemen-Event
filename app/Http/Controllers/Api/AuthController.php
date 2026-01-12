<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Helpers\LogHelper; // Import Helper Log

class AuthController extends Controller
{
    // ====================
    // REGISTER USER
    // ====================
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'phone'    => 'nullable|string|max:20',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors'  => $validator->errors()
            ], 422);
        }

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'phone'    => $request->phone ?? null,
        ]);

        // LOG: Registrasi User Baru
        LogHelper::saveLog('Register', 'User baru terdaftar: ' . $user->email);

        return response()->json([
            'success' => true,
            'message' => 'User berhasil terdaftar',
            'user'    => $user
        ], 201);
    }

    // ====================
    // LOGIN USER
    // ====================
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email'    => 'required|email',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors'  => $validator->errors()
            ], 422);
        }

        $credentials = $request->only('email', 'password');

        if (!$token = JWTAuth::attempt($credentials)) {
            return response()->json([
                'success' => false,
                'message' => 'Email atau password salah'
            ], 401);
        }

        $user = auth('api')->user();

        // LOG: Login Berhasil
        LogHelper::saveLog('Login', 'User ' . $user->name . ' berhasil login.');

        return response()->json([
            'success'      => true,
            'access_token' => $token,
            'token_type'   => 'Bearer',
            'expires_in'   => JWTAuth::factory()->getTTL() * 60,
            'user'         => $user
        ]);
    }

    // ====================
    // GET CURRENT USER
    // ====================
    public function me()
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();
        } catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
            return response()->json(['success'=>false,'message'=>'Token expired'],401);
        } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
            return response()->json(['success'=>false,'message'=>'Token invalid'],401);
        } catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {
            return response()->json(['success'=>false,'message'=>'Token not provided'],401);
        }

        return response()->json([
            'success' => true,
            'user'    => $user
        ]);
    }

    // ====================
    // LOGOUT USER
    // ====================
    public function logout()
    {
        try {
            $user = auth('api')->user();

            // LOG: Logout (Lakukan sebelum token di-invalidate)
            if ($user) {
                LogHelper::saveLog('Logout', 'User ' . $user->name . ' melakukan logout.');
            }

            JWTAuth::parseToken()->invalidate();
        } catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {
            return response()->json(['success'=>false,'message'=>'Gagal logout, token bermasalah'],401);
        }

        return response()->json([
            'success' => true,
            'message' => 'Berhasil logout'
        ]);
    }
}
