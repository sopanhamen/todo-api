<?php

namespace App\Modules\Company\Requests;

use Illuminate\Validation\Rule;

class UpdateCompanyRequest extends CompanyRequest
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
            'name' => [
                'required',
                Rule::unique('companies', 'name')->ignore($this->route('company'), 'id')->where(function ($query) {
                    return $query->where('deleted_at', NULL);
                }),
            ],
        ];
    }
}
