<?php

use Illuminate\Database\Seeder;

class seedLanguages extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        DB::table('languages')->insert([
            ['id'=> '1', 'name'=> 'en', 'fullname'=>'English', 'flag_photo'=> ''],
            ['id'=> '2', 'name'=> 'jp', 'fullname'=>'Japanese', 'flag_photo'=> ''],
        ]);
        
    }
}
