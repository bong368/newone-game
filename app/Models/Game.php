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

    public function scopeSubscribes($query, $appId)
    {
        return $query->join('app_game', 'games.id', '=', 'app_game.game_id')
            ->where('app_game.app_id', '=', $appId);
    }

    public function scopeUnPrivateSubscribes($query, $appId)
    {
        return $query->join('app_game', 'games.id', '=', 'app_game.game_id')
            ->where('app_game.app_id', '=', $appId)
            ->where('games.status', '<>', \GameStatus::PRIVATE);
    }

    public function scopePublicSubscribes($query, $appId)
    {
        return $query->join('app_game', 'games.id', '=', 'app_game.game_id')
            ->where('app_game.app_id', '=', $appId)
            ->where('games.status', '=', \GameStatus::PUBLIC);
    }
}
