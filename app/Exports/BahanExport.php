<?php

namespace App\Exports;

use App\Bahan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\Exportable;
use Illuminate\Support\Facades\DB;


class BahanExport implements FromCollection, WithHeadings
{
    use Exportable;
    /**
     * @return \Illuminate\Support\Collection
     */

    protected $id;

    function __construct($id) {
           $this->id = $id;
    }


    public function collection()
    {
        dd($this->id);
        $query = DB::table('bahan');
        $query->select(
            'kode',
            'name',
            'harga',
            'buy_at',
            'satuan',
            'panjang',
            'sisa_bahan',
            'harga_satuan',
            DB::Raw('IFNULL( `discount` , 0 ) as discount')
        );


        //if ($published == true)
        //$query->whereBetween('buy_at', [$start, $end]);

        // if (isset($year))
        //     $query->where('year', '>', $year);

        $result = $query->get();
        return $result;
    }

    public function headings(): array
    {
        return [
            "KODE", "NAMA", "HARGA", "TANGGAL PEMBELIAN", "SATUAN", "PANJANG", "SISA BAHAN", "HARGA SATUAN", "DISKON"
        ];
    }
}
