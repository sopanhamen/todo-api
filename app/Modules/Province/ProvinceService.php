<?php

namespace App\Modules\Province;

use App\Libraries\Crud\CrudService;
use App\Libraries\Cache\Cacher;
use App\Libraries\Cache\WithCache;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;

class ProvinceService extends CrudService implements WithCache
{
    use Cacher;

    private string $cacheName = 'provinces';

    protected array $allowedRelations = ['country', 'creator', 'updater'];

    public function __construct(ProvinceRepository $repo)
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
            return $this->getMany(['fields' => $fields, 'limit' => 500]);
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
