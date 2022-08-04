<?php

namespace App\Modules\Setting;

use App\Libraries\Crud\CrudRepository;
use App\Modules\Setting\Setting;

class SettingRepository extends CrudRepository
{
    protected int $limit = 100;

    public function __construct(Setting $setting)
    {
        parent::__construct($setting);
    }
}
