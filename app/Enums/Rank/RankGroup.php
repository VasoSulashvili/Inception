<?php

namespace App\Enums\Rank;

enum RankGroup: string
{
    case WINNER = 'winner';
    case RUNNER_UP = 'runner_up';
    case OTHER = 'other';
}
