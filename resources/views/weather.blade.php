<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consulta de Clima por Ciudad</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" xintegrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        /* Estilos generales del cuerpo */
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(to bottom right, #6a82fb, #fc5c7d);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
        }

        /* Contenedor principal */
        .container {
            max-width: 800px; /* Ajustado para una sola tarjeta */
            background-color: rgba(255, 255, 255, 0.95);
            border-radius: 1.5rem;
            box-shadow: 0 1rem 2rem rgba(0, 0, 0, 0.25);
            padding: 2.5rem;
        }

        /* Título principal */
        h1.display-4 {
            color: #343a40; /* Color oscuro para el título dentro del contenedor blanco */
            font-weight: 700;
            margin-bottom: 2rem;
            text-align: center;
        }

        /* Estilo de la tarjeta de clima */
        .weather-card {
            background-color: #fff; /* Fondo blanco puro para la tarjeta de resultado */
            border-radius: 1.5rem;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
            transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
            border: none;
            overflow: hidden;
            margin-top: 2rem; /* Espacio después del formulario */
        }

        .weather-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 0.75rem 1.5rem rgba(0, 0, 0, 0.2);
        }

        /* Contenido de la tarjeta */
        .card-body {
            padding: 2rem;
        }

        .card-title {
            color: #343a40;
            font-weight: 600;
            font-size: 1.8rem;
        }

        .weather-icon {
            width: 100px;
            height: 100px;
            margin-bottom: 1rem;
            filter: drop-shadow(2px 2px 3px rgba(0, 0, 0, 0.2));
        }

        .card-text {
            color: #555;
            font-size: 1.1rem;
            margin-bottom: 0.5rem;
        }

        .card-text .fw-bold {
            color: #333;
        }

        .card-text.h4 {
            color: #1a202c;
            font-weight: 700;
            margin-top: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .card-text.small {
            color: #777;
            font-size: 0.85rem;
            margin-top: auto;
            padding-top: 1rem;
            border-top: 1px solid rgba(0, 0, 0, 0.05);
        }

        /* Alertas de error/advertencia */
        .alert {
            border-radius: 0.75rem;
            box-shadow: 0 0.25rem 0.5rem rgba(0, 0, 0, 0.1);
            font-weight: 500;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            h1.display-4 {
                font-size: 2.5rem;
            }
            .container {
                padding: 1.5rem;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="display-4 fw-bold">Consulta el Clima</h1>

        <form action="{{ url('/weather') }}" method="POST" class="row g-3 align-items-end mb-4">
            @csrf
            <div class="col-md-8">
                <label for="cityInput" class="form-label visually-hidden">Nombre de la Ciudad</label>
                <input type="text" class="form-control form-control-lg" id="cityInput" name="city" placeholder="Ej: Quito, Guayaquil, New York" value="{{ $lastConsultedCity ?? '' }}" required>
            </div>
            <div class="col-md-4">
                <button type="submit" class="btn btn-primary btn-lg w-100">Consultar Ciudad</button>
            </div>
            <div class="col-12 mt-3 text-center">
                <a href="{{ url('/weather/history') }}" class="btn btn-secondary btn-lg">Ver Historial de Consultas</a>
            </div>
        </form>

        @if (!empty($errors))
            <div class="alert alert-danger mb-4" role="alert">
                <h4 class="alert-heading">¡Error!</h4>
                <ul class="mb-0 ps-3">
                    @foreach ($errors as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Muestra la tarjeta de clima solo si hay datos de una ciudad consultada --}}
        @if (isset($weatherData) && $weatherData['cod'] == 200)
            <div class="card weather-card text-center mx-auto" style="max-width: 450px;">
                <div class="card-body d-flex flex-column">
                    <h2 class="card-title mb-3">{{ $weatherData['name'] }}</h2>
                    @if (isset($weatherData['weather'][0]['icon']))
                        <img src="http://openweathermap.org/img/wn/{{ $weatherData['weather'][0]['icon'] }}@2x.png" alt="Icono del clima" class="mx-auto d-block weather-icon">
                    @endif
                    <p class="card-text">
                        <span class="fw-bold">Temperatura:</span> {{ round($weatherData['main']['temp']) }}°C
                    </p>
                    <p class="card-text">
                        <span class="fw-bold">Sensación térmica:</span> {{ round($weatherData['main']['feels_like']) }}°C
                    </p>
                    <p class="card-text">
                        <span class="fw-bold">Humedad:</span> {{ $weatherData['main']['humidity'] }}%
                    </p>
                    <p class="card-text h4 mt-3 mb-3">
                        {{ ucfirst($weatherData['weather'][0]['description']) }}
                    </p>
                    <p class="card-text small mt-auto">
                        Última actualización: {{ date('d/m/Y H:i', $weatherData['dt']) }}
                    </p>
                </div>
            </div>
        @elseif ($request->isMethod('post') && empty($errors))
            {{-- Mensaje si se consultó pero no se encontraron datos (ej. ciudad inválida) --}}
            <div class="alert alert-warning text-center mt-4" role="alert">
                No se encontraron datos para la ciudad consultada. Por favor, verifica el nombre.
            </div>
        @else
            {{-- Mensaje inicial al cargar la página por primera vez --}}
            <div class="alert alert-info text-center mt-4" role="alert">
                Ingresa el nombre de una ciudad y presiona "Consultar Ciudad".
            </div>
        @endif
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" xintegrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
