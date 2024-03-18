<?php

namespace App\Http\Controllers\Prize;

use App\Actions\Prize\AssignGroup;
use App\Http\Controllers\Controller;
use App\Http\Requests\Prize\StorePriceGroupRequest;
use App\Http\Resources\RankResource;
use Illuminate\Http\Request;

class AssignPrizeController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(StorePriceGroupRequest $request, AssignGroup $action)
    {
        $action->handle($request);
        return response()->json([
            'message' => 'Prize assigned to group successfully!'
        ], 200);
    }
}
