<?php

namespace App\Modules\User;

use App\Libraries\Crud\CrudRepository;
use App\Modules\User\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use phpDocumentor\Reflection\Types\Boolean;

class UserRepository extends CrudRepository
{
    public function __construct(User $user)
    {
        parent::__construct($user);
    }

    /**
     * @param int $userId
     * @return Collection
     */
    public function getTeammateUsers(int $userId): Collection
    {
        return $this->model
            ->select('users.id', 'users.name', 'users.email', 'users.phone')
            ->leftJoin('user_profiles as team_profile', 'team_profile.user_id', '=', 'users.id')
            ->whereExists(function ($query) use ($userId) {
                $query->select(DB::raw(1))
                    ->from('user_profiles')
                    ->where('user_profiles.user_id', $userId)
                    ->whereColumn('user_profiles.team_id', 'team_profile.team_id');
            })
            ->whereNotExists(function ($query) {
                $query->select(DB::raw(1))
                    ->from('model_has_roles')
                    ->where('role_id', config('user.default_user.super_admin.id'))
                    ->whereColumn('users.id', 'model_has_roles.model_id');
            })
            ->get();
    }

    /**
     * @param string $username
     * @return null|User
     */
    public function findByUsername(string $username, ?array $relations = []): ?User
    {
        return  User::with($relations)
            ->where('username', $username)
            ->first();
    }

    /**
     * @param string $email
     * @return null|User
     */
    public function findByEmail(string $email, ?array $relations = []): ?User
    {
        return  User::with($relations)
            ->whereHas('profile.contact', function (Builder $query) use ($email) {
                return $query->where('email', $email);
            })
            ->first();
    }

    /**
     * @param string $phone
     * @return null|User
     */
    public function findByPhoneNumber(string $phone, ?array $relations = []): ?User
    {
        return  User::with($relations)
            ->whereHas('profile.contact', function (Builder $query) use ($phone) {
                return $query->where('primary_phone', $phone);
            })
            ->first();
    }

    /**
     * @param string $email
     * @return boolean
     */
    public function findSuperUser($email)
    {
        return  DB::table('users')
            ->where('users.email', $email)
            ->where('name', config('user.default_user.super_admin.role_name'))
            ->whereNull('deleted_at')
            ->exists();
    }
}
