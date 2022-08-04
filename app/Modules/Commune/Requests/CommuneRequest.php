<?php

namespace App\Modules\Commune\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class CommuneRequest extends FormRequest
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
                Rule::unique('communes', 'name_km')->where(function ($query) {
                    return $query->where('district_id',  request('district_id'))->where('deleted_at', NULL);
                }),
            ],
            'name_en' => [
                'required',
                Rule::unique('communes', 'name_en')->where(function ($query) {
                    return $query->where('district_id',  request('district_id'))->where('deleted_at', NULL);
                }),
            ],
            'code' => ['required', Rule::unique('communes', 'code')->whereNull('deleted_at')],
            "district_id" => "required|exists:districts,id,deleted_at,NULL",
            "published" => "required|boolean",
        ];
    }
}