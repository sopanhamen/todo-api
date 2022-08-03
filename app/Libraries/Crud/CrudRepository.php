<?php

namespace App\Libraries\Crud;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class CrudRepository
{
    protected Model $model;

    protected int $limit = 50;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * Return primary key column fo the model
     * @return string
     */
    public function getKeyName(): string
    {
        return $this->model->getKeyName();
    }

    /**
     * Check if field is relation field
     *
     * @param string $field
     * @return bool
     */
    private function isRelationField(string $field): bool
    {
        return strpos($field, '.') !== false;
    }

    /**
     * @param Model|Builder|QueryBuilder $query
     * @param string $field
     * @param mixed $value
     * @param string $operator
     * @return Model|Builder|QueryBuilder
     */
    private function buildFiltersQuery(
        Model|Builder|QueryBuilder $query,
        string $field,
        mixed $value,
        string $operator = '='
    ): Model|Builder|QueryBuilder {
        if ($value && (is_array($value) || $operator === 'between')) {
            if ($operator !== 'between') {
                return $query->whereIn($field, $value);
            }

            $filteredValue = array_filter($value);

            if (count($filteredValue) === 0) {
                return $query;
            }

            if (count($filteredValue) === 1) {
                if (!empty($value[0])) {
                    return $query->where($field, '>=', $value[0]);
                }

                return $query->where($field, '<=', $value[1]);
            }

            return $query->whereBetween($field, $filteredValue);
        }

        if ($value !== null) {
            if ($operator === 'contain') {
                return $query->where($field, 'ilike', '%' . $value . '%');
            }

            if ($operator === 'date') {
                return $query->whereDate($field, $value);
            }

            if ($operator === 'exists') {
                if ($value === 'true' || $value === true) {
                    return $query->whereNotNull($field);
                }

                return $query->whereNull($field);
            }

            return $query->where($field, $operator, $value);
        }

        return $query;
    }

    public function whereRelation($query, $field, $value, $operator)
    {
        if ($this->isRelationField($field)) {
            $data = explode('.', $field);

            if (count($data) === 2) {
                $relation = $data[0];
                $relationField = $data[1];

                return $query->whereHas($relation, function ($q) use ($relationField, $value, $operator) {
                    $q = $this->buildFiltersQuery($q, $relationField, $value, $operator);
                });
            }


            $relation1 = $data[0];
            $relation2 = $data[1];
            $relationField = $data[2];

            return $query->whereHas($relation1, function ($q) use ($relation2, $relationField, $value, $operator) {
                $q = $q->whereHas($relation2, function ($q) use ($relationField, $value, $operator) {
                    $q = $this->buildFiltersQuery($q, $relationField, $value, $operator);
                });
            });
        }

        return $query;
    }

    /**
     * @param array $filters
     * @return Model|Builder|QueryBuilder
     */
    public function getQueryWithFilters(array $filters): Model|Builder|QueryBuilder
    {
        if (!$filters) {
            return $this->model;
        }

        return $this->model->where(function ($q) use ($filters) {
            foreach ($filters as $filter) {
                ['field' => $field, 'value' => $value, 'operator' => $operator] = $filter;

                if ($this->isRelationField($field)) {
                    $q = $this->whereRelation($q, $field, $value, $operator);
                } else {
                    $q = $this->buildFiltersQuery($q, $field, $value, $operator);
                }
            }
        });
    }

    /**
     * @param array $fields
     * @return array
     */
    public function getSelectFields(array $fields = []): array
    {
        if (empty($fields)) {
            return ['*'];
        }

        return array_map(
            fn ($field) => preg_replace('/[^a-zA-Z0-9_*]/', '', $field),
            $fields
        );
    }

    /**
     * @param array $options
     * @param callable|null $beforeQuery
     * @return Model|Builder|QueryBuilder
     */
    public function buildQuery(?array $options = null): Model|Builder|QueryBuilder
    {
        if (empty($options)) {
            return $this->model;
        }

        $sorts = $options['sorts'] ?? [];
        $filters = $options['filters'] ?? [];
        $fields = $options['fields'] ?? [];
        $relations = $options['relations'] ?? [];
        $counts = $options['counts'] ?? [];
        $limit = $options['limit'] ?? $this->limit;

        return $this->getQueryWithFilters($filters)
            ->when(count($sorts) > 0, function ($q) use ($sorts) {
                foreach ($sorts as $field => $sort) {
                    $q->orderBy($field, $sort);
                }
            })
            ->select($this->getSelectFields($fields))
            ->limit($limit)
            ->withCount($counts)
            ->with($relations);
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

        return $query->paginate($options['limit'] ?? $this->limit);
    }

    /**
     * @param array $options
     * @param callable|null $beforeQuery
     * @return Collection|LengthAwarePaginator
     */
    public function paginateWithTrashed(
        array $options = [],
        ?callable $beforeQuery = null
    ): Collection|LengthAwarePaginator {
        $query = $this->buildQuery($options);

        if ($beforeQuery) {
            $query = $beforeQuery($query);
        }

        return $query->withTrashed()->paginate($options['limit'] ?? $this->limit);
    }

    /**
     * @param array $options
     * @param callable|null $beforeQuery
     * @return Collection|LengthAwarePaginator
     */
    public function paginateFromTrash(
        array $options = [],
        ?callable $beforeQuery = null
    ): Collection|LengthAwarePaginator {
        $query = $this->buildQuery($options);

        if ($beforeQuery) {
            $query = $beforeQuery($query);
        }

        return $query->onlyTrashed()->paginate($options['limit'] ?? $this->limit);
    }

    /**
     * @param array $options
     * @param callable|null $beforeQuery
     * @return Collection
     */
    public function getMany(array $options = [], ?callable $beforeQuery = null): Collection
    {
        $query = $this->buildQuery($options);

        if ($beforeQuery) {
            $query = $beforeQuery($query);
        }

        return $query->limit($options['limit'] ?? $this->limit)->get();
    }

    /**
     * @param array $options
     * @param callable|null $beforeQuery
     * @return Collection
     */
    public function getManyWithTrashed(array $options = [], ?callable $beforeQuery = null): Collection
    {
        $query = $this->buildQuery($options);

        if ($beforeQuery) {
            $query = $beforeQuery($query);
        }

        return $query->limit($options['limit'] ?? $this->limit)->withTrashed()->get();
    }

    /**
     * @param array $options
     * @param callable|null $beforeQuery
     * @return Collection
     */
    public function getManyFromTrash(array $options = [],  ?callable $beforeQuery = null): Collection
    {
        $query = $this->buildQuery($options);

        if ($beforeQuery) {
            $query = $beforeQuery($query);
        }


        return $query->limit($options['limit'] ?? $this->limit)->onlyTrashed()->get();
    }

    /**
     * @param mixed|null $value
     * @param string $field
     * @param array|null $options
     * @return null|Model
     */
    public function getOne(mixed $id, ?array $options = null, ?callable $beforeQuery = null): ?Model
    {
        $query = $this->buildQuery($options);
        if ($beforeQuery) {
            $query = $beforeQuery($query);
        }

        return $query->find($id);
    }

    /**
     * @param mixed|null $value
     * @return null|object
     */
    public function getLatest(): ?object
    {
        return DB::table($this->model->getTable())->latest()->first();
    }

    /**
     * @return null|object
     */
    public function getLatestAndLock($column = 'created_at', $fields = ['*']): ?object
    {
        return DB::table($this->model->getTable())
            ->sharedLock()
            ->select($fields)
            ->latest($column)
            ->first();
    }

    /**
     * @param mixed $id
     * @param string $field
     * @param array $options
     * @return null|Model
     */
    public function getOneOrFail(mixed $id, ?array $options = null, ?callable $beforeQuery = null): ?Model
    {
        $query = $this->buildQuery($options);
        if ($beforeQuery) {
            $query = $beforeQuery($query);
        }

        return $query->findOrFail($id);
    }

    /**
     * @param mixed $id
     * @param string $field
     * @param array $options
     * @return null|Model
     */
    public function getOneWithTrashed(mixed $id, ?array $options = null, ?callable $beforeQuery = null): ?Model
    {
        $query = $this->buildQuery($options);
        if ($beforeQuery) {
            $query = $beforeQuery($query);
        }

        return $query->withTrashed()->find($id);
    }

    /**
     * @param mixed $id
     * @param string $field
     * @param array $options
     * @return null|Model
     */
    public function getOneFromTrash(mixed $id, ?array $options = null, ?callable $beforeQuery = null): ?Model
    {
        $query = $this->buildQuery($options);
        if ($beforeQuery) {
            $query = $beforeQuery($query);
        }

        return $query->onlyTrashed()->find($id);
    }

    /**
     * @param array $payload
     * @return null|Model
     */
    public function createOne(array $payload = []): ?Model
    {
        $model = $this->model;
        $model->fill($payload);
        $model->save();

        return $model;
    }

    /**
     * @param Model $model
     * @param array $payload
     * @return null|Model
     */
    public function updateOne(Model $model, array $payload): ?Model
    {
        if (!$model) {
            return null;
        }

        $model->fill($payload);
        $model->save();

        return $model;
    }

    /**
     * @param Model $model
     * @param array|Collection $payload
     * @return null|Model
     */
    public function updateOrCreate(Model $model, array $payload): ?Model
    {
        if (!$model->{$this->getKeyName()}) {
            $model = $this->model;
        }

        $model->fill($payload);
        $model->save();

        return $model;
    }

    /**
     * @param mixed $id
     * @param array $payload
     * @param string $keyColumn
     *
     * @return null|Model|boolean
     */
    public function updateOneById(mixed $id,  array $payload): ?Model
    {
        $model = $this->model->select($this->getKeyName())->find($id);

        if (!$model) {
            return null;
        }

        $model->fill($payload);
        $model->save();

        return $model;
    }

    /**
     * @param Model $model
     * @return null|Model
     */
    public function deleteOne(Model $model): ?Model
    {
        if (!$model) {
            return null;
        }

        $model->delete();

        return $model;
    }

    /**
     * @param string|int $keyValue
     * @return null|Model
     */
    public function deleteOneById(string|int $id): ?Model
    {
        $model = $this->model->select($this->getKeyName())->find($id);

        if (!$model) {
            return null;
        }

        $model->delete();

        return $model;
    }

    /**
     * @param Model $model
     * @return null|Model
     */
    public function restoreOne(Model $model): ?Model
    {
        if (!$model) {
            return null;
        }

        $model->restore();

        return $model;
    }

    /**
     * @param mixed $keyValue
     * @return null|Model
     */
    public function restoreOneById(mixed $id): ?Model
    {
        $model = $this->model->select($this->getKeyName())->withTrashed()->find($id);

        if (!$model) {
            return null;
        }

        $model->restore();

        return $model;
    }

    /**
     * @param Model $model
     * @return null|Model
     */
    public function forceDeleteOne(Model $model): ?Model
    {
        if (!$model) {
            return null;
        }

        return $this->model->forceDelete($model);
    }

    /**
     * @param mixed $id
     * @return null|Model
     */
    public function forceDeleteOneById(mixed $id): ?Model
    {
        $model = $this->model->select($this->getKeyName())->find($id);

        if (!$model) {
            return null;
        }

        return $this->model->forceDelete($model);
    }

    /**
     * @param array|callable $where
     * @param array $fields default ['*']
     * @return null|Model
     */
    public function getOneWhere(array|callable $where, array $fields = ['*']): ?Model
    {
        if (is_array($where)) {
            $query = $this->model;
            foreach ($where as $field => $value) {
                $query = $query->where($field, $value);
            }

            return $query->select($fields)->first();
        }

        return $this->model->where($where)->select($fields)->first();
    }

    /**
     * @param array|callable $where
     * @return int|null
     */
    public function countWhere(array|callable $where, array $filters = []): ?int
    {
        $query = $this->buildQuery($filters, [], [], []);

        if (is_array($where)) {
            foreach ($where as $field => $value) {
                $query->where($field, $value);
            }
        }

        return $query->where($where)->count();
    }
}
