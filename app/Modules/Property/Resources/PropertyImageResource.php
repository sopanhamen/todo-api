<?php

namespace App\Modules\Property\Resources;

use App\Modules\FileUpload\FileUploadService;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class PropertyImageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $uploadService = new FileUploadService();

        return [
            'id' => $this->id,
            'path' => $this->path_large,
            'image_url' => $uploadService->url($this->path_large, null, $this->storage_disk),
            'thumbnail_url' => $uploadService->url($this->path_thumbnail, null, $this->storage_disk),
        ];
    }
}
