<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CategorytypesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('categorytypes')->delete();
        
        \DB::table('categorytypes')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'Profissão',
                'created_at' => '2021-03-16 22:11:44',
                'updated_at' => '2021-03-16 22:11:44',
            ),
        ));
        
        
    }
}