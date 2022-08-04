<?php

namespace App\Modules\Common\Enum;

use App\Libraries\Enum\Traits\HasLabel;

enum DesignAppeal: int
{
    use HasLabel;

    case GOOD = 0;
    case AVERAGE = 1;
    case POOR = 2;

    public function label(): string
    {
        return match ($this) {
            DesignAppeal::GOOD => 'good',
            DesignAppeal::AVERAGE => 'average',
            DesignAppeal::POOR => 'poor',
        };
    }
}
