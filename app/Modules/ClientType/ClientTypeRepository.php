<?php

namespace App\Modules\ClientType;

use App\Libraries\Crud\CrudRepository;
use App\Modules\ClientType\ClientType;

class ClientTypeRepository extends CrudRepository
{
    public function __construct(ClientType $clientType)
    {
        parent::__construct($clientType);
    }
}
