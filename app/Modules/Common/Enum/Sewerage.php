<?php

namespace App\Modules\Common\Enum;

use App\Libraries\Enum\Traits\HasLabel;

enum Sewerage: int
{
    use HasLabel;

    case APPEAR_ADEQUATE = 0;
    case APPEAR_INADEQUATE = 1;
    case UNKNOWN = 2;

    public function label(): string
    {
        return match ($this) {
            Sewerage::APPEAR_ADEQUATE => 'appear_adequate',
            Sewerage::APPEAR_INADEQUATE => 'appear_inadequate',
            Sewerage::UNKNOWN => 'unknown',
        };
    }
}
