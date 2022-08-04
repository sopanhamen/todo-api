<?php

namespace App\Modules\FileUpload\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MultiDocumentUploadRequest extends FormRequest
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
            'documents' => 'required',
            'documents.*' => 'required|mimes:pdf,docx,xlsx,mp3,mp4,avi,png,jpg,jpeg',
            'directory' => 'nullable'
        ];
    }
}
