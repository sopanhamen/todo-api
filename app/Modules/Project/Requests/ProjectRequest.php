<?php

namespace App\Modules\Project\Requests;

use App\Rules\PhoneNumber;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;
use App\Modules\Common\Enum\Direction;

class ProjectRequest extends FormRequest
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
            "name" => "required|min:2|unique:projects,name",
            "development_type_id" => "required|integer|exists:development_types,id,deleted_at,NULL",
            "developer_id" => "required|integer|exists:developers,id,deleted_at,NULL",
            "total_floor" => "nullable|integer",
            "total_unit" => "nullable|integer",
            "total_one_bedroom" => "nullable|numeric",
            "one_bedroom_size" => "nullable|numeric",
            "one_bedroom_size_to" => "nullable|numeric",
            "total_two_bedroom" => "nullable|numeric",
            "two_bedroom_size" => "nullable|numeric|numeric",
            "two_bedroom_size_to" => "nullable|numeric",
            "total_three_bedroom" => "nullable|numeric",
            "three_bedroom_size" => "nullable|numeric",
            "three_bedroom_size_to" => "nullable|numeric",
            "pent_house_size" => "nullable|numeric",
            "primary_phone" => ['nullable', new PhoneNumber],
            "secondary_phone" => ['nullable', new PhoneNumber],
            "email" => "nullable|email",
            "facebook" => "nullable",
            "country_id" => "required|uuid|exists:countries,id,deleted_at,NULL",
            "province_id" => "required|uuid|exists:provinces,id,deleted_at,NULL",
            "district_id" => "required|uuid|exists:districts,id,deleted_at,NULL",
            "commune_id" => "nullable|uuid|exists:communes,id,deleted_at,NULL",
            "village" => "nullable",
            "street_no" => "nullable",
            "building_no" => "nullable",
            // "direction" => [new Enum(Direction::class)],
            "road_con" => "nullable|integer",
            "road_dir_width" => "nullable|numeric",
            "lat_lng" => "nullable",
            "image_one" => "nullable",
            "image_two" => "nullable",
            "image_three" => "nullable",
            "image_four" => "nullable",
            "image_five" => "nullable",
            "published" => "required|boolean",
            "exclusive" => "required|boolean",
        ];
    }
}
