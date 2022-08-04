<?php

namespace App\Modules\Property\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PropertyContactResource extends JsonResource
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
            'assignee' => $this->whenLoaded('assignee', fn () => [
                'name' => $this->assignee->name,
                'email' => $this->assignee->email,
                'primary_phone' => $this->assignee->phone,
            ]),
            'sale_contact' => $this->whenLoaded('saleContact', fn () => [
                'id' => $this->saleContact->id,
                'name' => $this->saleContact->name,
                'email' => $this->saleContact->email,
                'primary_phone' => $this->saleContact->primary_phone,
                'secondary_phone' => $this->saleContact->secondary_phone,
                'telegram' => $this->saleContact->telegram,
                'line' => $this->saleContact->line,
                'wechat' => $this->saleContact->wechat,
                'contact_person' => $this->sale_contact_person,
            ]),
            'owner_contact' => $this->whenLoaded('ownerContact', fn () => [
                'id' => $this->ownerContact->id,
                'name' => $this->ownerContact->name,
                'email' => $this->ownerContact->email,
                'primary_phone' => $this->ownerContact->primary_phone,
                'secondary_phone' => $this->ownerContact->secondary_phone,
                'telegram' => $this->ownerContact->telegram,
                'line' => $this->ownerContact->line,
                'wechat' => $this->ownerContact->wechat,
            ]),
        ];
    }
}
