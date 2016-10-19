<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class AdminsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = Carbon::now();

        DB::table('admins')->insert([
            [
                'username' => 'superadmin',
                'nickname' => 'Superadmin',
                'password' => bcrypt('rico@ricogaming'),
                'role' => AdminRole::ROOT,
                'status' => AdminStatus::ACTIVE,
                'registered_at' => $now,
            ],
            [
                'username' => 'greene',
                'nickname' => 'Greene',
                'password' => bcrypt('12qwaszx'),
                'role' => AdminRole::ADMIN,
                'status' => AdminStatus::ACTIVE,
                'registered_at' => $now,
            ],
            [
                'username' => 'cooper',
                'nickname' => 'Cooper',
                'password' => bcrypt('12qwaszx'),
                'role' => AdminRole::ADMIN,
                'status' => AdminStatus::ACTIVE,
                'registered_at' => $now,
            ],
        ]);
    }
}
