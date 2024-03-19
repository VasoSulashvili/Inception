<?php

namespace App\Http\Controllers\Rank;

use App\Enums\Rank\RankGroup;
use App\Http\Controllers\Controller;
use App\Http\Resources\PrizeResource;
use App\Http\Resources\RankResource;
use App\Models\Rank;
use Illuminate\Http\Request;

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
