<?php

namespace App\Http\Controllers\Rank;

use App\Actions\Rank\AssignGroup;
use App\Http\Controllers\Controller;
use App\Http\Resources\RankResource;
use Illuminate\Http\Request;

class AssignGroupController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, AssignGroup $action)
    {
        return (new RankResource($action->handle($request)))
            ->response()
            ->setStatusCode(200);
    }
}
