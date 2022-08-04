<?php

namespace App\Modules\Province\Requests;

use Illuminate\Validation\Rule;

class UpdateProvinceRequest extends ProvinceRequest
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
            'name_km' => [
                'required',
                Rule::unique('provinces', 'name_km')->ignore($this->route('province'), 'id')->where(function ($query) {
                    return $query->where('country_id', request('country_id'))->where('deleted_at', NULL);
                }),
            ],
            'name_en' => [
                'required',
                Rule::unique('provinces', 'name_en')->ignore($this->route('province'), 'id')->where(function ($query) {
                    return $query->where('country_id', request('country_id'))->where('deleted_at', NULL);
                }),
            ],
        ];
    }
}
