<?php

namespace App\Enums\Rank;

enum RankGroup: string
{
    case WINNER = 'winner';
    case RUNNER_UP = 'runner_up';
    case OTHER = 'other';

    public function data()
    {
        return match($this)
        {
            RankGroup::WINNER => \Illuminate\Support\Facades\Cache::rememberForever(
                RankGroup::WINNER->value,
                function () {
                    return [
                        'total_number' => null
                    ];
                }),
            RankGroup::RUNNER_UP => \Illuminate\Support\Facades\Cache::rememberForever(
                RankGroup::RUNNER_UP->value,
                function () {
                    return [
                        'total_number' => null
                    ];
                }),
            RankGroup::OTHER => \Illuminate\Support\Facades\Cache::rememberForever(
                RankGroup::OTHER->value,
                function () {
                    return [
                        'total_number' => null
                    ];
                }),
        };
    }
}
