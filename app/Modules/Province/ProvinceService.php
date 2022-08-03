<?php

namespace App\Modules\Province;

use App\Libraries\Crud\CrudService;

class ProvinceService extends CrudService
{
    use Cacher;
    protected array $allowedRelations = [];

    public function __construct(ProvinceRepository $repo)
    {
        parent::__construct($repo);
    }
    public function getFromCache($fields = ['*']): Collection
    {
        return Cache::rememberForever($this->cacheName, function () use ($fields) {
            return $this->getMany(['fields' => $fields, 'limit' => 150]);
        });
    }
}
