<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function index()
    {
        return response()->json([
            'version' => config('app.version')
        ]);
    }
}
