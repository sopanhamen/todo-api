<?php

namespace App\Modules\Developer\Exports;

use App\Modules\Developer\Developer;
use Maatwebsite\Excel\Concerns\FromCollection;

class DevelopersExport implements FromCollection
{
    public function collection()
    {
        return Developer::all();
    }
}
