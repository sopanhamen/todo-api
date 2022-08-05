<?php

namespace App\Modules\Card;

use App\Libraries\Crud\CrudService;
// use App\Libraries\Cache\Cacher;
// use App\Libraries\Cache\WithCache;
use Illuminate\Database\Eloquent\Collection;
// use Illuminate\Support\Facades\Cache;

class CardService extends CrudService
{
    // use Cacher; 
    protected array $allowedRelations = [];

    protected $cacheName = 'cards';

    public function __construct(CardRepository $repo)
    {
        parent::__construct($repo);
    }

    // public function getFromCache ($fields = ['*']): Collection {
    //     return Cache::rememberForever($this->cacheName, function () use ($fields)  {
    //         return $this->getMany(['fields' => $fields, 'limit' => 10]);
    //     });
    // }

    // public function clearCache(): void
    // {
    //     Cache::forget($this->cacheName);
    // }
}
