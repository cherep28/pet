<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use Illuminate\Http\JsonResponse;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    private int $tokenLifeTimeSecond = 900;

    public function login(LoginRequest $request): JsonResponse{
        $data = $request->validated();
        $user = User::where('email', $data['email'])->first();

        if(!$user || !Hash::check($data['password'], $user->password)){
            return response()->json([
                'message' => 'Неверный email или пароль'
            ], 401);
        }

        $accessToken = $user->createToken(
            'news-api',
            ['*'],
            now()->addSeconds($this->tokenLifeTimeSecond)
        );

        return response()->json([
            'access_token'  => $accessToken->plainTextToken,
            'token_type'    => 'Bearer',
            'expires_in'    => $this->tokenLifeTimeSecond,
        ])->header('Cache-Control', 'no-store');
    }
}
