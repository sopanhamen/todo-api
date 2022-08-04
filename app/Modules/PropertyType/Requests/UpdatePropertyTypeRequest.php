<?php

namespace App\Modules\PropertyType\Requests;

use Illuminate\Validation\Rule;

class UpdatePropertyTypeRequest extends PropertyTypeRequest
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
            'name' => [
                'required',
                Rule::unique('property_types', 'name')->ignore($this->route('property_type'), 'id')->where(function ($query) {
                    return $query->where('deleted_at', NULL);
                }),
            ],
        ];
    }
}
