<?php

namespace App\Modules\Province\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class ProvinceRequest extends FormRequest
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
                Rule::unique('provinces', 'name_km')->where(function ($query) {
                    return $query->where('country_id',  request('country_id'))->where('deleted_at', NULL);
                }),
            ],
            'name_en' => [
                'required',
                Rule::unique('provinces', 'name_en')->where(function ($query) {
                    return $query->where('country_id',  request('country_id'))->where('deleted_at', NULL);
                }),
            ],
            "country_id" => "required|exists:countries,id,deleted_at,NULL",
            "published" => "required|boolean",
        ];
    }
}
