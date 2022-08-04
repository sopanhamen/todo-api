<?php

namespace App\Modules\District\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class DistrictRequest extends FormRequest
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
            'name_km' => [
                'required',
                Rule::unique('districts', 'name_km')->where(function ($query) {
                    return $query->where('province_id',  request('province_id'))->where('deleted_at', NULL);
                }),
            ],
            'name_en' => [
                'required',
                Rule::unique('districts', 'name_en')->where(function ($query) {
                    return $query->where('province_id',  request('province_id'))->where('deleted_at', NULL);
                }),
            ],
            "province_id" => "required|exists:provinces,id,deleted_at,NULL",
            "published" => "required|boolean",
        ];
    }
}
