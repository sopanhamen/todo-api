<?php

namespace App\Modules\ClientRequirement\Requests;

use App\Modules\ClientRequirement\Enum\Service;
use App\Modules\ClientRequirement\Enum\Result;
use App\Modules\Common\Enum\PriceType;
use App\Modules\Common\Enum\Priority;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class ClientRequirementRequest extends FormRequest
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
     * @return arrayphp 
     */
    public function rules()
    {
        return [
            'client_id' => 'required',
            'preferred_property_types' => 'nullable',
            'service' => [new Enum(Service::class)],
            'price_type' => [new Enum(PriceType::class)],
            'priority' => [new Enum(Priority::class)],
            'result' => [new Enum(Result::class)],
            'purpose' => 'nullable',
            'note' => 'nullable',
        ];
    }
}
