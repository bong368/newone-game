<?php

namespace App\Http\Controllers\Api\V1;

use App\Exceptions\ApiNotFoundException;
use App\Exceptions\ApiValidationException;
use App\Http\Controllers\Controller;
use App\Models\Member;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Ramsey\Uuid\Uuid;

class PlayerController extends Controller
{
    public function create(Request $request)
    {
        $appId = $request->attributes->get('APP')->id;

        $validator = \Validator::make($request->input(), [
            'username' => [
                'required', 'regex:/^[a-zA-Z0-9]*$/', 'between:2,50',
                Rule::unique('members')->where(function ($query) use ($appId) {
                    $query->where('app_id', '=', $appId);
                })
            ],
            'nickname' => ['required', 'between:2,50'],
        ]);

        if ($validator->fails()) {
            throw new ApiValidationException($validator->errors());
        }

        $player = new Member();
        $player->app_id = $appId;
        $player->parent_id = 0;
        $player->username = $request->input('username');
        $player->nickname = $request->input('nickname');
        $player->password = Uuid::uuid4()->getHex();
        $player->coin = 0;
        $player->take_rate = 0;
        $player->role = \MemberRole::PLAYER;
        $player->type = \MemberType::CASH;
        $player->status = \MemberStatus::ACTIVE;
        $player->access_token = Uuid::uuid4()->getHex();
        $player->registered_at = Carbon::now();
        $player->save();

        return response()->json([
            'username' => $player->username,
            'nickname' => $player->nickname,
            'coin' => $player->coin,
            'status' => $player->status,
            'access_token' => $player->access_token,
        ]);
    }

    public function show(Request $request, $username)
    {
        $appId = $request->attributes->get('APP')->id;

        $player = Member::unDeletePlayer($appId)
            ->where('username', '=', $username)
            ->select('username', 'nickname', 'coin', 'status', 'access_token')
            ->first();

        if ($player === null) {
            throw new ApiNotFoundException('Player not found', 404000);
        }

        return response()->json($player);
    }

    public function update(Request $request, $username)
    {
        $validator = \Validator::make($request->input(), [
            'nickname' => ['between:2,50'],
            'status' => ['in:'.implode(',', \MemberStatus::getNames())],
        ]);

        if ($validator->fails()) {
            throw new ApiValidationException($validator->errors());
        }

        $appId = $request->attributes->get('APP')->id;

        $player = Member::unDeletePlayer($appId)
            ->where('username', '=', $username)
            ->first();

        if ($player === null) {
            throw new ApiNotFoundException('Player not found', 404000);
        }

        if ($request->has('nickname')) {
            $player->nickname = $request->input('nickname');
        }
        if ($request->has('status')) {
            $player->status = \MemberStatus::toValue($request->input('status'));
        }
        $player->save();

        return response()->json([
            'username' => $player->username,
            'nickname' => $player->nickname,
            'coin' => $player->coin,
            'status' => $player->status,
            'access_token' => $player->access_token,
        ]);
    }

    public function refreshAccessToken(Request $request, $username)
    {
        $appId = $request->attributes->get('APP')->id;

        $player = Member::unDeletePlayer($appId)
            ->where('username', '=', $username)
            ->first();

        if ($player === null) {
            throw new ApiNotFoundException('Player not found', 404000);
        }

        $player->access_token = Uuid::uuid4()->getHex();
        $player->save();

        return response()->json([
            'username' => $player->username,
            'nickname' => $player->nickname,
            'coin' => $player->coin,
            'status' => $player->status,
            'access_token' => $player->access_token,
        ]);
    }
}
