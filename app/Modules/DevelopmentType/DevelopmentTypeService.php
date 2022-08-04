<?php

namespace App\Modules\DevelopmentType;

use App\Libraries\Crud\CrudService;
use App\Libraries\Cache\Cacher;
use App\Libraries\Cache\WithCache;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;

class DevelopmentTypeService extends CrudService implements WithCache
{
    use Cacher;

    protected array $allowedRelations = ['creator', 'updater'];
    private $cacheName = 'development_types';
    private DevelopmentTypeRepository $developmentTypeRepository;

    public function __construct(DevelopmentTypeRepository $repo)
    {
        parent::__construct($repo);
        $this->developmentTypeRepository = $repo;
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
