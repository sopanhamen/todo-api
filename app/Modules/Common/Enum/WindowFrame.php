<?php

namespace App\Modules\Common\Enum;

use App\Libraries\Enum\Traits\HasLabel;

enum WindowFrame: int
{
    use HasLabel;

    case ALUMINUM_FRAME = 0;
    case ALUMINUM_FRAME_WITH_SLIDING_GLASSES = 1;
    case WOOD = 2;
    case IRON = 3;

    public function label(): string
    {
        return match ($this) {
            WindowFrame::ALUMINUM_FRAME => 'aluminum_frame',
            WindowFrame::ALUMINUM_FRAME_WITH_SLIDING_GLASSES => 'aluminum_frame_with_sliding_glasses',
            WindowFrame::WOOD => 'wood',
            WindowFrame::IRON => 'iron',
        };
    }
}
