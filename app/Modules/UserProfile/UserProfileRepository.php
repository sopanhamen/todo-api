<?php

namespace App\Modules\UserProfile;

use App\Libraries\Crud\CrudRepository;
use App\Modules\UserProfile\UserProfile;

class UserProfileRepository extends CrudRepository
{
    public function __construct(UserProfile $userProfile)
    {
        parent::__construct($userProfile);
    }
}
