<?php

namespace App\Modules\Facility\Exports;

use App\Modules\Facility\Facility;
use Maatwebsite\Excel\Concerns\FromCollection;

class FacilitiesExport implements FromCollection
{
    public function collection()
    {
        return Facility::all();
    }
}
