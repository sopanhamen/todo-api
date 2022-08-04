<?php

namespace App\Modules\Property\Enum;

use App\Libraries\Enum\Traits\HasLabel;

enum WallMaterial: int
{
    use HasLabel;

    case PLASTERED_BRICK = 0;
    case PLASTERED_CONCRETE = 1;
    case METAL_SHEET = 2;
    case SMART_BOARD = 3;
    case GALVANIZED_IRON_ALUMINUM = 4;

    public function label(): string
    {
        return match ($this) {
            WallMaterial::PLASTERED_BRICK => 'plastered_brick',
            WallMaterial::PLASTERED_CONCRETE => 'plastered_concrete',
            WallMaterial::METAL_SHEET => 'metal_sheet',
            WallMaterial::SMART_BOARD => 'smart_board',
            WallMaterial::GALVANIZED_IRON_ALUMINUM => 'galvanized_iron_aluminum',
        };
    }
}
