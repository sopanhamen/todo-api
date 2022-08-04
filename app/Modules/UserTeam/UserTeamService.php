<?php

namespace App\Modules\UserTeam;

use App\Libraries\Crud\CrudService;
use App\Modules\CompanyBranch\CompanyBranch;
use App\Modules\User\User;
use Illuminate\Support\Facades\DB;

class UserTeamService extends CrudService
{
    protected array $allowedRelations = ['users', 'branch', 'branch.company'];

    public function __construct(UserTeamRepository $repo)
    {
        parent::__construct($repo);
    }

    /**
     * @param CompanyBranch $companyBranch
     */
    public function createDefaultTeam(CompanyBranch $companyBranch)
    {
        return $this->repo->createOne([
            'name' => $companyBranch->name,
            'company_branch_id' => $companyBranch->id
        ]);
    }

    /**
     * Create one user team
     *
     * @param array $payload
     * @return null|Model
     */
    public function createOne(array $payload): ?UserTeam
    {
        return DB::transaction(function ()  use ($payload) {
            $team = $this->repo->createOne($payload);

            if (!empty($payload['users'])) {
                $this->syncUsers($team, $payload['users']);
            }

            return $team;
        });
    }

    /**
     * Update one user team
     *
     * @param string|int $id
     * @param array $payload
     * @param string $field (default = "id")
     * @return null|UserTeam
     */
    public function updateOne(string|int $id, array $payload, string $idColumn = null): ?UserTeam
    {
        return DB::transaction(function ()  use ($payload, $id, $idColumn) {
            $team = $this->repo->updateOne(
                $this->repo->getOneOrFail($id, $idColumn),
                $payload
            );

            $this->syncUsers($team, $payload['users']);

            return $team;
        });
    }

    /**
     * @param UserTeam $team
     * @param array $data [user_id, level]
     * @return array
     */
    public function syncUsers(UserTeam $team, array $data): array
    {
        $pivotData = [];
        foreach ($data as $item) {
            $pivotData[$item['user_id']]  = ['level' => $item['level']];
        }

        return $team->users()->sync($pivotData);
    }

    /**
     * @param User $user
     * @param int $data
     */
    public function assignToUser(User $user, array $data = [])
    {
        if (empty($data)) {
            return false;
        }

        $pivotData = [];
        foreach ($data as $item) {
            $pivotData[$item['team_id']] = ['level' => $item['level']];
        }

        return $user->teams()->sync($pivotData);
    }
}
