<?php

namespace App\Modules\Province;

use App\Libraries\Crud\CrudModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Libraries\Database\Traits\HasAuthors;
use OwenIt\Auditing\Contracts\Auditable;

class Province extends CrudModel implements Auditable
{
    use HasFactory, SoftDeletes, HasAuthors, \OwenIt\Auditing\Auditable;


    protected $table = "provinces";

    protected $fillable = ['code', 'name_en', 'name_km', 'country_id', 'published'];

    public function country()
    {
        return $this->belongsTo(Country::class)->select(['id', 'name', 'iso_code']);
    }
}
