<?php

namespace App\Http\Controllers\Rank;

use App\Http\Controllers\Controller;
use App\Http\Resources\RankResource;
use App\Models\Rank;

class IndexController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke()
    {
        return (RankResource::collection(Rank::active()->with(['player', 'group'])->get()))
            ->response()
            ->setStatusCode(200);
    }
}
