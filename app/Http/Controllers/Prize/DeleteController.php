<?php

namespace App\Http\Controllers\Prize;

use App\Actions\Prize\DeletePrize;
use App\Http\Controllers\Controller;
use App\Models\Prize;

class DeleteController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Prize $prize, DeletePrize $action)
    {
        $action->handle($prize);
        return response()
            ->json('', 204);
    }
}
