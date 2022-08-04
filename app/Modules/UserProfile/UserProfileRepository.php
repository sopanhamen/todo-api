<?php

namespace App\Modules\UserProfile;

use App\Libraries\Crud\CrudRepository;
use App\Modules\User\User;
use App\Modules\UserProfile\UserProfile;

class UserProfileRepository extends CrudRepository
{
    public function __construct(UserProfile $userProfile)
    {
        parent::__construct($userProfile);
    }

    public function getBasicProfile(string|User $user): ?UserProfile
    {
        $userId = $user instanceof User ? $user->id : $user;

        return $this->model
            ->with(['teams' => fn ($q) => $q->select('id', 'team_id')])
            ->select('user_id', 'company_id', 'company_branch_id')
            ->where('user_id', $userId)
            ->first();
    }
}
