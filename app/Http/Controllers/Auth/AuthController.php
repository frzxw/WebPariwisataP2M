<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use App\Services\AuthService;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function __construct(private AuthService $authService) {}

    public function register(RegisterRequest $request)
    {
        try {
            $user = $this->authService->register($request->validated());
            $token = $user->createToken('auth')->plainTextToken;
            
            return response()->json([
                'success' => true,
                'message' => 'Registration successful',
                'user' => $user,
                'token' => $token
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 422);
        }
    }

    public function login(LoginRequest $request)
    {
        try {
            $result = $this->authService->login($request->validated());
            
            return response()->json([
                'success' => true,
                'message' => 'Login successful',
                'user' => $result['user'],
                'token' => $result['token']
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 401);
        }
    }

    public function logout(Request $request)
    {
        try {
            $request->user()->currentAccessToken()->delete();
            
            return response()->json([
                'success' => true,
                'message' => 'Logged out successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function me(Request $request)
    {
        return response()->json([
            'success' => true,
            'user' => $request->user()
        ]);
    }
}
