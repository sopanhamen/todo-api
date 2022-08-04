<?php

namespace App\Modules\ClientRequirement\Enum;

use App\Libraries\Enum\Traits\HasLabel;

enum Service: int
{
    use HasLabel;

    case BUY = 0;
    case RENT = 1;
    // case SELL = 2;
    // case OFFER_RENTING = 3;
    // case VALUATE = 4;
    // case CONSULT  = 5;

    public function label(): string
    {
        return match ($this) {
            Service::BUY => 'buy',
            Service::RENT => 'rent',
            // Service::SELL => 'sell',
            // Service::OFFER_RENTING => 'offer_renting',
            // Service::VALUATE => 'valuate',
            // Service::CONSULT => 'consult',
        };
    }
}
