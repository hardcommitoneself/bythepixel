<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WeatherCurrentController;
use App\Http\Controllers\WeatherForecastController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/', function () {
    return response()->json([
        'message' => 'all systems are a go',
        'users' => \App\Models\User::all(),
    ]);
});

Route::get('/test', function () {
});

Route::get('/current/{userId}', WeatherCurrentController::class);
Route::get('/forecast/{userId}', WeatherForecastController::class);
