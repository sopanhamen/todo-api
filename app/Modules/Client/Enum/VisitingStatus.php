<?php

namespace App\Modules\Client\Enum;

use App\Libraries\Enum\Traits\HasLabel;

enum VisitingStatus: int
{
    use HasLabel;

    case CANCELED = 0;
    case PENDING = 1;
    case VISITED = 2;

    public function label(): string
    {
        return match ($this) {
            VisitingStatus::CANCELED => 'canceled',
            VisitingStatus::PENDING => 'pending',
            VisitingStatus::VISITED => 'visited',
        };
    }
}
