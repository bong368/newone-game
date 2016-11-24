<?php

namespace App\Http\Controllers\Api\V1;

use App\Exceptions\ApiNotFoundException;
use App\Exceptions\ApiValidationException;
use App\Http\Controllers\Controller;
use App\Models\Game;
use Illuminate\Http\Request;

class GameController extends Controller
{
    public function index(Request $request)
    {
        $validator = \Validator::make($request->input(), [
            'category' => ['in:'.implode(',', \GameCategory::getNames())],
            'status' => ['in:'.implode(',', \GameStatus::getNames())],
            'limit' => ['integer', 'min:1'],
            'page' => ['integer', 'min:1'],
        ]);

        if ($validator->fails()) {
            throw new ApiValidationException($validator->errors());
        }

        $appId = $request->attributes->get('APP')->id;

        $query = Game::unPrivateSubscribes($appId)
            ->select('games.name', 'games.route', 'games.width', 'games.height', 'games.jackpot', 'games.category', 'games.status');

        if ($request->has('category')) {
            $query->where('games.category', '=', \GameCategory::toValue($request->input('category')));
        }
        if ($request->has('status')) {
            $query->where('games.status', '=', \GameStatus::toValue($request->input('status')));
        }

        $results = $query->orderBy('games.order', 'desc')
            ->orderBy('games.id', 'desc')
            ->paginate($request->input('limit', 10));

        return response()->paging($results);
    }

    public function show(Request $request, $name)
    {
        $appId = $request->attributes->get('APP')->id;

        $game = Game::unPrivateSubscribes($appId)
            ->where('games.name', '=', $name)
            ->select('games.name', 'games.route', 'games.width', 'games.height', 'games.jackpot', 'games.category', 'games.status')
            ->first();

        if ($game === null) {
            throw new ApiNotFoundException('Game not found', 404000);
        }

        return response()->json($game);
    }
}
