<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(AppsTableSeeder::class);
        $this->call(GamesTableSeeder::class);
        $this->call(AppGameTableSeeder::class);
        $this->call(AdminsTableSeeder::class);
    }
}
