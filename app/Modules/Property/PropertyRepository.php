<?php

namespace App\Modules\Property;

use App\Libraries\Crud\CrudRepository;
use App\Modules\Property\Property;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class PropertyRepository extends CrudRepository
{
    public function __construct(Property $property)
    {
        parent::__construct($property);
    }

    public function getLatestCode(string $prefix = 'CODE', bool $isActive)
    {
        $property = DB::table($this->model->getTable())
            ->sharedLock()
            ->select(DB::raw("CAST(REPLACE(code, '" . $prefix . "', '') as integer) as num_code"))
            ->where('code', 'like', $prefix . '%')
            ->where('published', $isActive)
            ->latest('num_code')
            ->first();

        return $property ? $property->num_code : 0;
    }

    /**
     * @param string $toAgentId
     * @param array $propertyIds string[propertyId]
     * @param array $data [property data]
     */
    public function updatePropertiesAssignee(string $fromAgentId, string $toAgentId, array $propertyIds, array $data = [])
    {
        return $this->model
            ->where('assignee_id', $fromAgentId)
            ->whereIn('id', $propertyIds)
            ->update([...$data, 'assignee_id' => $toAgentId]);
    }

    /**
     * @param array $options
     * @param array|null $beforeQuery
     * @return Collection|LengthAwarePaginator
     */
    public function paginateMaps(
        array $options = [],
        ?callable $beforeQuery = null
    ): Collection|LengthAwarePaginator {
        $query = $this->buildQuery($options);

        if ($beforeQuery) {
            $query = $beforeQuery($query);
        }

        return $query->whereNotNull('lat_lng')->paginate($options['limit'] ?? $this->limit);
    }
}
