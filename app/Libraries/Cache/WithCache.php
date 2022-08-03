<?php

namespace App\Libraries\Cache;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Collection as SupportCollection;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

interface WithCache
{
    public function getFromCache(): Collection|SupportCollection|AnonymousResourceCollection;
    public function clearCache(): void;
}
