<?php

namespace App\Modules\ContactCompany\Requests;

use App\Rules\PhoneNumber;
use Illuminate\Foundation\Http\FormRequest;

class ContactCompanyRequest extends FormRequest
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
            'url' => 'required',
            'name' => 'required',
            'phone_number' => ['required', new PhoneNumber],
            'subject' => 'required',
            'email' => 'email',
            'message' => 'required|min:12'
        ];
    }
}