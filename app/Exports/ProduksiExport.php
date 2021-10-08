<?php

namespace App\Exports;

use App\Produksi;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\Exportable;
use Illuminate\Support\Facades\DB;

class ProduksiExport implements FromCollection, WithHeadings
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
        $query = DB::table('produksi');
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

        // CREATE TABLE `produksi` (
        //     `id` bigint unsigned NOT NULL AUTO_INCREMENT,
        //     `kode_produksi` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
        //     `product_id` int NOT NULL,
        //     `bahan_id` int NOT NULL,
        //     `panjang_bahan` int NOT NULL,
        //     `bidang` int NOT NULL,
        //     `total_stock` int NOT NULL,
        //     `pemakaian` int NOT NULL,
        //     `harga_potong_satuan` int NOT NULL,
        //     `harga_jait_satuan` int NOT NULL,
        //     `harga_finishing_satuan` int NOT NULL,
        //     `harga_aksesoris` int NOT NULL,
        //     `harga_modal_bahan_satuan` int NOT NULL,
        //     `created_by` int NOT NULL,
        //     `created_at` timestamp NULL DEFAULT NULL,
        //     `updated_at` timestamp NULL DEFAULT NULL,
        //     `deleted_at` timestamp NULL DEFAULT NULL,
        return [
            "KODE PRODUKSI",
            "NAMA PRODUCT",
            "BAHAN",
            "PANJANG BAHAN",
            "BIDANG",
            "TOTAL STOCK",
            "PEMAKAIAN",
            "HARGA POTONG SATUAN",
            "HARGA JAHIT SATUAN",
            "HARGA FINISHING SATUAN",
            "HARGA AKSESORIS",
            "HARGA MODAL BAHAN SATUAN",
            "TANGGAL PEMBUATAN"

        ];
    }
}
