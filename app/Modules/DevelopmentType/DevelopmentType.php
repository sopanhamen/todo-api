<?php

namespace App\Modules\DevelopmentType;

use App\Libraries\Crud\CrudModel;
use App\Libraries\Database\Traits\HasAuthors;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class DevelopmentType extends CrudModel implements Auditable
{
    use HasFactory, SoftDeletes, HasAuthors, \OwenIt\Auditing\Auditable;

    protected $table = "development_types";

    protected $fillable = [
        'name',
        'published',
    ];
}
