<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    public $timestamps = false;

    protected $casts = [
        'jackpot' => 'boolean',
    ];

    public function getCategoryAttribute($value)
    {
        return \GameCategory::toName($value);
    }

    public function getStatusAttribute($value)
    {
        return \GameStatus::toName($value);
    }

    public function apps()
    {
        return $this->belongsToMany(App::class);
    }
}
