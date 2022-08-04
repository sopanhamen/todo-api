<?php

namespace App\Modules\ClientRequirement\Enum;

enum Step: string
{
    case VISIT = 'visit';
    case NEGOTIATION = 'negotiation';
    case PAYMENT = 'payment';
    case COMPLETION = 'completion';
}
