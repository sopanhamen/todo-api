<?php

namespace App\Modules\UserLevel;

use App\Libraries\Crud\CrudService;

class UserLevelService extends CrudService
{
    protected array $allowedRelations = [];

    public function __construct(UserLevelRepository $repo)
    {
        parent::__construct($repo);
    }
}
