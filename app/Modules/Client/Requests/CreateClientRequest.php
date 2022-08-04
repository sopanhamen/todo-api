<?php

namespace App\Modules\Client\Requests;

use App\Libraries\Validation\Trait\HasSubRules;
use App\Modules\ClientRequirement\Requests\ClientRequirementRequest;

class CreateClientRequest extends ClientRequest
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
        // if (request('requirement')) {
        //     $requirementRules = (new ClientRequirementRequest())->rules();
        //     $requirementRules = collect($requirementRules)->except('client_id')->all();
        //     return [
        //         ...parent::rules(),
        //         ...$this->subRules('requirement', $requirementRules)
        //     ];
        // }

        return [
            ...parent::rules(),
        ];
    }
}
