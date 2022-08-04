<?php

namespace App\Modules\ClientRequirement\Enum;

use App\Libraries\Enum\Traits\HasLabel;

enum Result: int
{
    use HasLabel;

    case IN_PROGRESS = 0;
    case PENDING = 1;
    case FAILED = 2;    // case: closed failed
    case SUCCESS = 3;   // case: closed successfully
    case CANCELLED = 4;

    public function label(): string
    {
        return match ($this) {
            Result::IN_PROGRESS => 'in_progress',
            Result::PENDING => 'pending',
            Result::FAILED => 'failed',
            Result::SUCCESS => 'success',
            Result::CANCELLED => 'cancelled'
        };
    }
}
