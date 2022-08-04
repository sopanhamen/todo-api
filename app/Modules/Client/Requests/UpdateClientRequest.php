<?php

namespace App\Modules\Client\Requests;

use App\Rules\UniqueClientContact;

class UpdateClientRequest extends ClientRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            ...parent::rules(),
            'contact.primary_phone' => [new UniqueClientContact($this->route('client'))],
        ];
    }
}
