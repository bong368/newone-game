<?php

use Illuminate\Database\Seeder;
use Ramsey\Uuid\Uuid;

class AppsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('apps')->insert([
            [
                'name' => 'neostar',
                'app_key' => Uuid::uuid4()->getHex(),
                'secret_key' => Uuid::uuid4()->getHex(),
            ],
            [
                'name' => 'livecasino',
                'app_key' => Uuid::uuid4()->getHex(),
                'secret_key' => Uuid::uuid4()->getHex(),
            ],
            [
                'name' => 'avslot',
                'app_key' => Uuid::uuid4()->getHex(),
                'secret_key' => Uuid::uuid4()->getHex(),
            ],
        ]);
    }
}
