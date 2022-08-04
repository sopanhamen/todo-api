<?php

namespace App\Modules\Common\Enum;

use App\Libraries\Enum\Traits\HasLabel;

enum Priority: int
{
    use HasLabel;

    case VERY_HIGH = 1;
    case HIGH = 2;
    case MEDIUM = 3;
    case LOW = 4;
    case VERY_LOW = 5;

    public function label(): string
    {
        return match ($this) {
            Priority::VERY_HIGH => 'very_high',
            Priority::HIGH => 'high',
            Priority::MEDIUM => 'medium',
            Priority::LOW => 'low',
            Priority::VERY_LOW => 'very_low',
        };
    }
}
