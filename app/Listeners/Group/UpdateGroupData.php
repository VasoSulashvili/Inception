<?php

namespace App\Listeners\Group;

use App\Actions\Group\GenerateData;
use App\Enums\Rank\RankGroup;
use App\Traits\HasGroupData;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Events\Group\UpdateGroupData as UpdateGroupDataEvent;
use Illuminate\Support\Facades\Cache;

class UpdateGroupData
{
    use HasGroupData;
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(UpdateGroupDataEvent $event): void
    {
        $group = $event->group;

        // Clear cache data
        Cache::forget(RankGroup::from($group)->value);

        // Store new data
        Cache::rememberForever(RankGroup::from($group)->value, function() use ($group) {
            return $this->generateData($group);
        });
    }
}
