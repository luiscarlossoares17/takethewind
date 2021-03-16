<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('categories')->delete();
        
        \DB::table('categories')->insert(array (
            0 => 
            array (
                'id' => 1,
                'categorytype_id' => 1,
                'name' => 'Software Developer',
                'created_at' => '2021-03-16 22:12:20',
                'updated_at' => '2021-03-16 22:12:20',
            ),
            1 => 
            array (
                'id' => 2,
                'categorytype_id' => 1,
                'name' => 'Designer',
                'created_at' => '2021-03-16 22:12:40',
                'updated_at' => '2021-03-16 22:12:40',
            ),
            2 => 
            array (
                'id' => 3,
                'categorytype_id' => 1,
                'name' => 'Tester',
                'created_at' => '2021-03-16 22:13:05',
                'updated_at' => '2021-03-16 22:13:05',
            ),
        ));
        
        
    }
}