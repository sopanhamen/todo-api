<?php

namespace App\Modules\Contact\Requests;

use App\Rules\PhoneNumber;
use Illuminate\Foundation\Http\FormRequest;

class ContactRequest extends FormRequest
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
            // General
            'name' => 'required:min:2',
            'email' => 'nullable|email',
            'primary_phone' => ['required', new PhoneNumber],
            'secondary_phone' => ['nullable', new PhoneNumber],

            // Address
            'country_id' => 'nullable',
            'province_id' => 'nullable',
            'district_id' => 'nullable',
            'commune_id' => 'nullable',
            'address' => 'nullable',
            'street' => 'nullable',
            'house' => 'nullable',

            // Socials
            'telegram' => 'nullable',
            'line' => 'nullable',
            'facebook' => 'nullable',
            'linkedin' => 'nullable',
            'instagram' => 'nullable',
            'youtube' => 'nullable',
            'tiktok' => 'nullable',
            'wechat' => 'nullable',
        ];
    }
}
