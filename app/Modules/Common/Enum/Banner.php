<?php

namespace App\Modules\Common\Enum;

use App\Libraries\Enum\Traits\HasLabel;

enum Banner: int
{
    use HasLabel;

    case NO_BANNER = 0;
    case BANNER_WITH_STAND = 1;
    case BANNER_NO_STAND = 2;

    public function label(): string
    {
        return match ($this) {
            Banner::NO_BANNER => 'no_banner',
            Banner::BANNER_WITH_STAND => 'banner_with_stand',
            Banner::BANNER_NO_STAND => 'banner_no_stand',
        };
    }
}