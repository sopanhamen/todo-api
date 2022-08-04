<?php

namespace App\Modules\DevelopmentType\Requests;

use Illuminate\Validation\Rule;

class UpdateDevelopmentTypeRequest extends DevelopmentTypeRequest
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
                Rule::unique('development_types', 'name')
                    ->ignore($this->route('development_type'), 'id')
                    ->where(function ($query) {
                        return $query->where('deleted_at', NULL);
                    }),
            ],
        ];
    }
}
