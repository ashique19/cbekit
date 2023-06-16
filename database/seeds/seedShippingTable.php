<?php

use Illuminate\Database\Seeder;

class seedShippingTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        DB::table('shippings')->insert([
            ['name'=>'Inside Dhaka via Sundorbon Courier', 'cost'=>'100', 'delivery_days' => 1 ],
            ['name'=>'Inside Dhaka via Sellers delivery chain', 'cost'=>'0', 'delivery_days' => 2 ],
            ['name'=>'Outside Dhaka via Sellers delivery chain', 'cost'=>'300', 'delivery_days' => 7 ],
            ['name'=>'Outside Dhaka via Sundorbon Courier', 'cost'=>'700', 'delivery_days' => 2 ],
        ]);
        
    }
}
