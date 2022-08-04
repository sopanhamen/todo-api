<?php

namespace App\Modules\Company;

use App\Libraries\Cache\Cacher;
use App\Libraries\Crud\CrudService;
use App\Modules\FileUpload\FileUploadService;
use App\Libraries\Cache\WithCache;
use App\Modules\Company\Resources\CompanyResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Cache;

class CompanyService extends CrudService implements WithCache
{
    use Cacher;

    private $cacheName = 'companies';

    protected array $allowedRelations = ['branches', 'branches.teams'];

    protected FileUploadService $fileUploadService;
    protected CompanyRepository $companyRepo;

    public function __construct(CompanyRepository $repo, FileUploadService $fileUploadService, CompanyRepository $companyRepo)
    {
        parent::__construct($repo);
        $this->companyRepo = $companyRepo;
        $this->fileUploadService = $fileUploadService;
    }


    /**
     * Create one record
     *
     * @param array $payload
     * @return null|Company
     */
    public function createOne(array $payload): ?Company
    {
        if (!empty($payload['logo'])) {
            $path = $this->fileUploadService->moveToRealPath($payload['logo']['path']);
            $payload['logo'] = $path;
            $payload['logo_disk'] = config('filesystems.default');
        }

        return $this->repo->createOne($payload);
    }

    /**
     * Update one record
     *
     * @param string|int $id
     * @param array $payload
     * @param string $field (default = "id")
     * @return null|Company
     */
    public function updateOne(string|int $id, array $payload): ?Company
    {
        $company = $this->repo->getOneOrFail($id);
        $payload['logo_disk'] = config('filesystems.default');

        if (empty($payload['logo']['path'])) {
            if ($company->logo) {
                $this->fileUploadService->delete($company->logo);
            }

            $payload['logo'] = '';
            return $this->repo->updateOne($company, $payload);
        }

        if ($company->logo && $company->logo !== $payload['logo']['path']) {
            $this->fileUploadService->delete($company->logo);

            $path = $this->fileUploadService->moveToRealPath($payload['logo']['path']);
            $payload['logo'] = $path;

            return $this->repo->updateOne($company, $payload);
        }

        $payload['logo'] = $payload['logo']['path'];

        return $this->repo->updateOne($company, $payload);
    }

    /**
     * Get all client types and cache
     *
     * @return AnonymousResourceCollection
     */
    public function getFromCache($fields = ['*']): AnonymousResourceCollection
    {
        return Cache::rememberForever($this->cacheName, function () use ($fields) {
            $companies = $this->getMany([
                'fields' => $fields, 'limit' => 150,
            ]);

            return CompanyResource::collection($companies);
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
     * Get information of company
     *
     * @return null|Company
     */
    public function getCompanyInfo(): Company
    {
        return $this->companyRepo->getOneCompany();
    }
}