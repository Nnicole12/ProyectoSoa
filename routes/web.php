<?php
use App\Http\Controllers\WeatherController;

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/prueba', function () {
    return view('prueba');
});
Route::get('/weather', [WeatherController::class, 'index']);

