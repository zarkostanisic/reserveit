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
        $this->call([
            GeosTableSeeder::class,
            CategoriesTableSeeder::class,
            RolesTableSeeder::class,

            CompaniesTableSeeder::class,
        	UsersTableSeeder::class
        ]);
    }
}
