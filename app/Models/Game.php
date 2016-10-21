<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    protected $table = 'games';

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

    public function scopeAppSubscribe($query, $appId)
    {
        return $query->join('app_game', 'games.id', '=', 'app_game.game_id')
            ->where('games.status', '<>', \GameStatus::PRIVATE)
            ->where('app_game.app_id', '=', $appId);
    }

//    public function apps()
//    {
//        return $this->belongsToMany(App::class);
//    }
}
