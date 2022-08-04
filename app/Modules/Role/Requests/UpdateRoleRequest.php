<?php

namespace App\Modules\Role\Requests;

use Illuminate\Validation\Rule;

class UpdateRoleRequest extends RoleRequest
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
        $id = $this->route('role');
        return [
            ...parent::rules(),
            'name' => [
                'required',
                'min:2',
                Rule::unique('roles', 'name')->ignore($id, 'id')->where(function ($query) {
                    $query->where('guard_name', config('auth.defaults.guard'));
                }),
            ],
        ];
    }
}
