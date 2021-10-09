<?php

namespace App\Exports;

use App\Pengeluaran;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\Exportable;
use Illuminate\Support\Facades\DB;

class PengeluaranExport implements FromCollection, WithHeadings
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
        $query = DB::table('pengeluaran');
        $query->select(
            'name',
            'jumlah_pengeluaran',
            DB::Raw('DATE(tanggal_pengeluaran)')
        );

        if ($this->param['kategori'] == 'date')
            $query->whereBetween('tanggal_pengeluaran', [$this->param['start'], $this->param['end']]);

        $result = $query->get();
        return $result;
    }
    public function headings(): array
    {
        return [
            "NAMA", "JUMLAH PENGELUARAN", "TANGGAL PENGELUARAN"
        ];
    }
}
