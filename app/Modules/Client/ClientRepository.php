<?php

namespace App\Modules\Client;

use App\Libraries\Crud\CrudRepository;
use App\Modules\Client\Client;

class ClientRepository extends CrudRepository
{
    public function __construct(Client $client)
    {
        parent::__construct($client);
    }
}
