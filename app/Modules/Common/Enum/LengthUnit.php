<?php

namespace App\Modules\Common\Enum;

use App\Libraries\Enum\Traits\HasLabel;

enum LengthUnit: int
{
    use HasLabel;

    case METER = 1;
    case SQUARE_METER = 2;
    case HECTARE = 3;

    public function label(): string
    {
        return match ($this) {
            LengthUnit::METER => 'meter',
            LengthUnit::SQUARE_METER => 'square_meter',
            LengthUnit::HECTARE => 'hectare',
        };
    }
}
