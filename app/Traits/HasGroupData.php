<?php

namespace App\Traits;

use App\Enums\Rank\RankGroup;
use App\Exceptions\UnfulfilledException;
use App\Models\Group;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;

trait HasGroupData
{
    /**
     * @param Group|string $group
     * @return mixed
     * @throws UnfulfilledException
     */
    function generateData(string|Group $group): mixed
    {
        Cache::put('dddd', [$group, RankGroup::cases()]);
        if(is_string($group) && !in_array($group, RankGroup::cases())) {
            $group = Group::where('name', '=', RankGroup::from($group))->first();
        } else {
            throw new UnfulfilledException('Invalid Group Name!');
        }
        $data = [];

        // Set Total Number
        $data['total_number'] = array_sum($group->prizes->pluck('pivot.number')->toArray());

        // Set win percentage
        $data['prizes_win_percentages'] = [];
        foreach ($group->prizes->toArray() as $prize) {
            $percentage = ($prize['pivot']['number'] / setting('prize-total-number')) * 100;
            $iArray= [];
            $iArray = array_fill(0, $percentage, $prize['pivot']['prize_id']);
            $data['prizes_win_percentages'][] = $iArray;
        }
        $data['prizes_win_percentages'] = Arr::flatten($data['prizes_win_percentages']);
        return $data;
    }

    /**
     * @param Group|string $group
     * @return mixed
     */
    public function getCachedData(Group|string $group): mixed
    {
        return Cache::rememberForever(RankGroup::from($group->name)->value, function() use ($group) {
            $this->generateData($group);
        });
    }
}
