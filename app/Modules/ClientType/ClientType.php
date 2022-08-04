<?php

namespace App\Modules\ClientType;

use App\Libraries\Cache\Cacheable;
use App\Libraries\Crud\CrudModel;
use App\Libraries\Database\Traits\HasAuthors;
use App\Libraries\Database\Traits\UuidPrimaryKey;
use App\Modules\Client\Client;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use OwenIt\Auditing\Contracts\Auditable;

class ClientType extends CrudModel implements Auditable
{
    use Cacheable,
        HasFactory,
        SoftDeletes,
        HasAuthors,
        UuidPrimaryKey,
        \OwenIt\Auditing\Auditable;

    protected $table = "client_types";

    protected $fillable = ['name', 'published'];

    public function clients(): HasMany
    {
        return $this->hasMany(Client::class, 'client_type_id');
    }
}
