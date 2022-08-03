<?php

namespace App\Modules\Country;

use App\Libraries\Crud\CrudService;
use App\Libraries\Cache\Cacher;
use App\Libraries\Cache\WithCache;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;

class CountryService extends CrudService implements WithCache
{
    use Cacher;

    protected array $allowedRelations = ['provinces', 'creator', 'updater'];

    private $cacheName = 'countries';

    public function __construct(CountryRepository $repo)
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
            return $this->getMany(['fields' => $fields, 'limit' => 150]);
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