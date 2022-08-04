<?php

namespace App\Modules\UserTeam\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserTeamRequest extends FormRequest
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
            'company_branch_id' => 'required',
            'name' => [
                'required',
                Rule::unique('user_teams', 'name')
                    ->where('company_branch_id', request('company_branch_id'))
            ],
        ];
    }
}
