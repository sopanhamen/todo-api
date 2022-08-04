<?php

namespace App\Modules\Client\Resources;

use App\Modules\ClientRequirement\Resources\ClientRequirementResource;
use App\Modules\ClientType\Resources\ClientTypeResource;
use App\Modules\Contact\Resources\ContactResource;
use App\Modules\User\Resources\UserResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ClientResource extends JsonResource
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
            'client_type_id' => $this->client_type_id,
            'client_contact_id' => $this->client_contact_id,
            'published' => $this->published,
            'source' => $this->source,
            'company_id' => $this->company_id,
            'company_branch_id' => $this->company_branch_id,
            'team_id' => $this->team_id,
            'assignee_id' => $this->assignee_id,
            'profile_picture' => ($this->profile_picture ?? null)
                ? asset($this->profile_picture)
                : config('common.no_photo_url'),

            'contact' => new ContactResource($this->whenLoaded('contact')),

            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'deleted_at' => $this->deleted_at,
            'client_type' => new ClientTypeResource($this->whenLoaded('clientType')),
            'requirements' => ClientRequirementResource::collection($this->whenLoaded('requirements')),
            'active_requirements' => ClientRequirementResource::collection(
                $this->whenLoaded('activeRequirements')
            ),
            'creator' => new UserResource($this->whenLoaded('creator')),
            'updater' => new UserResource($this->whenLoaded('updater')),
        ];
    }
}
