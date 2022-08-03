<?php

namespace App\Libraries\Database\Traits;

use App\Modules\User\User;
use Illuminate\Support\Facades\Auth;

trait HasAuthors
{
    protected string $createdBy = 'created_by';
    protected string $updatedBy = 'updated_by';

    /**
     * HasAuthor boot logic.
     *
     * @return void
     */
    public static function bootHasAuthors()
    {
        static::creating(function ($model) {
            $userId = Auth::check() ? Auth::id() : null;
            $model->created_by = $userId;
            $model->updated_by = NULL;
        });

        static::updating(function ($model) {
            $userId = Auth::check() ? Auth::id() : null;
            $model->updated_by = $userId;
        });
    }

    /**
     *  Initial has authors trait for an instance.
     *
     * @return void
     */
    public static function initialHasAuthors()
    {
        static::retrieved(function ($model) {
            $model->fillable = array_merge($model->fillable, [$this->createdBy, $this->updatedBy]);
        });
    }

    /**
     * Get the user that created the model.
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get the user that updated the model.
     */
    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
