<?php

namespace App\Libraries\Enum\Traits;

trait HasLabel
{
    abstract public function label(): string;

    public static function labels()
    {
        return array_map(function ($item) {
            return ['value' => $item->value, 'label' => $item->label()];
        }, self::cases());
    }
}
