<?php

namespace App\Exports;

use App\Penjualan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\Exportable;
use Illuminate\Support\Facades\DB;

class PenjualanExport implements FromCollection, WithHeadings
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
        $query = DB::table('penjualan');
        $query->leftJoin('item_penjualan', 'item_penjualan.penjualan_id', '=', 'penjualan.id');
        $query->select(
            'penjualan.purchase_code',
            'penjualan.kode_pesanan',
            DB::Raw('(SELECT name FROM product WHERE product.id = item_penjualan.product_id) product'),
            'item_penjualan.sell_price',
            'item_penjualan.qty',
            'item_penjualan.size',
            'item_penjualan.total',
            'penjualan.customer_name',
            'penjualan.customer_phone',
            'penjualan.customer_address',
            'penjualan.channel_id',
            DB::Raw('DATE(penjualan.purchase_date)'),
            'penjualan.total_purchase',
            'penjualan.shipping_price'

        );

        if ($this->param['kategori'] == 'date')
            $query->whereBetween('penjualan.purchase_date', [$this->param['start'], $this->param['end']]);

        $result = $query->get();
        return $result;
    }
    public function headings(): array
    {

        return [
            "PUCHASE CODE",
            "KODE PESANAN",
            "NAMA PRODUCT",
            "HARGA JUAL",
            "QUANTITY",
            "UKURAN",
            "TOTAL",
            "NAMA CUSTOMER",
            "PHONE CUSTOMER",
            "ALAMAT CUSTOMER",
            "CHANNEL",
            "TANGGAL PEMBELIAN",
            "TOTAL PEMBELIAN",
            "HARGA PENGIRIMAN",
        ];
    }
}
