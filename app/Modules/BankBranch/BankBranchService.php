<?php

namespace App\Modules\BankBranch;

use App\Libraries\Crud\CrudService;

class BankBranchService extends CrudService
{
    const uploadPath = 'images/bank-branches';

    protected array $allowedRelations = ['bank', 'creator', 'updater'];

    public function __construct(BankBranchRepository $repo)
    {
        parent::__construct($repo);
    }
}
