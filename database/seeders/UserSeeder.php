<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {


        $admin = [
            'name' => 'Admin',
            'login' => 'admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('admin'),
            'role' => 'admin'
        ];

        $user = [
            'name' => 'max',
            'login' => 'awd',
            'email' => '2awdawd2@gmail.com',
            'password' => bcrypt('awd'),
            'role' => 'user'
        ];

        \DB::table("users")->insert($user);
        \DB::table("users")->insert($admin);
    }

    
}
