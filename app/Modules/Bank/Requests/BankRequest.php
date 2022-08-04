<?php

namespace App\Modules\Bank\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BankRequest extends FormRequest
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
            'bank_name' => 'required|min:2|unique:banks,bank_name',
            'primary_phone' => 'required|unique:banks,primary_phone',
            'secondary_phone' => 'nullable|unique:banks,secondary_phone',
            'published' => 'required|boolean',
            'email' => 'nullable|unique:banks,email',
            'website' => 'nullable|unique:banks,website',
            'logo' => 'nullable',
        ];
    }
}
