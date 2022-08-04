<?php

namespace App\Modules\ClientRequirement\Resources;

use App\Modules\Client\Resources\ClientResource;
use App\Modules\ClientPayment\Resources\ClientPaymentResource;
use App\Modules\Property\Resources\PropertyResource;
use App\Modules\PropertyNegotiation\Resources\PropertyNegotiationResource;
use App\Modules\PropertyVisit\Resources\PropertyVisitResource;
use App\Modules\User\Resources\UserResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ClientRequirementResource extends JsonResource
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
            'client_id' => $this->client_id,
            'code' => $this->code,
            'budget_min' => $this->budget_min,
            'budget_max' => $this->budget_max,
            'service' => $this->service,
            'price_type' => $this->price_type,
            'priority' => $this->priority,
            'purpose' => $this->purpose,
            'specific_place' => $this->specific_place,
            'result' => $this->result,
            'note' => $this->note,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'deleted_at' => $this->deleted_at,

            'visits' => PropertyVisitResource::collection($this->whenLoaded('visits')),
            'negotiations' => PropertyNegotiationResource::collection($this->whenLoaded('negotiations')),
            'agreed_negotiation' => new PropertyNegotiationResource($this->whenLoaded('agreedNegotiation')),
            'payments' => ClientPaymentResource::collection($this->whenLoaded('payments')),

            'preferred_property_types' => $this->whenLoaded(
                'preferredPropertyTypes',
                $this->preferredPropertyTypes->pluck('id')
            ),
            'preferred_projects' => $this->whenLoaded(
                'preferredProjects',
                $this->preferredProjects->pluck('id')
            ),
            'preferred_developers' => $this->whenLoaded(
                'preferredDevelopers',
                $this->preferredDevelopers->pluck('id')
            ),
            'preferred_countries' => $this->whenLoaded(
                'preferredCountries',
                $this->preferredCountries->pluck('id')
            ),
            'preferred_provinces' => $this->whenLoaded(
                'preferredProvinces',
                $this->preferredProvinces->pluck('id')
            ),
            'preferred_districts' => $this->whenLoaded(
                'preferredDistricts',
                $this->preferredDistricts->pluck('id')
            ),
            'preferred_communes' => $this->whenLoaded(
                'preferredCommunes',
                $this->preferredCommunes->pluck('id')
            ),
            'client' => new ClientResource($this->whenLoaded('client')),
            'property_id' => $this->property_id,
            'property' => new PropertyResource($this->whenLoaded('property')),
            'creator' => new UserResource($this->whenLoaded('creator')),
            'updater' => new UserResource($this->whenLoaded('updater')),
        ];
    }
}