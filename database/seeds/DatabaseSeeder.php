<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->call(seedSettings::class);
        $this->call(seedSocials::class);
        $this->call(seedGatewayTable::class);
        $this->call(seedPages::class);
        $this->call(countrySeeder::class);
        $this->call(currencySeeder::class);
        $this->call(seedRoleTable::class);
        $this->call(seedNavsTable::class);
        $this->call(seedNavRoleTable::class);
        $this->call(seedPermissions::class);
        $this->call(seedPermissionRole::class);
        $this->call(seedUserTable::class);
        $this->call(coursesSeeder::class);

        Model::reguard();
    }
}

    