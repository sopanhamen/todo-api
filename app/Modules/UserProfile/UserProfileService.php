<?php

namespace App\Modules\UserProfile;

use App\Libraries\Crud\CrudService;

class UserProfileService extends CrudService
{
    protected array $allowedRelations = ['contact'];

    public function __construct(UserProfileRepository $repo)
    {
        parent::__construct($repo);
    }
}
