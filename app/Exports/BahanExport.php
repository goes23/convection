<?php

namespace App\Exports;

use App\Bahan;
use Maatwebsite\Excel\Concerns\FromCollection;

class BahanExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Bahan::all();
    }



}
