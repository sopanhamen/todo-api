<?php

namespace App\Modules\DevelopmentType\Exports;

use App\Modules\DevelopmentType\DevelopmentType;
use Maatwebsite\Excel\Concerns\FromCollection;

class DevelopmentTypesExport implements FromCollection
{
    public function collection()
    {
        return DevelopmentType::all();
    }
}
