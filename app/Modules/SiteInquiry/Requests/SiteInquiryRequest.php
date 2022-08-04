<?php

namespace App\Modules\SiteInquiry\Requests;

use App\Rules\PhoneNumber;
use App\Rules\Recaptcha;
use Illuminate\Foundation\Http\FormRequest;

class SiteInquiryRequest extends FormRequest
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
            // 'token' => ['required', new Recaptcha('contact')],
            'url' => 'required',
            'property_id' => 'required',
            'phone_number' => ['required', new PhoneNumber],
            'email' => 'email',
            'message' => 'required|min:12'
        ];
    }
}
