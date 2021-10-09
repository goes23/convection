<?php

namespace App\Exports;

use App\Upah;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\Exportable;
use Illuminate\Support\Facades\DB;

class UpahExport implements FromCollection, WithHeadings
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
        $query = DB::table('upah');
        $query->leftJoin('pembayaran', 'pembayaran.upah_id', '=', 'upah.id');
        $query->select(
            'upah.produksi_id',
            'upah.total_upah',
            'upah.sisa_upah',
            DB::Raw('DATE(upah.date_transaksi)'),
            'pembayaran.jumlah_pembayaran',
            DB::Raw('DATE(pembayaran.tanggal_pembayaran)'),
            'pembayaran.keterangan'
        );
        // $query->selectRaw('SELECT name FROM product WHERE product.id = produksi.product_id');

        if ($this->param['kategori'] == 'date')
            $query->whereBetween('upah.date_transaksi', [$this->param['start'], $this->param['end']]);

        if ($this->param['kategori'] == 'date')
            $query->whereBetween('pembayaran.tanggal_pembayaran', [$this->param['start'], $this->param['end']]);

        $result = $query->get();
        return $result;
    }
    public function headings(): array
    {
        return [
            "PRODUKSI", "TOTAL UPAH", "SISA UPAH", "TANGGAL TRANSAKSI", "JUMLAH PEMBAYARAN", "TANGGAL PEMBAYARAN", "KETERANGAN"
        ];
    }
}
