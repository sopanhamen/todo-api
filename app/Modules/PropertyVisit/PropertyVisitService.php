<?php

namespace App\Modules\PropertyVisit;

use App\Libraries\Crud\CrudService;

class PropertyVisitService extends CrudService
{
    protected array $allowedRelations = ['requirement', 'property', 'assignee', 'owner'];

    public function __construct(PropertyVisitRepository $repo)
    {
        parent::__construct($repo);
    }
}
