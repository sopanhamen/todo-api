<?php

namespace App\Modules\Common\Enum;

use App\Libraries\Enum\Traits\HasLabel;

enum FlooringMaterial: int
{
    use HasLabel;

    case CERAMIC_TILES = 0;
    case PLAIN_TILE = 1;
    case PLASTERED_CONCRETE = 2;
    case LAMINATED_WOOD = 3;
    case VINYL = 4;
    case POLISHED_STONE_MARBLE  = 5;

    public function label(): string
    {
        return match ($this) {
            FlooringMaterial::CERAMIC_TILES => 'ceramic_tiles',
            FlooringMaterial::PLAIN_TILE => 'plain_tile',
            FlooringMaterial::PLASTERED_CONCRETE => 'plastered_concrete',
            FlooringMaterial::LAMINATED_WOOD => 'laminated_wood',
            FlooringMaterial::VINYL => 'vinyl',
            FlooringMaterial::POLISHED_STONE_MARBLE => 'polished_stone_marble',
        };
    }
}
