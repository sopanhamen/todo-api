<?php

namespace App\Modules\UserTeam\Requests;

use Illuminate\Validation\Rule;

class UpdateUserTeamRequest extends UserTeamRequest
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
            "name" => [
                'required',
                Rule::unique('user_teams', 'name')
                    ->ignore($this->route('user_team'))
                    ->where('company_branch_id', request('company_branch_id')),
            ]
        ];
    }
}
