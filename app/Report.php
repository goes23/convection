<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Report extends Model
{
    public function get_report($pram)
    {
        $table = strtolower($pram['report']);
        $condition = '';
        if ($table == 'bahan') {
            $condition = 'buy_at';
        } elseif ($table == 'product') {
            $condition = 'created_at';
        } elseif ($table == 'produksi') {
            $condition = 'created_at';
        }

        $start = $pram['start'];
        $end   = $pram['end'];
        return  DB::select("SELECT *
                            FROM $table
                            WHERE $condition BETWEEN '$start' AND '$end'
                            ");
    }
}
