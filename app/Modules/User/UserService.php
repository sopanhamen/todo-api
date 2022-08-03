<?php

namespace App\Modules\User;

use App\Libraries\Crud\CrudService;

use App\Libraries\Cache\Cacher;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Collection;
class UserService extends CrudService
{
    use Cacher; 

    protected array $allowedRelations = ['cards','creator', 'updater'];

    private $cacheName = 'users';

    public function __construct(UserRepository $repo)
    {
        parent::__construct($repo);
    }

    public function getFromCache($fields = ['*']): Collection 
    {
        return Cache::rememberForever($this->cacheName, function () use ($fields) {
            return $this->getMany(['fields' => $fields, 'limit' => 150]);
        });
    }

    public function clearCache(): void
    {
        Cache::forget($this->cacheName);
    }
}
