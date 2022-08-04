<?php

namespace App\Modules\Common\Enum;

use App\Libraries\Enum\Traits\HasLabel;

enum Ceiling: int
{
    use HasLabel;

    case SUSPENDED_CEILING = 0;
    case SMART_BOARD = 1;
    case PLASTERED_CONCRETE = 2;
    case METAL = 3;
    case HARDWOOD = 4;
    case LAMINATED_WOOD  = 5;

    public function label(): string
    {
        return match ($this) {
            Ceiling::SUSPENDED_CEILING => 'suspended_ceiling',
            Ceiling::SMART_BOARD => 'smart_board',
            Ceiling::PLASTERED_CONCRETE => 'plastered_concrete',
            Ceiling::METAL => 'metal',
            Ceiling::HARDWOOD => 'hardwood',
            Ceiling::LAMINATED_WOOD => 'laminated_wood',
        };
    }
}
