<?php
namespace App\Rules;

use Illuminate\Support\Str;
use Illuminate\Contracts\Validation\Rule;

class PhoneNumber implements Rules {

    public function __construct()
    {
        //
    }

    public function passes($attribute, $value)
    {
        return $value && (Str::length($value) >= 9 && Str::length($value) < 15);
    }

    public function message()
    {
        return 'Value must be a valid phone number.';
    }
}