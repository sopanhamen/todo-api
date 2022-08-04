<?php

namespace App\Modules\Project;

use App\Libraries\Crud\CrudService;

class ProjectService extends CrudService
{
    protected array $allowedRelations = [
        'developer', 'developmentType', 'province',
        'district', 'commune', 'creator', 'updater'
    ];

    public function __construct(ProjectRepository $repo)
    {
        parent::__construct($repo);
    }
}
