<?php

namespace App\Modules\Common\Enum;

use App\Libraries\Enum\Traits\HasLabel;

enum Drainage: int
{
    use HasLabel;

    case APPEAR_ADEQUATE = 0;
    case APPEAR_INADEQUATE = 1;
    case UNKNOWN = 2;

    public function label(): string
    {
        return match ($this) {
            Drainage::APPEAR_ADEQUATE => 'appear_adequate',
            Drainage::APPEAR_INADEQUATE => 'appear_inadequate',
            Drainage::UNKNOWN => 'unknown',
        };
    }
}
