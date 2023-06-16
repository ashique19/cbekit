<?php

use Illuminate\Database\Seeder;

class seedUserTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [
                'username'          => 'ashique',
                'email'             => 'ashique19@gmail.com',
                'password'          => bcrypt('1234'),
                'role'              => 1,
                'firstname'         => 'md ashiqul',
                'lastname'          => 'islam',
                'name'              => 'Md Ashiqul Islam',
                'contact'           => '01710123456',
                'address'           => 'Banasree',
                'city'              => 'Dhaka',
                'state'             => 'Dhaka',
                'postcode'          => '1219',
                'country_id'        => 10,
                'parmanent_address' => 'Brahmanbaria',
                'active'            => '1',
                'expiry_date'       => \Carbon::now()->addYear(1),
                'user_photo'        => '\public\img\users\1.png',
                'balance'           => '100.52',
            ],
            [
                'username'          => 'admin',
                'email'             => 'admin@system.com',
                'password'          => bcrypt('1234'),
                'role'              => 2,
                'firstname'         => 'the admin',
                'lastname'          => 'of system',
                'name'              => 'The admin of system',
                'contact'           => '01710123457',
                'address'           => 'Mirpur 10',
                'city'              => 'Dhaka',
                'state'             => 'Dhaka',
                'postcode'          => '1219',
                'country_id'        =>  11,
                'parmanent_address' => 'Bangladesh',
                'active'            => '1',
                'expiry_date'       => null,
                'user_photo'        => '\public\img\users\1.png',
                'balance'           => '0',
            ],
            [
                'username'          => 'student',
                'email'             => 'student@system.com',
                'password'          => bcrypt('1234'),
                'role'              => 3,
                'firstname'         => 'the student',
                'lastname'          => 'of system',
                'name'              => 'The student of system',
                'contact'           => '01710123457',
                'address'           => 'Mirpur 10',
                'city'              => 'Dhaka',
                'state'             => 'Dhaka',
                'postcode'          => '1219',
                'country_id'        =>  11,
                'parmanent_address' => 'Bangladesh',
                'active'            => '1',
                'expiry_date'       => null,
                'user_photo'        => '\public\img\users\1.png',
                'balance'           => '0',
            ],
            [
                'username'          => 'teacher',
                'email'             => 'teacher@system.com',
                'password'          => bcrypt('1234'),
                'role'              => 4,
                'firstname'         => 'the teacher',
                'lastname'          => 'of system',
                'name'              => 'The teacher of system',
                'contact'           => '01710123457',
                'address'           => 'Mirpur 10',
                'city'              => 'Dhaka',
                'state'             => 'Dhaka',
                'postcode'          => '1219',
                'country_id'        =>  11,
                'parmanent_address' => 'Bangladesh',
                'active'            => '1',
                'expiry_date'       => null,
                'user_photo'        => '\public\img\users\1.png',
                'balance'           => '0',
            ],
            [
                'username'          => 'institute',
                'email'             => 'institute@system.com',
                'password'          => bcrypt('1234'),
                'role'              => 5,
                'firstname'         => 'the institute',
                'lastname'          => 'of system',
                'name'              => 'The institute of system',
                'contact'           => '01710123457',
                'address'           => 'Mirpur 10',
                'city'              => 'Dhaka',
                'state'             => 'Dhaka',
                'postcode'          => '1219',
                'country_id'        =>  11,
                'parmanent_address' => 'Bangladesh',
                'active'            => '1',
                'expiry_date'       => null,
                'user_photo'        => '\public\img\users\1.png',
                'balance'           => '0',
            ],
            
        ]);
    }
}
