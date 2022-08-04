<?php

namespace App\Modules\User\Requests;

use App\Libraries\Validation\Trait\HasSubRules;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;
use App\Modules\Common\Enum\Gender;
use App\Modules\Contact\Requests\ContactRequest;
use App\Rules\PhoneNumber;

class UserRequest extends FormRequest
{
    use HasSubRules;

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
            // Login info
            'email' => ['nullable', 'max:255', 'email', 'unique:users,email'],
            'phone' => ['required', 'unique:users,phone', new PhoneNumber],
            'password' => 'required|confirmed',
            'roles' => 'required',
            'roles.*' => 'required',

            // Team
            ...$this->subRules('teams', [
                '*.team_id' => 'required',
                '*.level' => 'required|numeric',
            ]),

            // Profile
            ...$this->subRules('profile', [
                'gender' => [new Enum(Gender::class)],
                'national_id_number' => 'nullable|min:6',
                'national_id_image_front' => 'nullable',
                'national_id_image_back' => 'nullable',
                'passport_number' => 'nullable|min:6',
                'passport_id_image_front' => 'nullable',
                'passport_id_image_back' => 'nullable',
                'position' => 'nullable',
                'experience' => 'nullable',
                'skills' => 'nullable',
                'profile_picture' => 'nullable',
            ]),

            // Contacts
            ...$this->subRules('profile.contact', (new ContactRequest())->rules()),
        ];
    }
}
