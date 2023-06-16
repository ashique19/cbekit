<?php

use Illuminate\Database\Seeder;

class seedGatewayTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        DB::table('gateways')->insert([
            ['name'=>'Cash on delivery', 'charge'=>'100', 'is_active'=> 1 ],
            ['name'=>'bKash', 'charge'=>'10', 'is_active'=> 1 ],
        ]);
        
    }
}
