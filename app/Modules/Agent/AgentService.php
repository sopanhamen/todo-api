<?php

namespace App\Modules\Agent;

use Illuminate\Support\Collection;
use App\Libraries\Crud\CrudService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class AgentService extends CrudService
{
    protected array $allowedRelations = ['profile', 'profile.contact', 'teams', 'teams.branch', 'properties', 'publishedProperties'];

    protected array $filterable = [
        'name' => 'name',
        'phone' => 'profile.contact.primary_phone',
        'email' => 'email',
        'show_on_website' => 'show_on_website',
        'is_active' => 'is_active',
        'company_branch_id' => 'profile.company_branch_id',
        'team_id' => 'teams.team_id'
    ];

    public function __construct(AgentRepository $repo)
    {
        parent::__construct($repo);
    }

    public function onBeforeQuery(): ?callable
    {
        return function (Builder $query) {
            return $query
                ->whereDoesntHave('roles', function (Builder $query) {
                    return $query->where('roles.id', config('user.default_user.default_user.super_admin.id'));
                })
                ->where('show_on_website', true);
        };
    }
}
