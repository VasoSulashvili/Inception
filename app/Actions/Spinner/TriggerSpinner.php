<?php

declare(strict_types=1);

namespace App\Actions\Spinner;

use App\Actions\Group\GenerateData;
use App\Traits\HasGroupData;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use App\Exceptions\UnfulfilledException;
use Illuminate\Http\Request;
use App\Models\Group;
use App\Models\Rank;

class TriggerSpinner
{
    use HasGroupData;
    /**
     * @return mixed
     * @throws UnfulfilledException
     */
    public function handle()
    {
        try {
            // Get auth user
            $player = auth()->user();
            // Calculate last activity and spinner freeze time
            $validTime = Carbon::create($player->spinner_last_activity)
                ->addHours(intval(setting('spin-activity-interval')));
            if (
                $player->spinner_last_activity == null
                || now() > $validTime
            )
            {
                DB::beginTransaction();
                // Get user/player group
                $group = $player->rank->group;

                // Get Cached data for group
                $data = $this->getCachedData($group);

                // Get random id of prize
                $wonPrizeId = $data['prizes_win_percentages'][array_rand($data['prizes_win_percentages'], 1)];

                // Give player won prize
                $player->prizes()->attach($wonPrizeId);

                // Update player spinner last activity
                $player->update(['spinner_last_activity' => now()]);

                // Log action


                DB::commit();
            } else {
                DB::rollBack();
                $waitTime = $validTime->diff(now());
                throw new UnfulfilledException('You have to wait ' . $waitTime);
            }






            return [now()->subHour(), Carbon::create($player->spinner_last_activity)];
        } catch (NotFoundHttpException $e) {
            throw new NotFoundHttpException();
        }
    }
}
