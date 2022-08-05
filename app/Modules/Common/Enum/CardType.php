<?php

namespace App\Modules\Common\Enum;

use App\Libraries\Enum\Traits\HasLabel;

enum CardType: int
{
    use HasLabel;

    case USD = 0;
    case KHR = 1;

    public function label(): string
    {
        return match ($this) {
            CardType::USD => 'USD',
            CardType::KHR => 'KHR',
        };
    }
}