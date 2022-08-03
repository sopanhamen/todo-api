<?php

namespace App\Libraries\Cache;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Date;

trait Cacheable
{
    /**
     * Cacheable boot logic.
     *
     * @return void
     */
    public static function bootCacheable()
    {
        static::created(function ($model) {
            $cacheName = $model->getCacheName();
            Cache::forget($cacheName);
            $model->setCacheDate();
        });

        static::updated(function ($model) {
            $cacheName = $model->getCacheName();
            Cache::forget($cacheName);
            $model->setCacheDate();
        });

        static::deleted(function ($model) {
            $cacheName = $model->getCacheName();
            Cache::forget($cacheName);
            $model->setCacheDate();
        });
    }

    public function getCacheName(): string
    {
        return $this->cacheName ?? $this->getTable();
    }

    public function setCacheDate(): void
    {
        $cacheNameDate =  $this->getCacheName() . '_date';
        Cache::rememberForever($cacheNameDate, function () {
            return now();
        });
    }

    public function getCacheDate(): Date|string
    {
        $cacheNameDate =  $this->getCacheName() . '_date';
        return Cache::get($cacheNameDate);
    }
}
