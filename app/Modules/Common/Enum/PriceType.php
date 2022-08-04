<?php

namespace App\Modules\Common\Enum;

use App\Libraries\Enum\Traits\HasLabel;

enum PriceType: int
{
    use HasLabel;

    case TOTAL = 1;
    case METER = 2;
    case SQUARE_METER = 3;
    case MONTH = 4;
    case HECTARE = 5;

    public function label(): string
    {
        return match ($this) {
            PriceType::TOTAL => 'total',
            PriceType::METER => 'meter',
            PriceType::SQUARE_METER => 'square_meter',
            PriceType::MONTH => 'month',
            PriceType::HECTARE => 'hectare',
        };
    }
}
