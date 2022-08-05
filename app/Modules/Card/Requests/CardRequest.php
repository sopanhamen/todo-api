<?php

namespace App\Modules\Card\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;


class CardRequest extends FormRequest
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
            "card_number" => [
                "required",
                Rule::unique('cards', 'card_number')->where(function ($query) {
                    return $query->where('deleted_at', NULL);
                }),
            ],
            "balance" => "required",
            "exp_date" => "required"
        ];
    }
}
