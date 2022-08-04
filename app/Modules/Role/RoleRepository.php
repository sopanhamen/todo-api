<?php

namespace App\Modules\Role;

use App\Libraries\Crud\CrudRepository;
use App\Modules\Role\Role;

class RoleRepository extends CrudRepository
{
    public function __construct(Role $role)
    {
        parent::__construct($role);
    }
}
