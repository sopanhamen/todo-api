<?php

namespace App\Modules\Common\Enum;

use App\Libraries\Enum\Traits\HasLabel;

enum RoomType: int
{
    use HasLabel;

    case BED_1 = 0;
    case BED_2 = 1;
    case BED_3 = 2;
    case PENTHOUSE = 3;

    public function label(): string
    {
        return match ($this) {
            RoomType::BED_1 => 'bed_1',
            RoomType::BED_2 => 'bed_2',
            RoomType::BED_3 => 'bed_3',
            RoomType::PENTHOUSE => 'penthouse',
        };
    }
}
