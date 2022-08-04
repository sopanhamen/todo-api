<?php

namespace App\Modules\Developer;

use App\Libraries\Cache\Cacher;
use App\Libraries\Cache\WithCache;
use App\Libraries\Crud\CrudService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;

class DeveloperService extends CrudService implements WithCache
{
    use Cacher;

    private $cacheName = 'developers';

    protected array $allowedRelations = ['developmentType', 'creator', 'updater'];

    public function __construct(DeveloperRepository $repo)
    {
        parent::__construct($repo);
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
                'fields' => $fields,
                'limit' => 200,
                'sorts' => 'name:asc',
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
