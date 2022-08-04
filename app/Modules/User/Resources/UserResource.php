<?php

namespace App\Modules\User\Resources;

use App\Modules\Role\Resources\RoleResource;
use App\Modules\UserProfile\Resources\UserProfileResource;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'show_on_website' => $this->show_on_website,
            'is_active' => $this->is_active,
            'roles' => RoleResource::collection($this->whenLoaded('roles')),
            'profile' => new UserProfileResource($this->whenLoaded('profile')),
            'teams' => $this->whenLoaded('teams', function () {
                return $this->teams->map(fn ($team) => [
                    'team_id' => $team->id,
                    'name' => $team->name,
                    'level' => $team->pivot->level
                ]);
            }),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
