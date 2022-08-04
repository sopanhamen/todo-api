<?php

namespace App\Modules\Setting;

use App\Libraries\Cache\Cacheable;
use App\Libraries\Crud\CrudModel;
use App\Libraries\Database\Traits\UuidPrimaryKey;

class Setting extends CrudModel
{
    use UuidPrimaryKey, Cacheable;

    protected $fillable = [
        'setting_key', 'setting_value'
    ];
}
