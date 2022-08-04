<?php

namespace App\Modules\District;

use App\Libraries\Crud\CrudService;
use App\Libraries\Cache\Cacher;
use App\Libraries\Cache\WithCache;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;

class DistrictService extends CrudService implements WithCache
{
    use Cacher;

    private $cacheName = 'districts';

    protected array $allowedRelations = ['province', 'province.country', 'creator', 'updater'];

    protected array $filterable = [
        'name_en' => 'name_en',
        'country_id' => 'province.country_id',
        'province_id' => 'province_id',
    ];

    public function __construct(DistrictRepository $repo)
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
            return $this->getMany(['fields' => $fields, 'limit' => 5000]);
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