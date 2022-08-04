<?php

namespace App\Modules\Common\Enum;

use App\Libraries\Enum\Traits\HasLabel;

enum Zoning: int
{
    use HasLabel;

    case RESIDENTIAL = 1;
    case RESIDENTIAL_COMMERCIAL = 2;
    case INDUSTRIAL = 3;
    case AGRICULTURAL = 4;
    case COMMERCIAL = 5;
    case HISTORIC = 6;
    case UNUSED_LAND = 7;

    public function label(): string
    {
        return match ($this) {
            Zoning::RESIDENTIAL => 'residential',
            Zoning::RESIDENTIAL_COMMERCIAL => 'residential_commercial',
            Zoning::INDUSTRIAL => 'industrial',
            Zoning::AGRICULTURAL => 'agricultural',
            Zoning::COMMERCIAL => 'commercial',
            Zoning::HISTORIC => 'historic',
            Zoning::UNUSED_LAND => 'unused_land',
        };
    }
}
