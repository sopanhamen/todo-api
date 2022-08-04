<?php

namespace App\Modules\Property\Enum;

use App\Libraries\Enum\Traits\HasLabel;

enum Purpose: int
{
    use HasLabel;

    case SALE = 1;
    case RENT = 2;
    case RENT_OR_SALE = 3;

    public function label(): string
    {
        return match ($this) {
            Purpose::SALE => 'sale',
            Purpose::RENT => 'rent',
            Purpose::RENT_OR_SALE => 'rent_or_sale',
        };
    }
}
