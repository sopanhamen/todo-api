<?php

namespace App\Modules\ClientRequirement;

use App\Libraries\Crud\CrudModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Libraries\Database\Traits\HasAuthors;
use App\Libraries\Database\Traits\UuidPrimaryKey;
use App\Modules\Client\Client;
use App\Modules\Client\Enum\NegotiationStatus;
use App\Modules\ClientPayment\ClientPayment;
use App\Modules\Commune\Commune;
use App\Modules\Country\Country;
use App\Modules\Developer\Developer;
use App\Modules\District\District;
use App\Modules\Project\Project;
use App\Modules\Property\Property;
use App\Modules\PropertyNegotiation\PropertyNegotiation;
use App\Modules\PropertyType\PropertyType;
use App\Modules\PropertyVisit\PropertyVisit;
use App\Modules\Province\Province;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use OwenIt\Auditing\Contracts\Auditable;

class ClientRequirement extends CrudModel implements Auditable
{
    use UuidPrimaryKey,
        HasFactory,
        SoftDeletes,
        HasAuthors,
        \OwenIt\Auditing\Auditable;

    public $primaryKey = 'id';

    // Persist relations on every api response
    // @todo: Test performance and if it's really slow, use query builder to reduce number of queries
    public $with = [
        'preferredPropertyTypes',
        'preferredCountries',
        'preferredProvinces',
        'preferredDistricts',
        'preferredCommunes',
        'preferredProjects',
        'preferredDevelopers',
    ];

    protected $casts = [
        'budget_min' => 'integer',
        'budget_max' => 'integer',
        'result' => 'integer',
        'service' => 'integer',
        'priority' => 'integer',
        'price_type' => 'integer'
    ];

    protected $fillable = [
        'id',
        'client_id',
        'property_id',
        'code',
        'budget_min',
        'budget_max',
        'service',
        'price_type',
        'priority',
        'result',
        'purpose',
        'specific_place',
        'country_id',
        'province_id',
        'district_id',
        'commune_id',
        'note',
    ];

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class, 'client_id');
    }

    public function property(): BelongsTo
    {
        return $this->belongsTo(Property::class);
    }

    public function visits(): HasMany
    {
        return $this->hasMany(PropertyVisit::class, 'client_requirement_id');
    }

    public function payments(): HasMany
    {
        return $this->hasMany(ClientPayment::class, 'client_requirement_id');
    }

    public function negotiations(): HasMany
    {
        return $this->hasMany(PropertyNegotiation::class, 'client_requirement_id');
    }

    public function agreedNegotiation(): HasOne
    {
        return $this->hasOne(PropertyNegotiation::class, 'client_requirement_id')
            ->where('status', NegotiationStatus::AGREED->value)
            ->whereNull('deleted_at');
    }

    public function preferredPropertyTypes(): BelongsToMany
    {
        return $this->belongsToMany(
            PropertyType::class,
            'client_preferred_property_types',
            'client_requirement_id',
            'property_type_id'
        );
    }

    public function preferredDevelopers(): BelongsToMany
    {
        return $this->belongsToMany(
            Developer::class,
            'client_preferred_developers',
            'client_requirement_id',
            'developer_id'
        );
    }

    public function preferredProjects(): BelongsToMany
    {
        return $this->belongsToMany(
            Project::class,
            'client_preferred_projects',
            'client_requirement_id',
            'project_id'
        );
    }

    public function preferredCountries(): BelongsToMany
    {
        return $this->belongsToMany(
            Country::class,
            'client_preferred_countries',
            'client_requirement_id',
            'country_id'
        );
    }

    public function preferredProvinces(): BelongsToMany
    {
        return $this->belongsToMany(
            Province::class,
            'client_preferred_provinces',
            'client_requirement_id',
            'province_id'
        );
    }

    public function preferredDistricts(): BelongsToMany
    {
        return $this->belongsToMany(
            District::class,
            'client_preferred_districts',
            'client_requirement_id',
            'district_id'
        );
    }

    public function preferredCommunes(): BelongsToMany
    {
        return $this->belongsToMany(
            Commune::class,
            'client_preferred_communes',
            'client_requirement_id',
            'commune_id'
        );
    }
}