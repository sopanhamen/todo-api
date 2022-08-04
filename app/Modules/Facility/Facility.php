<?php

namespace App\Modules\Facility;

use App\Libraries\Cache\Cacheable;
use App\Libraries\Crud\CrudModel;
use App\Modules\Property\Property;
use App\Modules\PropertyType\PropertyType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Facility extends CrudModel implements Auditable
{
    use Cacheable, HasFactory, SoftDeletes, \OwenIt\Auditing\Auditable;

    protected $fillable = ['code', 'name', 'i18n', 'published'];

    public function property(): BelongsToMany
    {
        return $this->belongsToMany(Property::class, 'property_facilities', 'property_id', 'facility_id');
    }

    public function propertyTypes(): BelongsToMany
    {
        return $this->belongsToMany(PropertyType::class, 'property_types_facilities');
    }
}
