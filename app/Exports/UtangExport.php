<?php

namespace App\Exports;

use App\Hutang;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\Exportable;
use Illuminate\Support\Facades\DB;

class UtangExport implements FromCollection, WithHeadings
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
        $query = DB::table('hutang');
        $query->select(
            'name',
            'jumlah_hutang',
            DB::Raw('DATE(tanggal_hutang)')
        );

        if ($this->param['kategori'] == 'date')
            $query->whereBetween('tanggal_hutang', [$this->param['start'], $this->param['end']]);

        $result = $query->get();
        return $result;
    }
    public function headings(): array
    {
        return [
            "NAMA", "JUMLAH HUTANG", "TANGGAL HUTANG"
        ];
    }
}
