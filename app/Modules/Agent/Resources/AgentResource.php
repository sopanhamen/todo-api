<?php

namespace App\Modules\Agent\Resources;

use App\Modules\Listing\Resources\ListingResource;
use App\Modules\UserProfile\Resources\UserProfileResource;
use App\Modules\UserTeam\Resources\UserTeamResource;
use Illuminate\Http\Resources\Json\JsonResource;

class AgentResource extends JsonResource
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
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'profile' => new UserProfileResource($this->whenLoaded('profile')),
            'teams' => new UserTeamResource($this->whenLoaded('teams')),
            'properties' => ListingResource::collection($this->whenLoaded('publishedProperties')),
            'properties_count' => (int) $this->published_properties_count,
            'show_on_website' => $this->show_on_website,
            'is_active' => $this->is_active,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
