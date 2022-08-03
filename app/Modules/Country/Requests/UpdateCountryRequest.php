<?php

namespace App\Modules\Country\Requests;

class UpdateCountryRequest extends CountryRequest
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
            ...parent::rules(),
            'name' => [
                'required',
                Rule::unique('countries', 'name')->ignore($this->route('country'), 'id')->where(function ($query) {
                    return $query->where('deleted_at', NULL);
                }),
            ],
            'code' => [
                'required',
                Rule::unique('countries', 'code')->ignore($this->route('country'), 'id')->where(function ($query) {
                    return $query->where('deleted_at', NULL);
                }),
            ],
        ];
    }
}
