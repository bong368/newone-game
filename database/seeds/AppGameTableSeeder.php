<?php

use Illuminate\Database\Seeder;

class AppGameTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('app_game')->insert([
            [
                'app_id' => 1,
                'game_id' => 1,
            ],
            [
                'app_id' => 1,
                'game_id' => 2,
            ],
            [
                'app_id' => 1,
                'game_id' => 3,
            ],
            [
                'app_id' => 1,
                'game_id' => 4,
            ],
            [
                'app_id' => 2,
                'game_id' => 1,
            ],
            [
                'app_id' => 2,
                'game_id' => 3,
            ],
        ]);
    }
}
