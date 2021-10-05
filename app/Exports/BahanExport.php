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

    protected $param;

    function __construct($param)
    {
        $this->param = $param;
    }


    public function collection()
    {
        $query = DB::table('bahan');
        $query->select(
            'kode',
            'name',
            'harga',
            DB::Raw('DATE(buy_at)'),
            'satuan',
            'panjang',
            'sisa_bahan',
            'harga_satuan',
            DB::Raw('IFNULL( `discount` , 0 ) as discount')
        );

        if ($this->param['kategori'] == 'date')
            $query->whereBetween('buy_at', [$this->param['start'], $this->param['end']]);

        if ($this->param['kategori'] == 'sisa')
            $query->where('sisa_bahan', '>', 0);

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
