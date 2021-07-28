<?php

use Illuminate\Database\Seeder;
use App\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'name' => 'Taufik Agus S',
            'email' => 'super@convection.com',
            'role'  => 1,
            'password' => bcrypt('123masuk'),
        ]);

        $user = User::create([
            'name' => 'testing',
            'email' => 'admin@convection.com',
            'role' => 2,
            'password' => bcrypt('123masuk'),
        ]);
    }
}
