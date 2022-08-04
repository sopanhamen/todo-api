<?php

namespace App\Modules\Listing\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ListingSummaryResource extends JsonResource
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
            'total' => $this->resource['total'],
            'featured' => ListingResource::collection($this->resource['featured']),
            'data' => array_map(function ($item) {
                return [
                    ...$item,
                    'latests' => ListingResource::collection($item['latests'])
                ];
            }, $this->resource['data']),
        ];
    }
}
