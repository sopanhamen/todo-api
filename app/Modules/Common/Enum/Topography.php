<?php

namespace App\Modules\Common\Enum;

use App\Libraries\Enum\Traits\HasLabel;

enum Topography: int
{
    use HasLabel;

    case UNLEVELLED = 0;
    case LEVELLED = 1;

    public function label(): string
    {
        return match ($this) {
            Topography::LEVELLED => 'levelled',
            Topography::UNLEVELLED => 'unlevelled',
        };
    }
}
