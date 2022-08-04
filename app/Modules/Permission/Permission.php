<?php

namespace App\Modules\Permission;

use App\Libraries\Database\Traits\UuidPrimaryKey;
use Spatie\Permission\Models\Permission as SpatiePermission;

class Permission extends SpatiePermission
{
    use UuidPrimaryKey;

    protected $guard_name = 'api';

    protected $hidden = ['guard_name'];
}
