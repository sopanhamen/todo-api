<?php

namespace App\Modules\Property;

use App\Libraries\Database\Traits\UuidPrimaryKey;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PropertyDocument extends Model
{
    use UuidPrimaryKey;

    public $fillable = ['file_path', 'file_type', 'file_name', 'storage_disk'];

    public function property(): BelongsTo
    {
        return $this->belongsTo(Property::class, 'property_id');
    }
}
