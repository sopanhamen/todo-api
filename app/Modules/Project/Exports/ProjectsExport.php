<?php

namespace App\Modules\Project\Exports;

use App\Modules\Project\Project;
use Maatwebsite\Excel\Concerns\FromCollection;

class ProjectsExport implements FromCollection
{
    public function collection()
    {
        return Project::all();
    }
}
