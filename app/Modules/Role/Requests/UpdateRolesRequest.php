<?php

namespace App\Modules\Role\Requests;

use Illuminate\Validation\Rules\Enum;

class UpdateRolesRequest extends RoleRequest
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
            'roles.*.id' => ['required'],
            'roles.*.name' => ['required', 'min:2'],
            // 'roles.*.permissions.*' => [new Enum(Permission::class)]
        ];
    }
}
