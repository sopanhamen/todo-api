<?php

namespace App\Modules\PropertyHistory;

use App\Libraries\Crud\CrudService;

class PropertyHistoryService extends CrudService
{
    protected array $allowedRelations = [];

    public function __construct(PropertyHistoryRepository $repo)
    {
        parent::__construct($repo);
    }
}
