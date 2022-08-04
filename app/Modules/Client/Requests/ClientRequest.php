<?php

namespace App\Modules\Client\Requests;

use App\Libraries\Validation\Trait\HasSubRules;
use App\Modules\Client\Enum\ClientSource;
use App\Modules\Common\Enum\Gender;
use App\Modules\Contact\Requests\ContactRequest;
use App\Rules\UniqueClientContact;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;

class ClientRequest extends FormRequest
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
        return  [
            'company_id' => 'required',
            'company_branch_id' => 'required',
            'team_id' => 'required',
            'assignee_id' => 'required',
            'client_type_id' => 'nullable',
            'source' => ['nullable', new Enum(ClientSource::class)],
            'published' => 'required|boolean',

            ...$this->subRules('contact', (new ContactRequest)->rules()),
            'contact.primary_phone' => [new UniqueClientContact()],

            'requirement' => 'nullable',
        ];
    }

    public function messages()
    {
        return [
            'contact.primary_phone.unique' => 'This Phone Number is already in use.'
        ];
    }
}
