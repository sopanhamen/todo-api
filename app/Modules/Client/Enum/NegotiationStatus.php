<?php

namespace App\Modules\Client\Enum;

use App\Libraries\Enum\Traits\HasLabel;

enum NegotiationStatus: int
{
    use HasLabel;

    case CANCELED = 0;
    case PENDING = 1;
    case AGREED = 2;
    case DISAGREED = 3;

    public function label(): string
    {
        return match ($this) {
            NegotiationStatus::CANCELED => 'canceled',
            NegotiationStatus::PENDING => 'pending',
            NegotiationStatus::AGREED => 'agreed',
            NegotiationStatus::DISAGREED => 'disagreed',
        };
    }
}
