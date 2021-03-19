<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UserlevelsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('userlevels')->delete();
        
        \DB::table('userlevels')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'Scrum Master',
                'created_at' => '2021-03-15 19:39:31',
                'updated_at' => '2021-03-15 19:39:31',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'Product Owner',
                'created_at' => '2021-03-15 19:39:31',
                'updated_at' => '2021-03-15 19:39:31',
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'Software Developer',
                'created_at' => '2021-03-15 19:39:31',
                'updated_at' => '2021-03-15 19:39:31',
            ),
        ));
        
        
    }
}