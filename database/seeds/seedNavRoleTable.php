
<?php

use Illuminate\Database\Seeder;

class seedNavRoleTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('nav_role')->insert([
            
            ['nav_id'=>2, 'role_id'=>1],
            ['nav_id'=>3, 'role_id'=>1],
            ['nav_id'=>4, 'role_id'=>1],
            ['nav_id'=>5, 'role_id'=>1],
            ['nav_id'=>6, 'role_id'=>1],
            ['nav_id'=>7, 'role_id'=>1],
            ['nav_id'=>8, 'role_id'=>1],
            ['nav_id'=>9, 'role_id'=>1],
            ['nav_id'=>10, 'role_id'=>1],
            
            ['nav_id'=>1, 'role_id'=>2],
            
        ]);
    }
}

        