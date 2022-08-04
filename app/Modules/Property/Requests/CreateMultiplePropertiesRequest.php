<?php

namespace App\Modules\Property\Requests;

use App\Libraries\Validation\Trait\HasSubRules;
use Illuminate\Foundation\Http\FormRequest;

class CreateMultiplePropertiesRequest extends FormRequest
{
    use HasSubRules;

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
            ...$this->subRules('properties.*', (new CreatePropertyRequest)->rules())
        ];
    }
}
