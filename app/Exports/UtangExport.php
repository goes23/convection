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
    //     $query = DB::table('hutang');
    //     $query->select(
    //         'name',
    //         'jumlah_hutang',
    //         DB::Raw('DATE(tanggal_hutang)')
    //     );

    //     if ($this->param['kategori'] == 'date')
    //         $query->whereBetween('tanggal_hutang', [$this->param['start'], $this->param['end']]);

    //     $result = $query->get();
    //     return $result;
    // }
    // public function headings(): array
    // {
    //     return [
    //         "NAMA", "JUMLAH HUTANG", "TANGGAL HUTANG"
    //     ];
    // }

    // public function collection()
    // {
        $query = DB::table('hutang');
        $query->leftJoin('log_hutang', 'log_hutang.hutang_id', '=', 'hutang.id');
        $query->select(
            'hutang.jumlah_hutang',
            'hutang.sisa',
            DB::Raw('DATE(hutang.tanggal_hutang)'),
            'log_hutang.jumlah_pembayaran',
            DB::Raw('DATE(log_hutang.tanggal_pembayaran)'),
            'log_hutang.keterangan'
        );
        // $query->selectRaw('SELECT name FROM product WHERE product.id = produksi.product_id');

        if ($this->param['kategori'] == 'date')
            $query->whereBetween('hutang.tanggal_hutang', [$this->param['start'], $this->param['end']]);

        if ($this->param['kategori'] == 'date')
            $query->whereBetween('log_hutang.tanggal_pembayaran', [$this->param['start'], $this->param['end']]);

        $result = $query->get();
        return $result;
    }
    public function headings(): array
    {
        return [
             "TOTAL HUTANG", "SISA HUTANG", "TANGGAL TRANSAKSI", "JUMLAH PEMBAYARAN", "TANGGAL PEMBAYARAN", "KETERANGAN"
        ];
    }
}
