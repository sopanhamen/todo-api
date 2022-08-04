<?php

namespace App\Modules\User\Requests;

use App\Rules\PhoneNumber;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends UserRequest
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
        $userId = $this->route('user');
        return [
            ...parent::rules(),
            'email' => [
                'nullable',
                'max:255',
                'email',
                Rule::unique('users', 'email')->ignore($userId, 'id'),
            ],
            'phone' => [
                'required',
                new PhoneNumber,
                Rule::unique('users', 'phone')->ignore($userId, 'id'),
            ],
            'password' => 'nullable|confirmed',
        ];
    }
}
