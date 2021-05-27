<?php

namespace Database\Seeders;

use App\Models\Author;
use App\Models\Book;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        // Author::factory(5)->create();
        // Book::factory(50)->create();

        $this->call(UserSeeder::class);
        \App\Models\User::factory(8)->create();
    }
}
