<?php

namespace App\Modules\Province;

use App\Libraries\Cache\Cacheable;
use App\Libraries\Crud\CrudModel;
use OwenIt\Auditing\Contracts\Auditable;
use App\Libraries\Database\Traits\HasAuthors;
use App\Libraries\Database\Traits\UuidPrimaryKey;
use App\Modules\Country\Country;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Province extends CrudModel implements Auditable
{
    use Cacheable,
        HasFactory,
        SoftDeletes,
        HasAuthors,
        UuidPrimaryKey,
        \OwenIt\Auditing\Auditable;

    protected $table = "provinces";

    protected $fillable = ['code', 'name_en', 'name_km', 'country_id', 'published'];

    public function country()
    {
        return $this->belongsTo(Country::class)->select(['id', 'name', 'iso_code']);
    }
}
