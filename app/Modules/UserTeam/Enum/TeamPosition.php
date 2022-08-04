<?php

namespace App\Modules\UserTeam\Enum;

use App\Libraries\Enum\Traits\HasLabel;

enum TeamPosition: int
{
    use HasLabel;

    case LEADER = 1;
    case SUB_LEADER = 2;
    case MEMBER = 3;

    public function label(): string
    {
        return match ($this) {
            TeamPosition::LEADER => 'leader',
            TeamPosition::SUB_LEADER => 'sub_leader',
            TeamPosition::MEMBER => 'member',
        };
    }
}
