<?php

namespace App\Modules\Commune;

use App\Libraries\Cache\Cacheable;
use App\Libraries\Crud\CrudModel;
use OwenIt\Auditing\Contracts\Auditable;
use App\Libraries\Database\Traits\HasAuthors;
use App\Libraries\Database\Traits\UuidPrimaryKey;
use App\Modules\District\District;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Commune extends CrudModel implements Auditable
{
    use UuidPrimaryKey, Cacheable, HasFactory, SoftDeletes, HasAuthors, \OwenIt\Auditing\Auditable;

    protected $table = "communes";

    protected $fillable = ['code', 'name_en', 'name_km', 'district_id', 'published'];

    public function district()
    {
        return $this->belongsTo(District::class)
            ->select(['id', 'name_en', 'province_id']);
    }
}