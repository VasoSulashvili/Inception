<?php

namespace App\Http\Controllers\Rank;

use App\Enums\Rank\RankGroup;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, $group)
    {
        dd(RankGroup::cases());
        //
    }
}
