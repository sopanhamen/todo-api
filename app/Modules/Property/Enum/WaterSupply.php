<?php

namespace App\Modules\Property\Enum;

use App\Libraries\Enum\Traits\HasLabel;

enum WaterSupply: int
{
    use HasLabel;

    case NONE = 0;
    case PUBLIC = 1;
    case PRIVATE = 2;

    public function label(): string
    {
        return match ($this) {
            WaterSupply::PUBLIC => 'public',
            WaterSupply::PRIVATE => 'private',
            WaterSupply::NONE => 'none',
        };
    }
}
