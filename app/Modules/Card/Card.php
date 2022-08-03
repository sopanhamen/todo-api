<?php

namespace App\Modules\Card;

use App\Libraries\Crud\CrudModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Libraries\Database\Traits\HasAuthors;
use OwenIt\Auditing\Contracts\Auditable;

class Card extends CrudModel implements Auditable
{
    use HasFactory, SoftDeletes, HasAuthors, \OwenIt\Auditing\Auditable;
}
