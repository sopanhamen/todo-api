<?php

namespace App\Modules\Common\Enum;

use App\Libraries\Enum\Traits\HasLabel;

enum DeedType: int
{
    use HasLabel;

    case HARD_LMAP = 0;
    case HARD_SPORADIC_REGISTRATION = 1;
    case SOFT_CERTIFICATE_POSSESSION = 2;
    case SOFT_LETTER_POSSESSION = 3;
    case FEATHER_TITLE = 4;
    case OTHERS  = 5;

    public function label(): string
    {
        return match ($this) {
            DeedType::HARD_LMAP => 'hard_lmap',
            DeedType::HARD_SPORADIC_REGISTRATION => 'hard_sporadic_registration',
            DeedType::SOFT_CERTIFICATE_POSSESSION => 'soft_certificate_possession',
            DeedType::SOFT_LETTER_POSSESSION => 'soft_letter_possession',
            DeedType::FEATHER_TITLE => 'feather_title',
            DeedType::OTHERS => 'others',
        };
    }
}
