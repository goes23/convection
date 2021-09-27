<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Role;
use App\Module;
use App\Access;
use Illuminate\Support\Facades\DB;

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
            'created_by' => 1
        ]);


        Module::create([
            'parent_id' => 0,
            'name' => 'Setting',
            'controller' => '',
            'order_no' => 1,
            'status' => 1
        ]);


        Module::create([
            'parent_id' => 0,
            'name' => 'Master',
            'controller' => '',
            'order_no' => 2,
            'status' => 1
        ]);

        Module::create([
            'parent_id' => 1,
            'name' => 'Module',
            'controller' => 'module',
            'order_no' => 1,
            'status' => 1
        ]);


        Module::create([
            'parent_id' => 1,
            'name' => 'Role',
            'controller' => 'role',
            'order_no' => 2,
            'status' => 1
        ]);

        Module::create([
            'parent_id' => 1,
            'name' => 'User',
            'controller' => 'user',
            'order_no' => 3,
            'status' => 1
        ]);

        Module::create([
            'parent_id' => 2,
            'name' => 'Bahan',
            'controller' => 'bahan',
            'order_no' => 1,
            'status' => 1
        ]);

        Module::create([
            'parent_id' => 2,
            'name' => 'Product',
            'controller' => 'product',
            'order_no' => 2,
            'status' => 1
        ]);

        Module::create([
            'parent_id' => 2,
            'name' => 'Produksi',
            'controller' => 'produksi',
            'order_no' => 3,
            'status' => 1
        ]);


        Module::create([
            'parent_id' => 2,
            'name' => 'Channel',
            'controller' => 'channel',
            'order_no' => 4,
            'status' => 1
        ]);

        Module::create([
            'parent_id' => 2,
            'name' => 'Order Header',
            'controller' => 'penjualan',
            'order_no' => 5,
            'status' => 1
        ]);

        foreach (Module::where('parent_id', '!=', 0)->get() as $val) {

            $permission = [
                0 => "view",
                1 => "add",
                2 => "edit",
                3 => "delete"
            ];

            for ($i = 0; $i < count($permission); $i++) {
                Access::UpdateOrCreate(["module_id" => $val->id, "permission" => $permission[$i]], [
                    'permission' => $permission[$i],
                    'status' => 1,
                    'created_by' => 1
                ]);
            }
        }
    }
}
