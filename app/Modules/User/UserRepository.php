<?php

namespace App\Modules\User;

use App\Libraries\Crud\CrudRepository;
use App\Modules\User\User;

class UserRepository extends CrudRepository
{
    public function __construct(User $user)
    {
        parent::__construct($user);
    }
}
