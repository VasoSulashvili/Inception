<?php

namespace App\Http\Controllers\Spinner;

use App\Actions\Log\StoreLog;
use App\Actions\Spinner\TriggerSpinner;
use App\Enums\Log\LogActions;
use App\Exceptions\UnfulfilledException;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TriggerController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, TriggerSpinner $action, StoreLog $logAction)
    {
        try {
            DB::beginTransaction();

            // Prize winning action
            $prizeId = $action->handle();

            // Store Log
            $logAction->handle(
                LogActions::PRIZE_WINNING,
                auth()->user()->id,
                $prizeId,
            );
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw new UnfulfilledException($e->getMessage());
        }

        return response()->json([
            'message' => 'Congratulations! You won a prize'
        ], 200);
    }
}
