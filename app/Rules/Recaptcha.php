<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Request;

class Recaptcha implements Rule
{
    private $parameter = [];

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($parameter)
    {
        $this->parameter = $parameter;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $recaptcha = new \ReCaptcha\ReCaptcha(config('recaptcha.secret'));
        $recaptchaResponse = $recaptcha
            ->setExpectedAction($this->parameter)
            ->setScoreThreshold(config('app.env') === 'production' ? 0.7 : 0.5)
            ->verify($value, Request::ip());

        return $recaptchaResponse->isSuccess();
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Validate human failed.';
    }
}
