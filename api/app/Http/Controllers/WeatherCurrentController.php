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
    public function __invoke(int $userId)
    {
        try {
            $user = User::findOrFail($userId);

            $data = Cache::get("user-{$user->id}-current");

            event(new \App\Events\GetCurrentWeather($userId, $data));

            return response()->json(['msg' => 'success']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 501);
        }
    }
}