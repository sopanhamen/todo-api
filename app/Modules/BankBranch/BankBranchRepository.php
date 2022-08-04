<?php

namespace App\Modules\BankBranch;

use App\Libraries\Crud\CrudRepository;
use App\Modules\BankBranch\BankBranch;

class BankBranchRepository extends CrudRepository
{
    public function __construct(BankBranch $bankBranch)
    {
        parent::__construct($bankBranch);
    }
}
