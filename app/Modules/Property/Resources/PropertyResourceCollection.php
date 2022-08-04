<?php

namespace App\Modules\Property\Resources;

use App\Modules\Common\Enum\PriceType;
use App\Modules\Property\Enum\ListingStatus;
use Illuminate\Http\Resources\Json\ResourceCollection;

class PropertyResourceCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return $this->collection->map(function ($property) {
            return [
                'id' => $property->id,
                'selling_price' => $property->selling_price,
                'selling_price_type' => PriceType::from($property->selling_price_type)->label(),
                'images' => $property->relations['images'] ? $property->images->pluck('path_thumbnail') : [],
                // 'documents' => $property->documents,
                'listing_status' => ListingStatus::from($property->listing_status)->label(),
                'listing_date' => $property->listing_date,
                'approved_by' => $property->approved_by,
                // 'assignee' => $property->load('assignee') ?? null,
                // 'assignor' => $property->assignor ?? null,

                // todo: implement view count
                'number_of_views' => 0
            ];
        });
    }
}
