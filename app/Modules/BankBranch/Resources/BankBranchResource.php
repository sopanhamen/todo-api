<?php

namespace App\Modules\BankBranch\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BankBranchResource extends JsonResource
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
            ...parent::toArray($request),
            'image' => $request->image ? asset($request->image) : config('common.no_image_url'),
        ];
    }
}
