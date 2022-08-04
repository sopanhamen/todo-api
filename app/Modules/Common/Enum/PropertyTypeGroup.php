<?php

namespace App\Modules\Common\Enum;

use App\Libraries\Enum\Traits\HasLabel;

enum PropertyTypeGroup: int
{
    use HasLabel;

    case HOMES = 1;
    case LANDS_PLOTS = 2;
    case COMMERCIAL = 3;
    case BUSINESS = 4;
    case INDUSTRIAL = 5;
    case PETROL_STATION = 6;

    public function label(): string
    {
        return match ($this) {
            PropertyTypeGroup::HOMES => 'homes',
            PropertyTypeGroup::LANDS_PLOTS => 'lands_plots',
            PropertyTypeGroup::COMMERCIAL => 'commercial',
            PropertyTypeGroup::BUSINESS => 'business',
            PropertyTypeGroup::INDUSTRIAL => 'industrial',
            PropertyTypeGroup::PETROL_STATION => 'petrol_station',
        };
    }
}
