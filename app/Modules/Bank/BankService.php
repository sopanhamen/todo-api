<?php

namespace App\Modules\Bank;

use App\Libraries\Crud\CrudService;

class BankService extends CrudService
{
    const uploadPath = 'images/banks';

    protected array $allowedRelations = ['creator', 'updater'];

    public function __construct(BankRepository $repo)
    {
        parent::__construct($repo);
    }
}
