<?php

namespace App\Modules\Developer\Requests;

use Illuminate\Validation\Rule;

class UpdateDeveloperRequest extends DeveloperRequest
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
                Rule::unique('developers', 'name')
                    ->ignore($this->route('developer'), 'id')
                    ->where(function ($query) {
                        return $query->where('deleted_at', NULL);
                    }),
            ],
        ];
    }
}
