
<?php

use Illuminate\Database\Seeder;

class currencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        DB::table('currencies')->insert([
            //['name'=>'USD'],
            ['name'=>'BDT'],
            //['name'=>'GBP'],
            //['name'=>'AUD'],
        ]);
        
    }
}

        