<?php

namespace App\Modules\Commune\Requests;

use Illuminate\Validation\Rule;

class UpdateCommuneRequest extends CommuneRequest
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
            'name_km' => [
                'required',
                Rule::unique('communes', 'name_km')->ignore($this->route('commune'), 'id')->where(function ($query) {
                    return $query->where('district_id', request('district_id'))->where('deleted_at', NULL);
                }),
            ],
            'name_en' => [
                'required',
                Rule::unique('communes', 'name_en')->ignore($this->route('commune'), 'id')->where(function ($query) {
                    return $query->where('district_id', request('district_id'))->where('deleted_at', NULL);
                }),
            ],
            'code' => ['required', Rule::unique('communes', 'code')
                ->ignore($this->route('commune'), 'id')
                ->whereNull('deleted_at')]
        ];
    }
}