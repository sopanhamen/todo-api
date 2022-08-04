<?php

namespace App\Modules\Bank;

use App\Libraries\Crud\CrudModel;
use App\Libraries\Database\Traits\HasAuthors;
use App\Libraries\Database\Traits\UuidPrimaryKey;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Bank extends CrudModel implements Auditable
{
    use UuidPrimaryKey, HasFactory, SoftDeletes, HasAuthors, \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'bank_name',
        'primary_phone',
        'secondary_phone',
        'email',
        'website',
        'logo',
        'published',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'published' => 'boolean'
    ];
}
