<?php

namespace App\Modules\Developer;

use App\Libraries\Crud\CrudRepository;
use App\Modules\Developer\Developer;

class DeveloperRepository extends CrudRepository
{
    public function __construct(Developer $developer)
    {
        parent::__construct($developer);
    }
}
