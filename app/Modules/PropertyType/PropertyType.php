<?php

namespace App\Modules\PropertyType;

use App\Libraries\Cache\Cacheable;
use App\Libraries\Crud\CrudModel;
use App\Libraries\Database\Traits\HasAuthors;
use App\Modules\DevelopmentType\DevelopmentType;
use App\Modules\Facility\Facility;
use App\Modules\Property\Property;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class PropertyType extends CrudModel implements Auditable
{
    use Cacheable, HasFactory, SoftDeletes, HasAuthors, \OwenIt\Auditing\Auditable;

    protected $table = "property_types";

    protected $hidden = ['facilities.pivot'];

    protected $casts = ['property_type_group' => 'integer', 'published' => 'boolean',];

    protected $fillable = ['name', 'published', 'development_type_id', 'property_type_group'];

    public function developmentType(): BelongsTo
    {
        return $this->belongsTo(DevelopmentType::class);
    }

    public function facilities(): BelongsToMany
    {
        return $this->belongsToMany(Facility::class, 'property_types_facilities')
            ->select(['id', 'code', 'name'])
            ->orderBy('name', 'asc');
    }

    public function properties(): HasMany
    {
        return $this->hasMany(Property::class);
    }
}