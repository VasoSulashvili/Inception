<?php

namespace App\Http\Controllers\Player;

use App\Http\Requests\Player\PlayerLoginRequest;
use App\Models\Player;
use App\Support\Facades\CacheService;
use Illuminate\Support\Facades\Auth;

class LoginController
{
    public function __invoke(PlayerLoginRequest $request)
    {
        if(!Auth::guard('player')->attempt($request->only('email', 'password'))) {
            return response()->json(['errors' => 'Invalid Credentials!'], 401);
        }

        $user = Player::where('email', '=', $request->input('email'))->first();
        CacheService::destroyAuthPlayerData($user->id);
        $token = $user->createToken('auth', ['role:player'])->plainTextToken;

        return response()->json([
            'user' => $user,
            'token' => $token
        ], 200);
    }
}
