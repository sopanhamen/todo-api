<?php

namespace App\Modules\Common\Enum;

use App\Libraries\Enum\Traits\HasLabel;

enum Person: int
{
    use HasLabel;

    case OWNER = 1;
    case AGENT = 2;
    case BROKER = 3;
    case REPRESENTATIVE = 4;

    public function label(): string
    {
        return match ($this) {
            Person::AGENT => 'agent',
            Person::BROKER => 'broker',
            Person::OWNER => 'owner',
            Person::REPRESENTATIVE => 'representative',
        };
    }
}
