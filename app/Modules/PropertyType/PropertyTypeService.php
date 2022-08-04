<?php

namespace App\Modules\PropertyType;

use App\Libraries\Crud\CrudService;
use App\Libraries\Cache\Cacher;
use App\Libraries\Cache\WithCache;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Collection as SupportCollection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class PropertyTypeService  extends CrudService implements WithCache
{
    use Cacher;

    protected array $allowedRelations = ['developmentType', 'facilities', 'properties', 'creator', 'updater'];

    private $cacheName = 'property_types';
    private PropertyTypeRepository $propertyTypeRepository;

    public function __construct(PropertyTypeRepository $repo)
    {
        parent::__construct($repo);
        $this->propertyTypeRepository = $repo;
    }

    /**
     * Create one record
     *
     * @param array $payload
     * @return null|PropertyType
     */
    public function createOne(array $payload): ?PropertyType
    {
        return DB::transaction(function () use ($payload) {
            $data = collect($payload)->except(['facilities'])->all();
            $propertyType = $this->repo->createOne($data);
            if (!empty($payload['facilities'])) {
                $propertyType->facilities()->sync($payload['facilities']);
            }

            $propertyType->setRelation('facilities', $propertyType->facilities()->get());

            return $propertyType;
        });
    }

    /**
     * Update one record
     *
     * @param string|int $id
     * @param array $payload
     * @param string $field (default = "id")
     * @return null|PropertyType
     */
    public function updateOne(string|int $id, array $payload, string $idColumn = null): ?PropertyType
    {
        return DB::transaction(function () use ($id, $idColumn, $payload) {
            $record = $this->repo->getOneOrFail($id, $idColumn);
            $propertyType = $this->repo->updateOne($record, $payload);
            $propertyType->facilities()->sync($payload['facilities']);

            $propertyType->setRelation('facilities', $propertyType->facilities()->get());

            return $propertyType;
        });
    }

    /**
     * Delete one Property Type
     *
     * @param string|int $id
     */
    public function propertyTypeHaveProperties(string|int $id)
    {
        return $this->propertyTypeRepository->getPropertyTypeHaveProperties($id);
    }

    /**
     * Get all client types and cache
     *
     * @return Collection
     */
    public function getFromCache($fields = ['*']): Collection
    {
        return Cache::rememberForever($this->cacheName, function () use ($fields) {
            return $this->getMany([
                'relations' => 'facilities',
                'limit' => 200,
                'fields' => $fields,
                'sorts' => 'name:asc'
            ]);
        });
    }

    /**
     * Clear client types Cache
     *
     * @return void
     */
    public function clearCache(): void
    {
        Cache::forget($this->cacheName);
    }
}