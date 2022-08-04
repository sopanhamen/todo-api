<?php

namespace App\Modules\SiteInquiry\Enum;

use App\Libraries\Enum\Traits\HasLabel;

enum InquiryStatus: int
{
    use HasLabel;

    case PENDING = 1;
    case CONTACTED = 2;

    public function label(): string
    {
        return match ($this) {
            InquiryStatus::PENDING => 'available',
            InquiryStatus::CONTACTED => 'sold',
        };
    }
}
