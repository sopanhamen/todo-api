<?php

namespace App\Modules\DevelopmentType;

use App\Libraries\Crud\CrudRepository;
use App\Modules\DevelopmentType\DevelopmentType;

class DevelopmentTypeRepository extends CrudRepository
{
    public function __construct(DevelopmentType $developmentType)
    {
        parent::__construct($developmentType);
    }
}
