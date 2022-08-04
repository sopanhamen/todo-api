<?php

namespace App\Modules\Common\Enum;

use App\Libraries\Enum\Traits\HasLabel;

enum FormLayout: int
{
    use HasLabel;

    case DETAIL = 1;
    case SIMPLE = 2;
    case TABLET = 3;

    public function label(): string
    {
        return match ($this) {
            FormLayout::DETAIL => 'detail',
            FormLayout::SIMPLE => 'simple',
            FormLayout::TABLET => 'tablet',
        };
    }
}
