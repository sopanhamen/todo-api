<?php

namespace App\Modules\UserProfile\Resources;

use App\Modules\Company\Resources\CompanyResource;
use App\Modules\Contact\Resources\ContactResource;
use App\Modules\FileUpload\FileUploadService;
use Illuminate\Http\Resources\Json\JsonResource;

class UserProfileResource extends JsonResource
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
            // Profile
            'company_id' => $this->company_id ?? null,
            'company' => new CompanyResource($this->whenLoaded('company')),
            'company_branch_id' => $this->company_branch_id ?? null,
            'gender' => $this->gender ?? null,
            'national_id_number' => $this->national_id_number ?? null,
            'national_id_image_front' => $this->national_id_image_front ?? null,
            'national_id_image_back' => $this->national_id_image_back ?? null,
            'passport_number' => $this->passport_number ?? null,
            'passport_id_image_front' => $this->passport_id_image_front ?? null,
            'passport_id_image_back' => $this->passport_id_image_back ?? null,
            'position' => $this->position ?? null,
            'experience' => $this->experience ?? null,
            'skills' => $this->skills ?? null,
            'profile_picture' => [
                'path' => $this->profile_picture,
                'url' => $uploadService->url(
                    $this->profile_picture ?? null,
                    null,
                    $this->profile_picture_disk
                ),
            ],
            'contact' => new ContactResource($this->whenLoaded('contact')),
        ];
    }
}
