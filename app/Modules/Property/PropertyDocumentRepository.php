<?php

namespace App\Modules\Property;

use App\Libraries\Crud\CrudRepository;

class PropertyDocumentRepository extends CrudRepository
{
    public function __construct(PropertyDocument $propertyDocument)
    {
        parent::__construct($propertyDocument);
    }

    /**
     * string $propertyId
     */
    public function getAll(string $propertyId, $fields = ['*'])
    {
        return PropertyDocument::select($fields)->where('property_id', $propertyId)->get();
    }

    /**
     * @param string $documentId
     * @param string $propertyId
     * @return null|PropertyDocument
     */
    public function getOneOfProperty(string $documentId, string $propertyId): ?PropertyDocument
    {
        return $this->model
            ->where('id', $documentId)
            ->where('property_id', $propertyId)
            ->select(['id', 'file_path', 'file_type'])
            ->first();
    }
}
