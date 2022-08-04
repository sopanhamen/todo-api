<?php

namespace App\Modules\ClientPayment\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClientPaymentRequest extends FormRequest
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
            'client_requirement_id' => 'required',
            'property_id' => 'required',
            'person_in_charge_id' => 'required',
            'payment_date' => 'required|date',
            'next_payment_date' => 'nullable|date',
            'amount' => 'required|numeric',
        ];
    }
}
