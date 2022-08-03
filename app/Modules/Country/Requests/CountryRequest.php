<?php

namespace App\Modules\Country\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CountryRequest extends FormRequest
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
                Rule::unique('countries', 'name')->where(function($query) {
                    return $query->where('deleted_at', NULL);
                })
            ],
            "code" => [
                "required",
                Rule::unique('countries', 'code')->where(function($query){
                    return $query->where('deleted_at', NULL);
                })
            ],
            "iso_code" => "required",
            "published" => "required|boolean",
        ];
    }
}
