<?php

namespace App\Modules\Project\Requests;

use Illuminate\Validation\Rule;

class UpdateProjectRequest extends ProjectRequest
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
            'name' => ["required", 'min:2', Rule::unique('projects', 'name')->ignore($this->route('project'))],
        ];
    }
}
