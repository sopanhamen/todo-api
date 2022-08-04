<?php

namespace App\Modules\Developer\Requests;

use App\Rules\PhoneNumber;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class DeveloperRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            // required fields
            'name' => [
                'required',
                Rule::unique('developers', 'name')->where(function ($query) {
                    return $query->where('deleted_at', NULL);
                }),
            ],
            'development_type_id' => 'required|exists:development_types,id,deleted_at,NULL',
            'primary_phone' => ['required', new PhoneNumber],

            // Optional fields
            'secondary_phone' => ['nullable', new PhoneNumber],
            'email' => 'nullable|email',
            'website' => 'nullable|url',
            'facebook' => 'nullable|url',
            'logo' => 'nullable',
            'published' => 'required|boolean',
            'address' => 'nullable|min:2',
        ];
    }
}
