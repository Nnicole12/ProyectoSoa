<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\WeatherRecord;
use Carbon\Carbon;

class WeatherController extends Controller
{
    /**
     * Muestra la página principal del clima y, si es una solicitud POST,
     * consulta el clima de la ciudad especificada y lo guarda en la base de datos.
     *
     * @param Request $request La solicitud HTTP.
     * @return \Illuminate\View\View La vista del clima.
     */
    public function getCurrentWeather(Request $request)
    {
        $weatherData = null; // Para los datos de la ciudad consultada
        $errors = [];
        $lastConsultedCity = $request->input('city'); // Guarda la última ciudad consultada para el input

        // Si la solicitud es POST (se presionó el botón "Consultar Ciudad")
        if ($request->isMethod('post')) {
            $city = $request->input('city'); // Obtiene la ciudad del formulario

            // Validar que se haya ingresado una ciudad
            if (empty($city)) {
                $errors[] = 'Por favor, ingresa el nombre de una ciudad.';
            } else {
                $apiKey = env('climaApi');

                // Verifica si la clave API está configurada.
                if (empty($apiKey)) {
                    $errors[] = 'API Key de OpenWeatherMap no configurada. Por favor, revisa tu archivo .env';
                } else {
                    $response = Http::get("https://api.openweathermap.org/data/2.5/weather", [
                        'q' => $city,
                        'appid' => $apiKey,
                        'units' => 'metric',
                        'lang' => 'es',
                    ]);

                    if ($response->successful()) {
                        $weatherData = $response->json(); // Almacena los datos de la ÚNICA ciudad
                        $lastConsultedCity = $weatherData['name']; // Actualiza por si el nombre es diferente (ej. "New York" -> "Nueva York")

                        // --- Lógica para guardar en la base de datos ---
                        try {
                            WeatherRecord::create([
                                'city_name' => $weatherData['name'],
                                'weather_data' => $weatherData,
                                'consulted_at' => Carbon::now(),
                            ]);
                        } catch (\Exception $e) {
                            $errors[] = 'Error al guardar el clima de "' . $weatherData['name'] . '" en la base de datos: ' . $e->getMessage();
                        }
                        // --- Fin de la lógica para guardar en la base de datos ---

                    } else {
                        $errorMessage = 'No se pudieron obtener los datos del clima para "' . $city . '".';
                        if ($response->status() === 404) {
                            $errorMessage .= ' Ciudad no encontrada o error en el nombre.';
                        } else {
                            $errorMessage .= ' Código de error: ' . $response->status();
                        }
                        $errors[] = $errorMessage;
                    }
                }
            }
        }

        // Siempre devuelve la vista 'weather', pasando los datos si se consultaron.
        // ¡Añadimos la variable $request aquí!
        return view('weather', [
            'weatherData' => $weatherData,
            'errors' => $errors,
            'lastConsultedCity' => $lastConsultedCity,
            'request' => $request, // <-- ¡Esta es la línea que faltaba!
        ]);
    }

    /**
     * Muestra el historial de registros del clima desde la base de datos.
     *
     * @return \Illuminate\View\View La vista del historial del clima.
     */
    public function showHistory()
    {
        $historyRecords = WeatherRecord::orderBy('consulted_at', 'desc')->get();
        return view('history', ['historyRecords' => $historyRecords]);
    }
}
