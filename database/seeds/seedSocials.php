<?php

use Illuminate\Database\Seeder;

class seedSocials extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        DB::table('socials')->insert([
            ['name' => 'internal'],
            ['name' => 'github'],
            ['name' => 'facebook'],
            ['name' => 'google'],
            ['name' => 'twitter'],
        ]);
        
    }
}
