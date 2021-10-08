<?php

namespace App\Exports;

use App\Upah;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\Exportable;
use Illuminate\Support\Facades\DB;

class UpahExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $query = DB::table('upah');
        $query->select(
            "id",
            DB::Raw('(SELECT name FROM product WHERE product.id = produksi.product_id) as product'),
            DB::Raw('(SELECT name FROM bahan WHERE bahan.id = produksi.bahan_id) bahan'),
            "panjang_bahan",
            "bidang",
            "total_stock",
            "pemakaian",
            "harga_potong_satuan",
            "harga_jait_satuan",
            "harga_finishing_satuan",
            "harga_aksesoris",
            "harga_modal_bahan_satuan",
            "created_at"
        );
        // $query->selectRaw('SELECT name FROM product WHERE product.id = produksi.product_id');

        if ($this->param['kategori'] == 'date')
            $query->whereBetween('created_at', [$this->param['start'], $this->param['end']]);

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
