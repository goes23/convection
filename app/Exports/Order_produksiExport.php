<?php

namespace App\Exports;

use App\OrderProduksi;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\Exportable;
use Illuminate\Support\Facades\DB;

class Order_produksiExport implements FromCollection, WithHeadings
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

        $query = DB::table('order_produksi');
        $query->leftJoin('log_order_produksi', 'log_order_produksi.order_produksi_id', '=', 'order_produksi.id');
        $query->select(
            'order_produksi.name',
            'order_produksi.harga_modal_satuan',
            'order_produksi.harga_jual_satuan',
            'order_produksi.qty',
            'order_produksi.total_pembayaran',
            'order_produksi.sisa_pembayaran',
            DB::Raw('DATE(order_produksi.created_at)'),
            'log_order_produksi.jumlah_pembayaran',
            DB::Raw('DATE(log_order_produksi.tanggal_pembayaran)'),
            'log_order_produksi.keterangan'

        );

        if ($this->param['kategori'] == 'date')
            $query->whereBetween('order_produksi.created_at', [$this->param['start'], $this->param['end']]);

        if ($this->param['kategori'] == 'date_pembayaran')
            $query->whereBetween('log_order_produksi.tanggal_pembayaran', [$this->param['start'], $this->param['end']]);

        $result = $query->get();

        return $result;
    }
    public function headings(): array
    {
        return [
            "NAMA",
            "HARGA MODAL SATUAN",
            "HARGA JUAL SATUAN",
            "QUANTITY",
            "TOTAL PEMBAYARAN",
            "SISA PEMBAYARAN",
            "TANGGAL ORDER",
            "JUMLAH PEMBAYARAN",
            "TANGGAL PEMBAYARAN",
            "KETERANGAN"
        ];
    }
}
