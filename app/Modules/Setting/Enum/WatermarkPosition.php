<?php

namespace App\Modules\Setting\Enum;

enum WatermarkPosition: string
{
    case TOP_LEFT = 'top_left';
    case TOP_RIGHT = 'top_right';
    case BOTTOM_LEFT = 'bottom_left';
    case BOTTOM_RIGHT = 'bottom_right';
}
