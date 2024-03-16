<?php

namespace App\Http\Controllers\Player;

use App\Http\Requests\Player\LoginRequest;
use App\Models\Player\Player;
use Illuminate\Support\Facades\Auth;

class AuthController
{
    public function login(LoginRequest $request)
    {
        if(!Auth::guard('player')->attempt($request->only('email', 'password'))) {
            return response()->json(['errors' => 'Invalid Credentials!'], 401);
        }

        $user = Player::where('email', '=', $request->input('email'))->first();
        $token = $user->createToken('auth', ['role:player'])->plainTextToken;

        return response()->json([
            'user' => $user,
            'token' => $token
        ], 200);
    }
}
