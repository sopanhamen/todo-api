<?php

namespace App\Modules\PropertyVisit\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PropertyVisitRequest extends FormRequest
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
            'visited_at' => 'required',
            'status' => 'required',
        ];
    }
}
