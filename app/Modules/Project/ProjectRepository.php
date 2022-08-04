<?php

namespace App\Modules\Project;

use App\Libraries\Crud\CrudRepository;
use App\Modules\Project\Project;

class ProjectRepository extends CrudRepository
{
    public function __construct(Project $project)
    {
        parent::__construct($project);
    }
}
