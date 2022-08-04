<?php

namespace App\Modules\PropertyNegotiation\Requests;

use App\Modules\Client\Enum\NegotiationStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class PropertyNegotiationRequest extends FormRequest
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
            'negotiated_at' => 'required|date',

            'last_owner_price' => 'required|numeric',
            'last_buyer_price' => 'required|numeric',
            'last_agreed_price' => 'nullable|numeric',

            'status' => ['required', new Enum(NegotiationStatus::class)]
        ];
    }
}
