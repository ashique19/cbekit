<?php

use Illuminate\Database\Seeder;

class seedPages extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        DB::table('pages')->insert([
            ['name'=>'about-us', 'details'=>''],
            ['name'=>'privacy-policy', 'details'=>''],
            ['name'=>'terms-of-service', 'details'=>''],
        ]);
        
    }
}
