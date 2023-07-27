<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WeatherCurrentController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        return response()->json([
            "msg" => "you will get current weather upon location you requested"
        ]);
    }
}
