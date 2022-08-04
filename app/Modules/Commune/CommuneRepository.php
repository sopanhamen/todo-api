<?php

namespace App\Modules\Commune;

use App\Libraries\Crud\CrudRepository;
use App\Modules\Commune\Commune;

class CommuneRepository extends CrudRepository
{
    public function __construct(Commune $commune)
    {
        parent::__construct($commune);
    }
}
