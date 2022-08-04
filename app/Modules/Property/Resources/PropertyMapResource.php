<?php

namespace App\Modules\Property\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PropertyMapResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'property_type_id' => $this->property_type_id,
            'location' => [
                'lat_lng' => $this->lat_lng,
            ],
            'published' => $this->published,
            'exclusive' => $this->exclusive,

        ];
    }
}
