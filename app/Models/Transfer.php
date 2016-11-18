<?php

namespace App\Models;

use Carbon\Carbon;
use DB;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class Transfer extends Model
{
    protected $table = 'transfers';

    public $timestamps = false;

    public function getTypeAttribute($value)
    {
        return \TransferType::toName($value);
    }

    public function scopeReceipts($query, $appId)
    {
        return $query->join('members', 'transfers.member_id', '=', 'members.id')
            ->where('transfers.app_id', '=', $appId);
    }

    public static function inward($appId, $memberId, $amount)
    {
        $transactionNo = Uuid::uuid4()->getHex();
        $transactionAt = Carbon::now();

        DB::statement('CALL sp_transfer_inward(:app_id, :member_id, :tx_amount, :tx_no, :tx_at, @sp_code, @balance);', [
            'app_id' => $appId,
            'member_id' => $memberId,
            'tx_amount' => $amount,
            'tx_no' => $transactionNo,
            'tx_at' => $transactionAt,
        ]);

        $result = DB::select('SELECT @sp_code AS sp_code, @balance AS balance;');
        $spCode = $result[0]->sp_code;
        $balance = $result[0]->balance;

        if ($spCode !== 0) {
            throw new \Exception('Transaction failed', $spCode);
        }

        return [
            'type' => \TransferType::INWARD,
            'amount' => $amount,
            'balance' => $balance,
            'transaction_no' => $transactionNo,
            'transaction_at' => $transactionAt->toDateTimeString(),
        ];
    }

    public static function outward($appId, $memberId, $amount)
    {
        $transactionNo = Uuid::uuid4()->getHex();
        $transactionAt = Carbon::now();

        DB::statement('CALL sp_transfer_outward(:app_id, :member_id, :tx_amount, :tx_no, :tx_at, @sp_code, @balance);', [
            'app_id' => $appId,
            'member_id' => $memberId,
            'tx_amount' => $amount,
            'tx_no' => $transactionNo,
            'tx_at' => $transactionAt,
        ]);

        $result = DB::select('SELECT @sp_code AS sp_code, @balance AS balance;');
        $spCode = $result[0]->sp_code;
        $balance = $result[0]->balance;

        if ($spCode !== 0) {
            throw new \Exception('Transaction failed', $spCode);
        }

        return [
            'type' => \TransferType::OUTWARD,
            'amount' => $amount,
            'balance' => $balance,
            'transaction_no' => $transactionNo,
            'transaction_at' => $transactionAt->toDateTimeString(),
        ];
    }
}
