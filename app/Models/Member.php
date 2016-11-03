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
}
