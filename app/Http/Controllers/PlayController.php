<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Game;
use App\Models\Member;
use App\Models\GameClick;
use App\Exceptions\ApiNotFoundException;
use App\Exceptions\ApiException;
use Jenssegers\Agent\Agent;
use Carbon\Carbon;

class PlayController extends Controller
{
    public function index(Request $request, $name, $accessToken)
    {
        $player = Member::where('role', '=', \MemberRole::PLAYER)
            ->where('status', '=', \MemberStatus::ACTIVE)
            ->where('access_token', '=', $accessToken)
            ->select('id', 'app_id', 'username', 'access_token')
            ->first();

        if ($player === null) {
            throw new ApiNotFoundException('Player not found', 404000);
        }

        $game = Game::publicSubscribes($player->app_id)
            ->where('games.name', '=', $name)
            ->select('games.id', 'games.name', 'games.route', 'games.file_token', 'games.server_url', 'games.server_port')
            ->first();

        if ($game === null) {
            throw new ApiNotFoundException('Game not found', 404001);
        }
        if (!method_exists($this, $game->route)) {
            throw new ApiNotFoundException('Method not found', 404002);
        }

        list($platform, $browser, $languages) = $this->getUserAgent();

        $this->gameClick($player->app_id, $player->id, $game->id, $platform, $browser, $request->ip(), Carbon::now());

        $result = $this->{$game->route}($player, $game);

//        try {
//
//        } catch (\Exception $e) {
//            throw new ApiException(500, 'Method ['.$game->route.'] error', 50000);
//        }

        return response()->view('play.'.$game->route, $result);
    }

    private function loader(Member $player, Game $game)
    {
//        public string LoaderToken { get; set; }
//        public string GameName { get; set; }
//        public string GameToken { get; set; }
//        public string Culture { get; set; }
//        public int GameWidth { get; set; }
//        public int GameHeight { get; set; }
//        public string ServerUrl { get; set; }
//        public int ServerPort { get; set; }
//        public string AccessToken { get; set; }
//        public string Account { get; set; }

//        return 'loader: '.$name;

        return [
            'loader_token' => 'loader_token',
            'game_name' => $game->name,
            'game_token' => $game->file_token,
            'game_width' => 800,
            'game_height' => 600,
            'culture' => 'en-US',
            'server_url' => $game->server_url,
            'server_port' => $game->server_port,
            'access_token' => $player->access_token,
            'account' => $player->username,
        ];
    }

    private function proloader($name)
    {
//        public string LoaderToken { get; set; }
//        public string GameName { get; set; }
//        public string GameToken { get; set; }
//        public string Culture { get; set; }
//        public string ServerUrl { get; set; }
//        public int ServerPort { get; set; }
//        public string AccessToken { get; set; }

        return 'proloader: '.$name;
    }

    private function createjs($name)
    {
//        public string GameName { get; set; }
//        public string GameToken { get; set; }
//        public string Culture { get; set; }
//        public string ServerUrl { get; set; }
//        public int ServerPort { get; set; }
//        public string AccessToken { get; set; }

        return 'createjs: '.$name;
    }

    private function cocos($name)
    {
//        public string GameName { get; set; }
//        public string GameToken { get; set; }
//        public string Culture { get; set; }
//        public string ServerUrl { get; set; }
//        public int ServerPort { get; set; }
//        public string AccessToken { get; set; }

        return 'cocos: '.$name;
    }

    private function getUserAgent()
    {
        $agent = new Agent();
        $platform = $agent->platform();
        $browser = $agent->browser();

        return [
            $platform.'/'.$agent->version($platform),
            $browser.'/'.$agent->version($browser),
            $agent->languages()
        ];
    }

    private function gameClick($appId, $memberId, $gameId, $platform, $browser, $ipAddress, $clickedAt)
    {
        $gameClick = new GameClick();
        $gameClick->app_id = $appId;
        $gameClick->member_id = $memberId;
        $gameClick->game_id = $gameId;
        $gameClick->platform = $platform;
        $gameClick->browser = $browser;
        $gameClick->ip_address = $ipAddress;
        $gameClick->clicked_at = $clickedAt;
        $gameClick->save();
    }
}
