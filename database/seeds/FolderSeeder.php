<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FolderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['area_id' => '1', 'nivel' => '1', 'name' => 'Almacen', 'id_padre' => '0', 'created_at' => date('Y-m-d H:m:s'), 'updated_at' => date('Y-m-d H:m:s')],
            ['area_id' => '2', 'nivel' => '1', 'name' => 'Calidad', 'id_padre' => '0', 'created_at' => date('Y-m-d H:m:s'), 'updated_at' => date('Y-m-d H:m:s')],
            ['area_id' => '3', 'nivel' => '1', 'name' => 'Control Operacional', 'id_padre' => '0', 'created_at' => date('Y-m-d H:m:s'), 'updated_at' => date('Y-m-d H:m:s')],
            ['area_id' => '4', 'nivel' => '1', 'name' => 'Compras', 'id_padre' => '0', 'created_at' => date('Y-m-d H:m:s'), 'updated_at' => date('Y-m-d H:m:s')],
            ['area_id' => '5', 'nivel' => '1', 'name' => 'Direccion', 'id_padre' => '0', 'created_at' => date('Y-m-d H:m:s'), 'updated_at' => date('Y-m-d H:m:s')],
            ['area_id' => '6', 'nivel' => '1', 'name' => 'Finanzas', 'id_padre' => '0', 'created_at' => date('Y-m-d H:m:s'), 'updated_at' => date('Y-m-d H:m:s')],
            ['area_id' => '7', 'nivel' => '1', 'name' => 'Ingenieria', 'id_padre' => '0', 'created_at' => date('Y-m-d H:m:s'), 'updated_at' => date('Y-m-d H:m:s')],
            ['area_id' => '8', 'nivel' => '1', 'name' => 'Manufactura', 'id_padre' => '0', 'created_at' => date('Y-m-d H:m:s'), 'updated_at' => date('Y-m-d H:m:s')],
            ['area_id' => '9', 'nivel' => '1', 'name' => 'Recursos Humanos', 'id_padre' => '0', 'created_at' => date('Y-m-d H:m:s'), 'updated_at' => date('Y-m-d H:m:s')],
            ['area_id' => '10', 'nivel' => '1', 'name' => 'Ventas', 'id_padre' => '0', 'created_at' => date('Y-m-d H:m:s'), 'updated_at' => date('Y-m-d H:m:s')]
        ];
        
        DB::table('folder_areas')->insert($data);
    }
}
