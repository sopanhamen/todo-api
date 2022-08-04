<?php

namespace App\Modules\CompanyBranch;

use App\Libraries\Crud\CrudRepository;
use App\Modules\CompanyBranch\CompanyBranch;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class CompanyBranchRepository extends CrudRepository
{
    public function __construct(CompanyBranch $companyBranch)
    {
        parent::__construct($companyBranch);
    }

    /**
     * @param array $options
     * @param array|null $beforeQuery
     * @return Collection|LengthAwarePaginator
     */
    public function paginate(
        array $options = [],
        ?callable $beforeQuery = null
    ): Collection|LengthAwarePaginator {
        $query = $this->buildQuery($options);

        if ($beforeQuery) {
            $query = $beforeQuery($query);
        }

        return $query
            ->with(['teams' => fn ($q) => $q->withCount('users')])
            ->paginate($options['limit'] ?? $this->limit);
    }
}
