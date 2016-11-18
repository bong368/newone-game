<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    protected $table = 'members';

    public $timestamps = false;

    public function getRoleAttribute($value)
    {
        return \MemberRole::toName($value);
    }

    public function getTypeAttribute($value)
    {
        return \MemberType::toName($value);
    }

    public function getStatusAttribute($value)
    {
        return \MemberStatus::toName($value);
    }

//    public function scopeApp($query, $appId)
//    {
//        return $query->where('app_id', '=', $appId);
//    }
//
//    public function scopePlayer($query)
//    {
//        return $query->where('role', '=', \MemberRole::PLAYER);
//    }
//
//    public function scopeAlive($query)
//    {
//        return $query->where('status', '<>', \MemberStatus::DELETE);
//    }

    public function scopeAlivePlayer($query, $appId)
    {
        return $query->where('app_id', '=', $appId)
            ->where('role', '=', \MemberRole::PLAYER)
            ->where('status', '<>', \MemberStatus::DELETE);
    }
}
