<?php

namespace App\Modules\PropertyType;

use Illuminate\Support\Facades\DB;
use App\Libraries\Crud\CrudRepository;
use App\Modules\PropertyType\PropertyType;

class PropertyTypeRepository extends CrudRepository
{
    public function __construct(PropertyType $propertyType)
    {
        parent::__construct($propertyType);
    }

    public function getPropertyTypeHaveProperties($propTypeId)
    {
        return DB::table('properties')
            ->where('property_type_id', $propTypeId)
            ->whereNull('deleted_at')->exists();
    }
}