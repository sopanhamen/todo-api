<?php

namespace App\Modules\BankBranch\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BankBranchRequest extends FormRequest
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
            // Required fields
            'bank_id' => 'required',
            'branch_name' => 'required|min:2',
            'primary_phone' => 'required|min:9',
            'country_id' => 'required',
            'province_id' => 'required',
            'district_id' => 'required',
            'commune_id' => 'required',
            'published' => 'required|boolean',

            // Optional fields
            'secondary_phone' => 'nullable|min:9',
            'third_phone' => 'nullable|min:9',
            'email' => 'nullable|email',
            'image' => 'nullable',
            'village' => 'nullable|min:1',
            'street' => 'nullable|min:1',
            'house' => 'nullable|min:1',
            'office_type' => 'nullable|min:1',
            'building' => 'nullable|min:1',
            'floor' => 'nullable|min:1',
            'lat_lng' => 'nullable|min:1',
        ];
    }
}
