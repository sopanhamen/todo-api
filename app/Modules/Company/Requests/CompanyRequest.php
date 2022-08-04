<?php

namespace App\Modules\Company\Requests;

use App\Rules\PhoneNumber;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class CompanyRequest extends FormRequest
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
            'name' => [
                'required',
                Rule::unique('companies', 'name')->where(function ($query) {
                    return $query->where('deleted_at', NULL);
                }),
            ],
            'property_code_prefix' => 'required',
            'property_code_digit' => 'required',
            'property_code_prefix_unlisting' => 'required',
            'property_code_digit_unlisting' => 'required',
            'year_established' => 'nullable|integer|digits:4',
            'summary' => 'nullable',
            'description' => 'nullable',
            'vision' => 'nullable',
            'mission' => 'nullable',
            'key_value' => 'nullable',
            'address' => 'nullable',
            'primary_phone' => ['required', new PhoneNumber],
            'secondary_phone' => ['nullable', new PhoneNumber],
            'email' => 'nullable|email',
            'logo' => 'nullable',
            'lat_lng' => 'nullable',
            'published' => 'required|boolean',
            "country_id" => "required|exists:countries,id,deleted_at,NULL",
            "province_id" => "required|exists:provinces,id,deleted_at,NULL",
            "district_id" => "required|exists:districts,id,deleted_at,NULL",
            "commune_id" => "nullable|exists:communes,id,deleted_at,NULL",
            'facebook' => 'nullable',
            'telegram' => 'nullable',
            'youtube' => 'nullable',
            'linked_in' => 'nullable',
            'instagram' => 'nullable',
                    ];
    }
}
