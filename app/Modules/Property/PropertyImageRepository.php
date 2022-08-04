<?php

namespace App\Modules\Property;

use App\Libraries\Crud\CrudRepository;

class PropertyImageRepository extends CrudRepository
{
    public function __construct(PropertyImage $propertyImage)
    {
        parent::__construct($propertyImage);
    }

    /**
     * @param string $imageId
     * @param string $propertyId
     * @return null|PropertyImage
     */
    public function getOneOfProperty(string $imageId, string $propertyId): ?PropertyImage
    {
        return $this->model
            ->where('id', $imageId)
            ->where('property_id', $propertyId)
            ->select(['id', 'path_large', 'path_thumbnail'])
            ->first();
    }
}
