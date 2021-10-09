<?php

namespace App\Exports;

use App\Product;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\Exportable;
use Illuminate\Support\Facades\DB;

class ProductExport implements FromCollection, WithHeadings
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
        $query = DB::table('product');
        $query->leftJoin('variants', 'variants.product_id', '=', 'product.id');
        $query->select(
            'product.name',
            'product.kode',
            'variants.size',
            'variants.jumlah_stock_product',
            DB::Raw('DATE(variants.created_at)')
        );

        if ($this->param['kategori'] == 'date')
            $query->whereBetween('variants.created_at', [$this->param['start'], $this->param['end']]);

        $result = $query->get();
        return $result;
    }

    public function headings(): array
    {
        return [
            "PRODUCT NAME", "KODE", "SIZE", "STOCK PRODUCT", "TANGGAL PEMBUATAN"
        ];
    }
}
