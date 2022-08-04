<?php

namespace App\Modules\UserTeam;

use App\Libraries\Crud\CrudRepository;
use App\Modules\UserTeam\UserTeam;

class UserTeamRepository extends CrudRepository
{
    public function __construct(UserTeam $userTeam)
    {
        parent::__construct($userTeam);
    }
}
