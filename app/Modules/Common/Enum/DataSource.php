<?php

namespace App\Modules\Common\Enum;

use App\Libraries\Enum\Traits\HasLabel;

enum DataSource: int
{
    use HasLabel;

    case OWNER = 1;
    case AGENT = 2;
    case BROKER = 3;

    public function label(): string
    {
        return match ($this) {
            DataSource::OWNER => 'owner',
            DataSource::AGENT => 'agent',
            DataSource::BROKER => 'broker',
        };
    }
}
