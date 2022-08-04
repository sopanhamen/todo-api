<?php

namespace App\Modules\Role;

use App\Libraries\Database\Traits\UuidPrimaryKey;
use Spatie\Permission\Models\Role as SpatieRole;

class Role extends SpatieRole
{
    use UuidPrimaryKey;

    protected $guard_name = 'api';

    protected $hidden = ['guard_name'];
}
