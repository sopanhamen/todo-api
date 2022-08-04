<?php

namespace App\Modules\Property\Enum;

use App\Libraries\Enum\Traits\HasLabel;

enum ListingStatus: int
{
    use HasLabel;

    case AVAILABLE = 1;
    case SOLD = 2;
    case RENTED = 3;
    case STOP_SELLING = 4;
    case STOP_RENTING = 5;

    public function label(): string
    {
        return match ($this) {
            ListingStatus::AVAILABLE => 'available',
            ListingStatus::SOLD => 'sold',
            ListingStatus::RENTED => 'rented',
            ListingStatus::STOP_SELLING => 'stop_selling',
            ListingStatus::STOP_RENTING => 'stop_renting',
        };
    }
}
