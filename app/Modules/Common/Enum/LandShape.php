<?php

namespace App\Modules\Common\Enum;

use App\Libraries\Enum\Traits\HasLabel;

enum LandShape: int
{
    use HasLabel;

    case IRREGULAR = 1;
    case REGULAR = 2;
    case RECTANGULAR = 3;
    case SQUARE = 4;

    public function label(): string
    {
        return match ($this) {
            LandShape::REGULAR => 'regular',
            LandShape::RECTANGULAR => 'rectangular',
            LandShape::IRREGULAR => 'irregular',
            LandShape::SQUARE => 'square',
        };
    }
}
