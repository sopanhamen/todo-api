<?php

namespace App\Modules\Common\Enum;

use App\Libraries\Enum\Traits\HasLabel;

enum Gender: int
{
    use HasLabel;

    case NOT_SPECIFIED = 0;
    case FEMALE = 1;
    case MALE = 2;
    case OTHER = 3;

    public function label(): string
    {
        return match ($this) {
            Gender::NOT_SPECIFIED => 'not_specified',
            Gender::FEMALE => 'female',
            Gender::MALE => 'male',
            Gender::OTHER => 'other',
        };
    }
}
