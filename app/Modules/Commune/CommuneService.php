<?php

namespace App\Modules\Commune;

use Illuminate\Support\Str;
use App\Helpers\StringHelper;
use App\Libraries\Cache\Cacher;
use App\Libraries\Cache\WithCache;
use Illuminate\Support\Facades\DB;
use App\Libraries\Crud\CrudService;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Collection;

class CommuneService extends CrudService implements WithCache
{
    use Cacher;

    private string $cacheName = 'communes';

    protected array $allowedRelations = [
        'id', 'district', 'district.province',
        'district.province.country', 'creator', 'updater'
    ];

    protected array $filterable = [
        'name_en' => 'name_en',
        'district_id' => 'district_id',
        'province_id' => 'district.province_id',
        'country_id' => 'district.province.country_id'
    ];

    public function __construct(CommuneRepository $repo)
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