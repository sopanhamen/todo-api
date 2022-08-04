<?php

namespace App\Modules\Developer;

use App\Libraries\Cache\Cacheable;
use App\Libraries\Crud\CrudModel;
use OwenIt\Auditing\Contracts\Auditable;
use App\Libraries\Database\Traits\HasAuthors;
use App\Modules\DevelopmentType\DevelopmentType;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Developer extends CrudModel implements Auditable
{
    use Cacheable, HasFactory, SoftDeletes, HasAuthors, \OwenIt\Auditing\Auditable;

    protected $table = "developers";

    protected $fillable = [
        "name",
        "development_type_id",
        "primary_phone",
        "secondary_phone",
        "email",
        "website",
        "facebook",
        "logo",
        "published",
        "address",
    ];

    public function developmentType()
    {
        return $this->belongsTo(DevelopmentType::class);
    }
}
