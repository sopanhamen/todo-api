<?php

namespace App\Modules\Facility;

use App\Helpers\StringHelper;
use App\Libraries\Cache\Cacher;
use App\Libraries\Cache\WithCache;
use App\Libraries\Crud\CrudService;
use App\Modules\Facility\FacilityRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class FacilityService extends CrudService implements WithCache
{
    use Cacher;

    protected array $allowedRelations = ['propertyTypes'];

    private $cacheName = 'facilities';

    public function __construct(FacilityRepository $repo)
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
            return $this->getMany(['fields' => $fields, 'limit' => 200]);
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

    /**
     * Generate new facility code
     *
     * @return string Facility Code
     */
    public function generateCode(): string
    {
        // get last code
        $latestCode = 0;
        $lastFacility = $this->repo->getLatestAndLock('code', ['code']);
        if ($lastFacility) {
            $latestCode = StringHelper::findNumber($lastFacility->code);
        }

        // last code + 1 and add 0 before code
        return Str::padLeft($latestCode + 1, 4, '0');
    }

    /**
     * Create one record
     *
     * @param array $payload
     * @return null|Facility
     */
    public function createOne(array $payload): ?Facility
    {
        return DB::transaction(function () use ($payload) {
            $payload['code'] = $this->generateCode();
            return $this->repo->createOne($payload);
        });
    }
}
