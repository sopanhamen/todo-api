<?php

namespace App\Modules\Client\Enum;

use App\Libraries\Enum\Traits\HasLabel;

enum ClientSource: int
{
    use HasLabel;

    case WALK_IN = 0;
    case THIRD_PARTY = 1;
    case WEBSITE = 2;
    case BANNER_RAISING = 3;
    case OTHER_ADVERTISING = 4;
    case FACEBOOK = 5;
    case GOOGLE_MAP = 6;
    case KHMER24 = 7;
    case CVEA = 8;
    case REALESTATE_COM_KH = 9;

    public function label(): string
    {
        return match ($this) {
            ClientSource::WALK_IN => 'walk_in',
            ClientSource::THIRD_PARTY => 'third_party',
            ClientSource::WEBSITE => 'website',
            ClientSource::BANNER_RAISING => 'banner_raising',
            ClientSource::OTHER_ADVERTISING => 'other_advertising',
            ClientSource::FACEBOOK => 'facebook',
            ClientSource::GOOGLE_MAP => 'google_map',
            ClientSource::KHMER24 => 'khmer24',
            ClientSource::CVEA => 'cvea',
            ClientSource::REALESTATE_COM_KH => 'realestate_com_kh',
        };
    }
}
