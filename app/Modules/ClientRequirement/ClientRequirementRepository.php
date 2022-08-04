<?php

namespace App\Modules\ClientRequirement;

use App\Libraries\Crud\CrudRepository;
use App\Modules\ClientRequirement\ClientRequirement;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class ClientRequirementRepository extends CrudRepository
{
    public function __construct(ClientRequirement $clientRequirement)
    {
        parent::__construct($clientRequirement);
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
            ->paginate($options['limit'] ?? $this->limit);
    }
}