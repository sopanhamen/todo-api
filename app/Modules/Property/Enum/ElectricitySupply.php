<?php

namespace App\Modules\Property\Enum;

use App\Libraries\Enum\Traits\HasLabel;

enum ElectricitySupply: int
{
    use HasLabel;

    case NONE = 0;
    case PUBLIC = 1;
    case PRIVATE = 2;

    public function label(): string
    {
        return match ($this) {
            ElectricitySupply::PUBLIC => 'public',
            ElectricitySupply::PRIVATE => 'private',
            ElectricitySupply::NONE => 'none',
        };
    }
}
