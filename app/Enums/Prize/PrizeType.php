<?php

namespace App\Enums\Prize;

enum PrizeType: string
{
    case LOTTERY = 'lottery';
    case CUSTOM = 'custom_prize';
}
