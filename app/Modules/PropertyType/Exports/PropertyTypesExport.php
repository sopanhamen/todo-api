<?php

namespace App\Modules\PropertyType\Exports;

use App\Modules\PropertyType\PropertyType;
use Maatwebsite\Excel\Concerns\FromCollection;

class PropertyTypesExport implements FromCollection
{
    public function collection()
    {
        return PropertyType::all();
    }
}
