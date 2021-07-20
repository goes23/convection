<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Role;

class BaseSeeder extends Seeder
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
            'email' => 'taufik@gmail.com',
            'password' => bcrypt('123masuk'),
            'role'  => 1,
        ]);

        Role::create([
            'name' => 'Super Admin',
            'description' => 'Full access',
            'status' => 1,
            'role'  => 1,
            'created_by' => 1
        ]);
    }
}
