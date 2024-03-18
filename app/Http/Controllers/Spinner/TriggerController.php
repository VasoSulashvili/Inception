<?php

namespace App\Http\Controllers\Spinner;

use App\Actions\Group\GenerateData;
use App\Actions\Spinner\TriggerSpinner;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TriggerController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, TriggerSpinner $action)
    {
        return $action->handle();
        return 1;
    }
}
