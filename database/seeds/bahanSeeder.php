<?php

use Illuminate\Database\Seeder;
use App\Bahan;

class bahanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Bahan::class, 3)->make();
    }
}
