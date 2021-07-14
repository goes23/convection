<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Bahan;
use Faker\Generator as Faker;

$factory->define(Bahan::class, function (Faker $faker) {
    return [
        'kode' => $faker->name,
        'name' => $faker->name,
        'buy_at' => now(),
        'harga' => $faker->randomNumber(2), // password
        'panjang' => $faker->randomNumber(2),
        'satuan' => $faker->randomNumber(2),
        'sisa' => $faker->randomNumber(2)
    ];
});
