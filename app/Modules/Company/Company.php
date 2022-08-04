<?php

namespace App\Modules\Company;

use App\Libraries\Cache\Cacheable;
use App\Libraries\Crud\CrudModel;
use OwenIt\Auditing\Contracts\Auditable;
use App\Libraries\Database\Traits\HasAuthors;
use App\Libraries\Database\Traits\UuidPrimaryKey;
use App\Modules\CompanyBranch\CompanyBranch;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Company extends CrudModel implements Auditable
{
    use HasFactory,
        Cacheable,
        SoftDeletes,
        HasAuthors,
        UuidPrimaryKey,
        \OwenIt\Auditing\Auditable;

    protected $table = "companies";

    protected $fillable = [
        'name', 'year_established', 'summary', 'description', 'vision', 'mission',
        'key_value', 'address', 'primary_phone', 'secondary_phone',
        'email', 'logo', 'logo_disk', 'lat_lng', 'published',
        'country_id', 'province_id', 'district_id', 'commune_id',
        'property_code_prefix', 'property_code_digit',
        'property_code_prefix_unlisting', 'property_code_digit_unlisting', 'facebook', 'telegram', 'youtube', 'linked_in', 'instagram'
    ];

    public function branches(): HasMany
    {
        return $this->hasMany(CompanyBranch::class);
    }
}
