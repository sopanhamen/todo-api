<?php

namespace App\Modules\Agent;

use App\Libraries\Crud\CrudRepository;
use App\Modules\User\User;

class AgentRepository extends CrudRepository
{
    public function __construct(User $user)
    {
        parent::__construct($user);
    }
}
