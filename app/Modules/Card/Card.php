<?php

namespace App\Modules\Card;
use App\Libraries\Cache\Cacheable;
use App\Libraries\Crud\CrudModel;
use OwenIt\Auditing\Contracts\Auditable;
use App\Libraries\Database\Traits\HasAuthors;
use App\Libraries\Database\Traits\UuidPrimaryKey;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Card extends CrudModel implements Auditable
{
    use Cacheable,
        HasFactory,
        SoftDeletes,
        HasAuthors,
        UuidPrimaryKey,
        \OwenIt\Auditing\Auditable;

        protected $table = 'cards';

        protected $fillable = ['card_number', 'balance', 'exp_data', 'published'];
        

}
