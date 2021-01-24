<?php

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
        $this->call(UsersTableSeeder::class);
        $this->call(CategoriesTableSeeder::class);
        $this->call(SchoolsTableSeeder::class);
        $this->call(ClassesTableSeeder::class);
        $this->call(StudentsTableSeeder::class);
        $this->call(TicketsTableSeeder::class);
    }
}
