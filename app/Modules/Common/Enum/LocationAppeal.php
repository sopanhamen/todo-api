<?php

namespace App\Modules\Common\Enum;

use App\Libraries\Enum\Traits\HasLabel;

enum LocationAppeal: int
{
    use HasLabel;

    case POOR = 0;
    case AVERAGE = 1;
    case GOOD = 2;
    case VERY_GOOD = 3;
    case EXCELLENT = 4;

    public function label(): string
    {
        return match ($this) {
            LocationAppeal::POOR => 'poor',
            LocationAppeal::AVERAGE => 'average',
            LocationAppeal::GOOD => 'good',
            LocationAppeal::VERY_GOOD => 'very_good',
            LocationAppeal::EXCELLENT => 'excellent',
        };
    }
}
