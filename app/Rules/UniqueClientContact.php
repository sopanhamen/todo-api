<?php

namespace App\Rules;

use App\Modules\Contact\Contact;
use Illuminate\Contracts\Validation\Rule;

class UniqueClientContact implements Rule
{
    private $clientId;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($clientId = null)
    {
        $this->clientId = $clientId;
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
        $clientId = $this->clientId;

        return !Contact::withTrashed()
            ->whereHas('client', function ($query) use ($clientId) {
                $query->when($clientId, fn ($query) => $query->where('id', '!=', $clientId));
            })
            ->where('primary_phone', '=', $value)
            ->exists();
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The primary phone number is already registered.';
    }
}
