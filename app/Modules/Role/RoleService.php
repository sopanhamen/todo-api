<?php

namespace App\Modules\Role;

use App\Libraries\Crud\CrudService;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class RoleService extends CrudService
{
    protected array $allowedRelations = ['permissions', 'users'];

    public function __construct(RoleRepository $repo)
    {
        parent::__construct($repo);
    }

    /**
     * This value will we used to filter in every query using this service
     */
    public function excludes()
    {
        return ['name' => config('user.default_user.super_admin.role_name')];
    }

    /**
     * Create one record
     *
     * @param array $payload
     * @return null|Role
     */
    public function createOne(array $payload): ?Role
    {
        return DB::transaction(function () use ($payload) {
            $role = $this->repo->createOne([...$payload, 'created_at' => Carbon::now()]);
            $role->syncPermissions($payload['permissions'] ?? []);
            return $role;
        });
    }

    /**
     * Create one record
     *
     * @param array|Collection $payload
     * @return null|Role
     */
    public function updateOne(string|int $id, array $payload, string $idColumn  = null): ?Model
    {
        return DB::transaction(function () use ($id, $payload) {
            $role = $this->repo->updateOneById($id, [...$payload, 'updated_at' => Carbon::now()]);
            $role->syncPermissions($payload['permissions'] ?? []);
            return $role;
        });
    }

    /**
     * @param array $roles
     * @return Collection
     */
    public function updateMultiple(array $data)
    {
        return DB::transaction(function () use ($data) {
            $roles = Role::whereIn('id', array_column($data, 'id'))->get();
            $roleData = collect($data);

            foreach ($roles as $role) {
                $permissions = $roleData->where('id', $role->id)->first()['permissions'];
                $role->syncPermissions($permissions ?? []);
            }

            return $roles;
        });
    }
}
