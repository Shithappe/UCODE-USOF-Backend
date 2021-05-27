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
        $users = [];

        $users[] = [
            'name' => 'Admin',
            'login' => 'admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('admin'),
            'role' => 'admin'
        ];
        \DB::table("users")->insert($users);
    }

    
}
