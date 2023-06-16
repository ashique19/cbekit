
<?php

use Illuminate\Database\Seeder;

class seedSettings extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        DB::table('settings')->insert([
            [
                'application_name'      =>'CBE KIT',
                'application_slogan'    =>'Computer Based Exam for ACCA',
                'business_name'         =>'POKA', 
                'owners_name'           =>'POKA', 
                'address'               =>'House-18, Road-1, Block-H, Banasree', 
                'city'                  =>'Dhaka', 
                'country'               =>'Bangladesh', 
                'postcode'              =>'1219', 
                'contact'               =>'+8801785636359', 
                'helpline'              =>'+8801785636359', 
                'helpmail'              =>'info@cbekit.com', 
                'email'                 =>'info@cbekit.com', 
                'logo_photo'            => '/public/img/settings/logo.png',
                'icon_photo'            => '/public/img/settings/favicon.png',
                'google_plus'           => 'http://plus.google.com',
                'facebook'              => 'http://facebook.com',
                'twitter'               => 'http://twitter.com',
                'is_controlled_access'  => '2',
            ],
        ]);
        
    }
}

        