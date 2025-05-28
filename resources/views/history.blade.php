<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historial de Consultas del Clima</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" xintegrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(to bottom right, #6a82fb, #fc5c7d);
            min-height: 100vh;
            padding: 2rem;
            color: #333;
        }
        .container {
            background-color: rgba(255, 255, 255, 0.95);
            border-radius: 1.5rem;
            box-shadow: 0 1rem 2rem rgba(0, 0, 0, 0.25);
            padding: 2.5rem;
            margin-top: 3rem;
            margin-bottom: 3rem;
        }
        h1 {
            color: #343a40;
            font-weight: 700;
            margin-bottom: 2rem;
            text-align: center;
        }
        .table-responsive {
            margin-top: 2rem;
        }
        .table th, .table td {
            vertical-align: middle;
            padding: 0.8rem;
        }
        .table-striped tbody tr:nth-of-type(odd) {
            background-color: rgba(0, 0, 0, 0.03);
        }
        .table thead {
            background-color: #0d6efd; /* Color de encabezado de tabla */
            color: #fff;
        }
        .btn-back {
            margin-top: 2rem;
            display: block;
            width: fit-content;
            margin-left: auto;
            margin-right: auto;
        }
        .text-truncate-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 300px; /* Ajusta esto según necesites */
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Historial de Consultas del Clima</h1>

        @if ($historyRecords->isEmpty())
            <div class="alert alert-warning text-center" role="alert">
                No hay registros de historial de clima aún. ¡Consulta algunas ciudades para empezar!
            </div>
        @else
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Ciudad</th>
                            <th>Datos Climáticos (JSON)</th>
                            <th>Fecha y Hora de Consulta</th>
                            <th>Creado en</th>
                            <th>Actualizado en</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($historyRecords as $record)
                            <tr>
                                <td>{{ $record->id }}</td>
                                <td>{{ $record->city_name }}</td>
                                <td>
                                    <div class="text-truncate-2" title="{{ json_encode($record->weather_data, JSON_PRETTY_PRINT) }}">
                                        {{ json_encode($record->weather_data) }}
                                    </div>
                                </td>
                                <td>{{ $record->consulted_at->format('d/m/Y H:i:s') }}</td>
                                <td>{{ $record->created_at->format('d/m/Y H:i:s') }}</td>
                                <td>{{ $record->updated_at->format('d/m/Y H:i:s') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif

        <a href="{{ url('/weather') }}" class="btn btn-primary btn-lg btn-back">Volver a la Consulta de Clima</a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" xintegrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
