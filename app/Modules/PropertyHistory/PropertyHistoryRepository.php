<?php

namespace App\Modules\PropertyHistory;

use App\Libraries\Crud\CrudRepository;
use App\Modules\Property\Property;
use App\Modules\PropertyHistory\PropertyHistory;

class PropertyHistoryRepository extends CrudRepository
{
    public function __construct(PropertyHistory $propertyHistory)
    {
        parent::__construct($propertyHistory);
    }

    public function copy(Property $property): PropertyHistory
    {
        $propertyData = $property->toArray();
        $propertyData['property_id'] = $property->id;

        return $this->model->create($propertyData);
    }
}
