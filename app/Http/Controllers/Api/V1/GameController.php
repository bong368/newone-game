<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Exceptions\ApiValidationException;
use App\Models\Game;

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

        $query = Game::appSubscribe($request->attributes->get('APP')->id)
            ->select('name', 'route', 'width', 'height', 'jackpot', 'category', 'status');

        if ($request->has('category')) {
            $query->where('category', '=', \GameCategory::toValue($request->input('category')));
        }
        if ($request->has('status')) {
            $query->where('status', '=', \GameStatus::toValue($request->input('status')));
        }

        $results = $query->orderBy('order', 'desc')
            ->orderBy('id', 'desc')
            ->paginate($request->input('limit', 10));

        return response()->paging($results);
    }
}
