<?php

namespace App\Http\Controllers\Player;

use App\Http\Requests\Player\PlayerLoginRequest;
use App\Models\Player;
use App\Support\Facades\CacheService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class LogoutController
{
    public function __invoke()
    {
        $user = auth()->user();
        $user->tokens()->delete();
        CacheService::destroyAuthPlayerData($user->id);

        return response()->json([
            'message' => 'user logged out'
        ], 200);
    }
}
