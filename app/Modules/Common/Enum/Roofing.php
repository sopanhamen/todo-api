<?php

namespace App\Modules\Common\Enum;

use App\Libraries\Enum\Traits\HasLabel;

enum Roofing: int
{
    use HasLabel;

    case TILES = 0;
    case PLASTERED_CONCRETE = 1;
    case CORRUGATED_ZINC = 2;
    case METAL = 3;
    case CPAC_MONIER = 4;
    case OTHER  = 5;

    public function label(): string
    {
        return match ($this) {
            Roofing::TILES => 'tiles',
            Roofing::PLASTERED_CONCRETE => 'plastered_concrete',
            Roofing::CORRUGATED_ZINC => 'corrugated_zinc',
            Roofing::METAL => 'metal',
            Roofing::CPAC_MONIER => 'cpac_monier',
            Roofing::OTHER => 'other',
        };
    }
}
