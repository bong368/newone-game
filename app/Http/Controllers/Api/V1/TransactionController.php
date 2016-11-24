<?php

namespace App\Http\Controllers\Api\V1;

use App\Exceptions\ApiException;
use App\Exceptions\ApiNotFoundException;
use App\Exceptions\ApiValidationException;
use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Models\Transfer;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $validator = \Validator::make($request->input(), [
            'type' => ['in:'.implode(',', \TransferType::getNames())],
            'from' => ['date'],
            'to' => ['date'],
            'limit' => ['integer', 'min:1'],
            'page' => ['integer', 'min:1'],
        ]);

        if ($validator->fails()) {
            throw new ApiValidationException($validator->errors());
        }

        $appId = $request->attributes->get('APP')->id;

        $query = Transfer::receipts($appId)
            ->select('members.username', 'transfers.type', 'transfers.amount', 'transfers.balance', 'transfers.transaction_no', 'transfers.transaction_at');

        if ($request->has('username')) {
            $query->where('members.username', '=', $request->input('username'));
        }
        if ($request->has('type')) {
            $query->where('transfers.type', '=', \TransferType::toValue($request->input('type')));
        }
        if ($request->has('from')) {
            $query->where('transfers.transaction_at', '>=', $request->input('from'));
        }
        if ($request->has('to')) {
            $query->where('transfers.transaction_at', '<=', $request->input('to'));
        }

        $results = $query->orderBy('transfers.id', 'desc')
            ->paginate($request->input('limit', 10));

        return response()->paging($results);
    }

    public function show(Request $request, $transactionNo)
    {
        $appId = $request->attributes->get('APP')->id;

        $transaction = Transfer::receipts($appId)
            ->where('transfers.transaction_no', '=', $transactionNo)
            ->select('members.username', 'transfers.type', 'transfers.amount', 'transfers.balance', 'transfers.transaction_no', 'transfers.transaction_at')
            ->first();

        if ($transaction === null) {
            throw new ApiNotFoundException('Transaction not found', 404000);
        }

        return response()->json($transaction);
    }

    public function inward(Request $request)
    {
        $validator = \Validator::make($request->input(), [
            'username' => ['required'],
            'amount' => ['required', 'numeric', 'between:0.01,100000000.00'],
        ]);

        if ($validator->fails()) {
            throw new ApiValidationException($validator->errors());
        }

        $appId = $request->attributes->get('APP')->id;

        $player = Member::unDeletePlayer($appId)
            ->where('username', '=', $request->input('username'))
            ->select('id', 'username')
            ->first();

        if ($player === null) {
            throw new ApiNotFoundException('Player not found', 404000);
        }

        try {
            $receipt = Transfer::inward($appId, $player->id, $request->input('amount'));
        } catch (\Exception $e) {
            throw new ApiException(422, $e->getMessage(), 422001);
        }

        return response()->json([
            'username' => $player->username,
            'type' => \TransferType::toName($receipt['type']),
            'amount' => $receipt['amount'],
            'balance' => $receipt['balance'],
            'transaction_no' => $receipt['transaction_no'],
            'transaction_at' => $receipt['transaction_at'],
        ]);
    }

    public function outward(Request $request)
    {
        $validator = \Validator::make($request->input(), [
            'username' => ['required'],
            'amount' => ['required', 'numeric', 'between:0.01,100000000.00'],
        ]);

        if ($validator->fails()) {
            throw new ApiValidationException($validator->errors());
        }

        $appId = $request->attributes->get('APP')->id;

        $player = Member::unDeletePlayer($appId)
            ->where('username', '=', $request->input('username'))
            ->select('id', 'username')
            ->first();

        if ($player === null) {
            throw new ApiNotFoundException('Player not found', 404000);
        }

        try {
            $receipt = Transfer::outward($appId, $player->id, $request->input('amount'));
        } catch (\Exception $e) {
            throw new ApiException(422, $e->getMessage(), 422001);
        }

        return response()->json([
            'username' => $player->username,
            'type' => \TransferType::toName($receipt['type']),
            'amount' => $receipt['amount'],
            'balance' => $receipt['balance'],
            'transaction_no' => $receipt['transaction_no'],
            'transaction_at' => $receipt['transaction_at'],
        ]);
    }
}
