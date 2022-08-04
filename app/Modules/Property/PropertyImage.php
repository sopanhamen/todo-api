<?php

namespace App\Modules\Property;

use App\Libraries\Database\Traits\UuidPrimaryKey;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PropertyImage extends Model
{
    use UuidPrimaryKey;

    public $fillable = ['path_large', 'path_thumbnail', 'storage_disk'];

    public function property(): BelongsTo
    {
        return $this->belongsTo(Property::class, 'property_id');
    }
}
