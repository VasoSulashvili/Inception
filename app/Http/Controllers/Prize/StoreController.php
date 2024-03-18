<?php

namespace App\Http\Controllers\Prize;

use App\Actions\Prize\StorePrize;
use App\Http\Controllers\Controller;
use App\Http\Requests\Prize\StorePrizeRequest;
use App\Http\Resources\PrizeResource;

class StoreController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(StorePrizeRequest $request, StorePrize $storePrize)
    {
        return (new PrizeResource($storePrize->handle($request)))
            ->response()
            ->setStatusCode(201);
    }
}
