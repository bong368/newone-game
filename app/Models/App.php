<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class App extends Model
{
    public $timestamps = false;

    public function games()
    {
        return $this->belongsToMany(Game::class);
    }
}
