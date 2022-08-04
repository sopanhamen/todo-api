<?php

namespace App\Modules\CompanyBranch;

use App\Libraries\Cache\Cacheable;
use App\Libraries\Crud\CrudModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Libraries\Database\Traits\HasAuthors;
use App\Libraries\Database\Traits\UuidPrimaryKey;
use App\Modules\Company\Company;
use App\Modules\UserTeam\UserTeam;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use OwenIt\Auditing\Contracts\Auditable;

class CompanyBranch extends CrudModel implements Auditable
{
    use HasFactory,
        Cacheable,
        SoftDeletes,
        HasAuthors,
        UuidPrimaryKey,
        \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'company_id',
        'name',
        'primary_phone',
        'secondary_phone',
        'email',
        'website',
        'country_id',
        'province_id',
        'district_id',
        'commune_id',
        'lat_lng',
        'street',
        'published',
        'defaulted'
    ];

    protected $cast = [
        'published' => 'boolean',
        'defaulted' => 'boolean',
    ];

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function teams(): HasMany
    {
        return $this->hasMany(UserTeam::class, 'company_branch_id');
    }
}
