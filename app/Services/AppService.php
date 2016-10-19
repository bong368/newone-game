<?php

namespace App\Services;

use App\Models\App;

class AppService
{
    public function getByName($name)
    {
        return App::where('name', '=', $name)->first();
    }

    public function getByAppKey($appKey)
    {
        return App::where('app_key', '=', $appKey)->first();
    }
}
