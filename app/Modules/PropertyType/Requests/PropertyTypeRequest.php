<?php

namespace App\Modules\PropertyType\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class PropertyTypeRequest extends FormRequest
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
            "name" => [
                "required",
                Rule::unique('property_types', 'name')->where(function ($query) {
                    return $query->where('deleted_at', NULL);
                }),
            ]
        ];
    }
}