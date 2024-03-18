<?php

namespace App\Http\Controllers\Prize;

use App\Actions\Prize\UpdatePrize;
use App\Http\Controllers\Controller;
use App\Http\Requests\Prize\UpdatePrizeRequest;
use App\Http\Resources\PrizeResource;
use App\Models\Prize;

class UpdateController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(UpdatePrizeRequest $request, Prize $prize, UpdatePrize $action)
    {
        return (new PrizeResource($action->handle($request, $prize)))
            ->response()
            ->setStatusCode(200);
    }
}
