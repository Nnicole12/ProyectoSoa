<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WeatherController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Ruta principal que devuelve la vista de bienvenida de Laravel
Route::get('/', function () {
    return view('welcome');
});

// Ruta para mostrar la página principal del clima (GET)
// y para procesar la consulta del clima (POST)
// Usa Route::match para aceptar ambos métodos HTTP
Route::match(['get', 'post'], '/weather', [WeatherController::class, 'getCurrentWeather']);

// Ruta para mostrar el historial de consultas
Route::get('/weather/history', [WeatherController::class, 'showHistory']);

