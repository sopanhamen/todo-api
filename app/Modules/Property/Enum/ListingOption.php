<?php

namespace App\Modules\Property\Enum;

enum ListingOption: int
{
    case ALL = 1;
    case LISTING = 2;
    case UNLISTING = 3;
}
