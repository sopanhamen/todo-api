<?php

namespace App\Modules\Common\Enum;

use App\Libraries\Enum\Traits\HasLabel;

enum RoadCondition: int
{
    use HasLabel;

    case MAIN_ROAD = 0;
    case SUB_MAIN_ROAD = 1;
    case CONCRETE_ROAD = 2;
    case OTHERS = 3;

    public function label(): string
    {
        return match ($this) {
            RoadCondition::MAIN_ROAD => 'main_road',
            RoadCondition::SUB_MAIN_ROAD => 'sub_main_road',
            RoadCondition::CONCRETE_ROAD => 'concrete_road',
            RoadCondition::OTHERS => 'others',
        };
    }
}
