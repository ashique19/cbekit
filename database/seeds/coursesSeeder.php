<?php

use Illuminate\Database\Seeder;

class coursesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        DB::table('courses')->insert([
            ['id'=> 1,  'name'=> 'FA1', 'alter_name'=> 'Recording Financial Transactions'],
            ['id'=> 2,  'name'=> 'MA1', 'alter_name'=> 'Management Information'],
            ['id'=> 3,  'name'=> 'FA2', 'alter_name'=> 'Maintaining Financial Records'],
            ['id'=> 4,  'name'=> 'MA2', 'alter_name'=> 'Managing Costs and Finance'],
            ['id'=> 5,  'name'=> 'AB', 'alter_name'=> 'Accountant in Business'],
            ['id'=> 6,  'name'=> 'MA', 'alter_name'=> 'Management Accounting'],
            ['id'=> 7,  'name'=> 'FA', 'alter_name'=> 'Financial Accounting'],
            ['id'=> 11, 'name'=> 'LW (GLO)',  'alter_name'=> 'Corporate and Business Law'],
            ['id'=> 12, 'name'=> 'PM',  'alter_name'=> 'Performance Management'],
            ['id'=> 13, 'name'=> 'TX (UK)',  'alter_name'=> 'Taxation'],
            ['id'=> 14, 'name'=> 'FR',  'alter_name'=> 'Financial reporting'],
            ['id'=> 15, 'name'=> 'AA',  'alter_name'=> 'Audit and Assurance'],
            ['id'=> 16, 'name'=> 'FM',  'alter_name'=> 'Financial Management'],
        ]);
        
    }
}
