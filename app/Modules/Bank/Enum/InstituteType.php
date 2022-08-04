<?php

namespace App\Modules\Bank\Enum;

use App\Libraries\Enum\Traits\HasLabel;

enum InstituteType: int
{
    use HasLabel;

    case COMMERCIAL_BANK = 0;
    case SPECIALIZE_BANK = 1;
    case MICROFINANCE_SOLUTION = 2;
    case MICROFINANCE_DEPOSIT_TAKING_INSTITUTION = 3;
    case REPRESENTATIVE_OFFICE_BANK = 4;
    case LEASING_COMPANY  = 5;

    public function label(): string
    {
        return match ($this) {
            InstituteType::COMMERCIAL_BANK => 'commercial_bank',
            InstituteType::SPECIALIZE_BANK => 'specialize_bank',
            InstituteType::MICROFINANCE_SOLUTION => 'microfinance_solution',
            InstituteType::MICROFINANCE_DEPOSIT_TAKING_INSTITUTION => 'microfinance_deposit_taking_institution',
            InstituteType::REPRESENTATIVE_OFFICE_BANK => 'representative_office_bank',
            InstituteType::LEASING_COMPANY => 'leasing_company',
        };
    }
}
