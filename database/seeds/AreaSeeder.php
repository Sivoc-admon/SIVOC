<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AreaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('areas')->insert([
            'name' => 'Almacen',
            /*'created_at' => date('Y-m-d H:m:s'),
            'updated_at' => date('Y-m-d H:m:s')*/
        ]);
        
        
    }
}
