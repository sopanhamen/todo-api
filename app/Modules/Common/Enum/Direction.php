<?php

namespace App\Modules\Common\Enum;

use App\Libraries\Enum\Traits\HasLabel;

enum Direction: int
{
    use HasLabel;

    case UNKNOWN = 0;
    case NORTH = 1;
    case EAST = 2;
    case WEST = 3;
    case SOUTH = 4;
    case NORTH_EAST = 5;
    case SOUTH_EAST = 6;
    case NORTH_WEST = 7;
    case SOUTH_WEST = 8;

    public function label(): string
    {
        return match ($this) {
            Direction::UNKNOWN => 'unknown',
            Direction::NORTH => 'north',
            Direction::EAST => 'east',
            Direction::WEST => 'west',
            Direction::SOUTH => 'south',
            Direction::NORTH_EAST => 'north_east',
            Direction::SOUTH_EAST => 'south_east',
            Direction::NORTH_WEST => 'north_west',
            Direction::SOUTH_WEST => 'south_west',
        };
    }
}
