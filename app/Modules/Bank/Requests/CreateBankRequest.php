<?php

namespace App\Modules\Bank\Requests;

use App\Modules\Bank\Requests\BankRequest;

class CreateBankRequest extends BankRequest
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
        ];
    }
}
