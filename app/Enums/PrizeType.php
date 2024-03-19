<?php

namespace App\Enums;

enum PrizeType: string
{
    case LOTTERY = 'lottery';
    case CUSTOM = 'custom_prize';
}
