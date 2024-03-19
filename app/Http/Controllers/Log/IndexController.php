<?php

namespace App\Http\Controllers\Log;

use App\Http\Controllers\Controller;
use App\Http\Resources\LogResource;
use App\Http\Resources\RankResource;
use App\Models\Log;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        return (LogResource::collection(Log::all()))
            ->response()
            ->setStatusCode(200);
    }
}
