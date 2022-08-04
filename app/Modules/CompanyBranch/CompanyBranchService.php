<?php

namespace App\Modules\CompanyBranch;

use App\Libraries\Cache\WithCache;
use App\Libraries\Crud\CrudService;
use App\Modules\Company\Company;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;

class CompanyBranchService extends CrudService implements WithCache
{
    private $cacheName = 'company_branches';

    protected array $allowedRelations = ['teams'];

    public function __construct(CompanyBranchRepository $repo)
    {
        parent::__construct($repo);
    }

    /**
     * @param Company $company
     */
    public function createDefaultBranch(Company $company)
    {
        return $this->repo->createOne([
            'company_id' => $company->id,
            'name' => 'Head Office',
            'primary_phone' => $company->primary_phone,
            'secondary_phone' => $company->secondary_phone,
            'email' => $company->email,
            'website' => $company->email,
            'street' => $company->street,
            'lat_lng' => $company->lat_lng,
            'province_id' => $company->province_id,
            'district_id' => $company->district_id,
            'commune_id' => $company->commune_id,
            'published' => $company->published,
            'defaulted' => true,
        ]);
    }

    /**
     * Delete one Company Branch
     *
     * @param string|int $id
     * @param string $idColumn
     * @return null|CompanyBranch
     */
    public function deleteOne(string|int $id, string $idColumn = null): ?CompanyBranch
    {
        $branch = $this->getOneOrFail($id, $idColumn);
        if ($branch && $branch->defaulted === true) {
            abort(403, 'Not allowed to delete default branch');
        }

        return $this->repo->deleteOne($branch);
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
