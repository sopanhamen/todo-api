<?php

namespace App\Modules\District\Requests;

use Illuminate\Validation\Rule;

class UpdateDistrictRequest extends DistrictRequest
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
                Rule::unique('districts', 'name_km')->ignore($this->route('district'), 'id')->where(function ($query) {
                    return $query->where('province_id', request('province_id'))->where('deleted_at', NULL);
                }),
            ],
            'name_en' => [
                'required',
                Rule::unique('districts', 'name_en')->ignore($this->route('district'), 'id')->where(function ($query) {
                    return $query->where('province_id', request('province_id'))->where('deleted_at', NULL);
                }),
            ],
        ];
    }
}
