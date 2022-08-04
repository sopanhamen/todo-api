<?php

namespace App\Modules\ClientPayment;

use App\Libraries\Crud\CrudRepository;
use App\Modules\ClientPayment\ClientPayment;

class ClientPaymentRepository extends CrudRepository
{
    public function __construct(ClientPayment $clientPayment)
    {
        parent::__construct($clientPayment);
    }
}
