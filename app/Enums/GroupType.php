<?php

namespace App\Enums;

enum GroupType: string
{
    case WINNER = 'winner';
    case RUNNER_UP = 'runner_up';
    case OTHER = 'other';
}
