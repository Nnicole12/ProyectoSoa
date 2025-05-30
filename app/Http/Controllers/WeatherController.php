<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class WeatherController extends Controller
{
    private $cities = ['Quito', 'Guayaquil', 'Cuenca', 'Loja', 'Ambato'];

    public function index()
    {
        // Obtener la API key desde .env
        $apiKey = env('CLIMA_API');

        $weatherData = [];

        foreach ($this->cities as $city) {
            $response = Http::get('https://api.openweathermap.org/data/2.5/weather', [
                'q' => $city,
                'appid' => $apiKey,
                'units' => 'metric',
                'lang' => 'es',
            ]);

            if ($response->successful()) {
                $data = $response->json();

                $weatherData[] = [
                    'city' => $city,
                    'temperature' => $data['main']['temp'],
                    'feels_like' => $data['main']['feels_like'],
                    'humidity' => $data['main']['humidity'],
                    'description' => $data['weather'][0]['description'],
                ];
            } else {
                $weatherData[] = [
                    'city' => $city,
                    'error' => 'No se pudo obtener datos',
                ];
            }
        }

        return view('weather.index', compact('weatherData'));
    }
}
