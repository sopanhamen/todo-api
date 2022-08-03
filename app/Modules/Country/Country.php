<?php

namespace App\Modules\Country;

use App\Libraries\Cache\Cacheable;
use App\Libraries\Crud\CrudModel;
use OwenIt\Auditing\Contracts\Auditable;
use App\Libraries\Database\Traits\HasAuthors;
use App\Libraries\Database\Traits\UuidPrimaryKey;
use App\Modules\Province\Province;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Country extends CrudModel implements Auditable
{
    use Cacheable,
        HasFactory,
        SoftDeletes,
        HasAuthors,
        UuidPrimaryKey,
        \OwenIt\Auditing\Auditable;

    protected $table = "countries";

    protected $fillable = ['name', 'iso_code', 'code', 'published'];

    public function provinces()
    {
        return $this->hasMany(Province::class)->select(['id', 'name_en', 'country_id']);
    }
}
