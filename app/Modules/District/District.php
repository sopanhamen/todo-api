<?php

namespace App\Modules\District;

use App\Libraries\Cache\Cacheable;
use App\Libraries\Crud\CrudModel;
use App\Modules\Province\Province;
use OwenIt\Auditing\Contracts\Auditable;
use App\Libraries\Database\Traits\HasAuthors;
use App\Libraries\Database\Traits\UuidPrimaryKey;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class District extends CrudModel implements Auditable
{
    use Cacheable,
        HasFactory,
        SoftDeletes,
        HasAuthors,
        UuidPrimaryKey,
        \OwenIt\Auditing\Auditable;

    protected $table = "districts";

    protected $fillable = ['code', 'name_en', 'name_km', 'province_id', 'published'];

    public function province()
    {
        return $this->belongsTo(Province::class)->select(['id', 'name_en', 'country_id']);
    }
}
