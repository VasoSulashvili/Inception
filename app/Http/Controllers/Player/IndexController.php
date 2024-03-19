<?php

namespace App\Http\Controllers\Player;

use App\Http\Controllers\Controller;
use App\Http\Resources\PlayerResource;
use App\Models\Player;

class IndexController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke()
    {
        return (PlayerResource::collection(Player::active()->with(['rank', 'prizes'])->get()))
            ->response()
            ->setStatusCode(200);
    }
}
