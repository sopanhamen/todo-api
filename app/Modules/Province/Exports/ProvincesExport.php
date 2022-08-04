<?php

namespace App\Modules\Province\Exports;

use App\Modules\Province\Province;
use Maatwebsite\Excel\Concerns\FromCollection;

class ProvincesExport implements FromCollection
{
    public function collection()
    {
        return Province::all();
    }
}
