<?php

namespace App\Modules\Role\Resources;

use App\Modules\User\Resources\UserResource;
use Illuminate\Http\Resources\Json\JsonResource;

class RoleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $permissions = $this->whenLoaded('permissions');
        return [
            'id' => $this->id,
            'name' => $this->name,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'permissions' => $permissions ? collect($permissions)->pluck('name') : [],
            'users' => UserResource::collection($this->whenLoaded('users')),
        ];
    }
}
