<?php

namespace App\Modules\Bank;

use App\Libraries\Crud\CrudRepository;
use App\Modules\Bank\Bank;

class BankRepository extends CrudRepository
{
    public function __construct(Bank $bank)
    {
        parent::__construct($bank);
    }
}
