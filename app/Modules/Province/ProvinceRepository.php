<?php

namespace App\Modules\Province;

use App\Libraries\Crud\CrudRepository;
use App\Modules\Province\Province;

class ProvinceRepository extends CrudRepository
{
    public function __construct(Province $province)
    {
        parent::__construct($province);
    }
}
