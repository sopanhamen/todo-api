<?php

namespace App\Modules\ClientType\Exports;

use App\Modules\ClientType\ClientType;
use Maatwebsite\Excel\Concerns\FromCollection;

class ClientTypesExport implements FromCollection
{
    public function collection()
    {
        return ClientType::all();
    }
}
