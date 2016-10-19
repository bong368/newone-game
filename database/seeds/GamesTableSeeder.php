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
                'name' => 'DOUDIZHUSLOT',
                'route' => 'cocos',
                'file_token' => Uuid::uuid4()->getHex(),
                'width' => 1280,
                'height' => 720,
                'server_url' => 'neogs.ricogaming.net',
                'server_port' => 8360,
                'server_api' => 'http://neogs.ricogaming.net:8000/server/rest',
                'jackpot' => true,
                'order' => 0,
                'category' => GameCategory::SLOT_MACHINE,
                'status' => GameStatus::PUBLIC,
            ],
            [
                'name' => 'BRUCELEE',
                'route' => 'legacy',
                'file_token' => Uuid::uuid4()->getHex(),
                'width' => 800,
                'height' => 600,
                'server_url' => 'neogs.ricogaming.net',
                'server_port' => 13000,
                'server_api' => 'http://neogs.ricogaming.net:14000',
                'jackpot' => true,
                'order' => 0,
                'category' => GameCategory::SLOT_MACHINE,
                'status' => GameStatus::PUBLIC,
            ],
            [
                'name' => 'KING5PK',
                'route' => 'legacy',
                'file_token' => Uuid::uuid4()->getHex(),
                'width' => 800,
                'height' => 600,
                'server_url' => 'neogs.ricogaming.net',
                'server_port' => 13000,
                'server_api' => 'http://neogs.ricogaming.net:14000',
                'jackpot' => true,
                'order' => 0,
                'category' => GameCategory::VIDEO_POKER,
                'status' => GameStatus::PUBLIC,
            ],
            [
                'name' => 'STARTEAMS5PK',
                'route' => 'legacy',
                'file_token' => Uuid::uuid4()->getHex(),
                'width' => 800,
                'height' => 600,
                'server_url' => 'neogs.ricogaming.net',
                'server_port' => 13000,
                'server_api' => 'http://neogs.ricogaming.net:14000',
                'jackpot' => true,
                'order' => 0,
                'category' => GameCategory::VIDEO_POKER,
                'status' => GameStatus::PUBLIC,
            ],
            [
                'name' => 'TEXASHOLDEMPOKER',
                'route' => 'texas-holdem',
                'file_token' => Uuid::uuid4()->getHex(),
                'width' => 800,
                'height' => 600,
                'server_url' => 'neogs.ricogaming.net',
                'server_port' => 7976,
                'server_api' => 'http://neogs.ricogaming.net:8000/server/rest',
                'jackpot' => false,
                'order' => 0,
                'category' => GameCategory::TABLE_GAME,
                'status' => GameStatus::PREVIEW,
            ],
        ]);
    }
}
