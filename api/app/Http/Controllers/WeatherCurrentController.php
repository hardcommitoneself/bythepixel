<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Cache;

class WeatherCurrentController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $data = [];

        $users = User::all();

        foreach ($users as $user) {
            $data[] = Cache::get("user-{$user->id}-current");
        }

        return response()->json($data);
    }
}
