<?php

namespace App\Modules\UserLevel;

use App\Libraries\Crud\CrudRepository;
use App\Modules\UserLevel\UserLevel;

class UserLevelRepository extends CrudRepository
{
    public function __construct(UserLevel $userLevel)
    {
        parent::__construct($userLevel);
    }
}
