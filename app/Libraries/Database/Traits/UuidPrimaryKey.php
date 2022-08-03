<?php

namespace App\Libraries\Database\Traits;

use Illuminate\Support\Str;

trait UuidPrimaryKey
{
    /**
     * HasAuthor boot logic.
     *
     * @return void
     */
    public static function bootUuidPrimaryKey()
    {
        static::creating(function ($model) {
            if (empty($model->{$model->getKeyName()})) {
                $model->{$model->getKeyName()} = Str::uuid()->toString();
            }
        });
    }

    /**
     *  Initial has UuidPrimaryKey trait for an instance.
     *
     * @return void
     */
    public static function initialUuidPrimaryKey()
    {
        static::retrieved(function ($model) {
            $model->fillable = array_merge($model->fillable, [$model->getKeyName()]);
        });
    }

    /**
     * Get the value indicating whether the IDs are incrementing.
     *
     * @return bool
     */
    public function getIncrementing()
    {
        return false;
    }

    /**
     * Get the auto-incrementing key type.
     *
     * @return string
     */
    public function getKeyType()
    {
        return 'string';
    }
}
