<?php

namespace App\Modules\Bank\Requests;

use App\Modules\Bank\Requests\BankRequest;
use Illuminate\Validation\Rule;

class UpdateBankRequest extends BankRequest
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
        $id = $this->route('bank');
        return [
            ...parent::rules(),
            'bank_name' => [
                'required',
                'min:2',
                Rule::unique('banks', 'bank_name')->ignore($id, 'id')
            ],
            'primary_phone' => [
                'required',
                Rule::unique('banks', 'primary_phone')->ignore($id, 'id')
            ],
            'secondary_phone' => [
                'nullable',
                Rule::unique('banks', 'secondary_phone')->ignore($id, 'id')
            ],
            'email' => [
                'nullable',
                Rule::unique('banks', 'email')->ignore($id, 'id')
            ],
            'website' => [
                'nullable',
                Rule::unique('banks', 'website')->ignore($id, 'id')
            ]
        ];
    }
}
