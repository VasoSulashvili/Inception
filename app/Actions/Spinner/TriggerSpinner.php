<?php

declare(strict_types=1);

namespace App\Actions\Spinner;

use App\Support\Facades\CacheService;
use Illuminate\Support\Carbon;
use App\Exceptions\UnfulfilledException;

class TriggerSpinner
{
    /**
     * @return int $wonPrizeId
     * @throws UnfulfilledException
     */
    public function handle(): int
    {
        // Get auth user
        $player = auth()->user();
        $spinnerLastActivity = $player->spinner_last_activity;

        // Calculate last activity and spinner freeze time
        $validTime = Carbon::create($spinnerLastActivity)
            ->addHours(intval(setting('spin-activity-interval')));

        if ($spinnerLastActivity == null || now() > $validTime) {

            // Get user/player group
            $group = $player->rank->group;

            // Get Cached data for group
            $data = CacheService::getGroupData($group->name);

            // Get random id of prize
            $wonPrizeId = $data['prize_percentages'][array_rand($data['prize_percentages'], 1)];

            // Give player won prize
            $player->prizes()->attach($wonPrizeId);

            // Update player spinner last activity
            $player->update(['spinner_last_activity' => now()]);

            return $wonPrizeId;
        } else {
            $waitTime = $validTime->diff(now());
            throw new UnfulfilledException('You have to wait ' . $waitTime);
        }
    }
}
