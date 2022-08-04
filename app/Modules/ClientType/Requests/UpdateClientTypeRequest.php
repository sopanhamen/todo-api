<?php

namespace App\Modules\ClientType\Requests;

use Illuminate\Validation\Rule;

class UpdateClientTypeRequest extends ClientTypeRequest
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
                Rule::unique('client_types', 'name')
                    ->ignore($this->route('client_type'), 'id')
                    ->where(function ($query) {
                        return $query->where('deleted_at', NULL);
                    }),
            ],
        ];
    }
}
