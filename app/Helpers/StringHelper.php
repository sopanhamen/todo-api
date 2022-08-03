<?php
namespace App\Helpers;

class StringHelper {
    public static function findNumber(string $string): int
    {
        return (int) preg_replace('/[^0-9]/', '', $string);
    }
}