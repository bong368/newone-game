<?php

use Illuminate\Database\Seeder;
use Ramsey\Uuid\Uuid;

class GamesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('games')->insert([
            [
                'name' => 'AVHATANOYUI',
                'route' => 'proloader',
                'file_token' => Uuid::uuid4()->getHex(),
                'width' => 1280,
                'height' => 760,
                'server_url' => 'quanhualab01.cloudapp.net',
                'server_port' => 9035,
                'server_api' => 'http://quanhualab01.cloudapp.net:8000/avslotmachineserver/rest',
                'jackpot' => true,
                'order' => 0,
                'category' => GameCategory::SLOT_MACHINE,
                'status' => GameStatus::PUBLIC,
            ],
            [
                'name' => 'OASISPOKERBASIC',
                'route' => 'createjs',
                'file_token' => Uuid::uuid4()->getHex(),
                'width' => 1280,
                'height' => 760,
                'server_url' => 'quanhualab01.cloudapp.net',
                'server_port' => 9035,
                'server_api' => 'http://quanhualab01.cloudapp.net:8000/avslotmachineserver/rest',
                'jackpot' => true,
                'order' => 0,
                'category' => GameCategory::SLOT_MACHINE,
                'status' => GameStatus::PUBLIC,
            ],
            [
                'name' => 'DOUDIZHUSLOT',
                'route' => 'cocos2d',
                'file_token' => Uuid::uuid4()->getHex(),
                'width' => 1280,
                'height' => 720,
                'server_url' => 'quanhualab01.cloudapp.net',
                'server_port' => 8360,
                'server_api' => 'http://quanhualab01.cloudapp.net:8000/avslotmachineserver/rest',
                'jackpot' => true,
                'order' => 0,
                'category' => GameCategory::SLOT_MACHINE,
                'status' => GameStatus::PUBLIC,
            ],
            [
                'name' => 'TEXASHOLDEMPOKER',
                'route' => 'texasholdem',
                'file_token' => Uuid::uuid4()->getHex(),
                'width' => 800,
                'height' => 600,
                'server_url' => 'igdev.ricogaming.net',
                'server_port' => 7976,
                'server_api' => 'http://igdev.ricogaming.net:8000/server/rest',
                'jackpot' => false,
                'order' => 0,
                'category' => GameCategory::TABLE_GAME,
                'status' => GameStatus::PREVIEW,
            ],
        ]);
    }
}
