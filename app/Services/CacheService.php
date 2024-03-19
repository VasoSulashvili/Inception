<?php

declare(strict_types=1);

namespace App\Services;

use App\Enums\Rank\RankGroup;
use App\Models\Group;
use App\Models\Player;
use App\Models\Setting;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;

class CacheService
{
    /**
     * @param string|RankGroup $group
     * @return array
     */
    public function generateGroupData(string|RankGroup $group): array
    {
        if ($group instanceof RankGroup) {
            $group = $group->value;
        }
        $group = Group::where('name', '=', $group)->with('prizes')->first();

        $data = [
            'prize_total_number' => null,
            'prize_percentages' => [],
        ];

        if ($group != null) {
            $prizes = $group->prizes;
            // set total prize number
            $data['prize_total_number'] = array_sum($group->prizes->pluck('pivot.number')->toArray());

            // set prize percentages
            foreach ($prizes as $prize) {
                $percentage = ($prize['pivot']['number'] / setting('prize-total-number')) * 100;
                $iArray= [];
                $iArray = array_fill(0, intval(ceil($percentage)), $prize->id);
                array_push($data['prize_percentages'], $iArray);
            }
            $data['prize_percentages'] = Arr::flatten($data['prize_percentages']);

        }
        return $data;
    }


    /**
     * @param string|RankGroup $group
     * @return bool
     */
    public function updateGroupData(string|RankGroup $group): bool
    {
        if ($group instanceof RankGroup) {
            $group = $group->value;
        }
        Cache::forget('groups-' . $group);
        Cache::put('groups-' . $group, $this->generateGroupData($group));
        return true;
    }


    /**
     * @param string|RankGroup $group
     * @return mixed
     */
    public function getGroupData(string|RankGroup $group)
    {
        return Cache::rememberForever('groups-' . $group, function () use ($group){
            return $this->generateGroupData($group);
        });
    }


    /**
     * @param $id
     * @return mixed
     */
    public function getAuthPlayerData($id): mixed
    {
        return Cache::remember(
            'auth-user-' . $id,
            setting('player-cache-ttl'),
            function () use ($id) {
                return Player::where('id', '=', $id)
                    ->with(['prizes', 'rank', 'logs'])
                    ->first();
            });
    }


    /**
     * @param $id
     * @return bool
     */
    public function destroyAuthPlayerData($id): bool
    {
        return Cache::forget('auth-user-' . $id);
    }


    /**
     * @return mixed
     */
    public function getGroups(): mixed
    {
        return Cache::rememberForever(GROUPS_CACHE_KEY, function (){
            return Group::active()->all();
        });
    }

    /**
     * @return mixed
     */
    public function destroyGroups(): mixed
    {
        return Cache::forget(GROUPS_CACHE_KEY);
    }


    public function getSettings(): mixed
    {
        return Cache::rememberForever(SETTINGS_CACHE_KEY, function () {
            return Setting::all();
        });
    }
}
