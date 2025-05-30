<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <title>Estado del Clima</title>
    <!-- Bootstrap 5 CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body>
    <div class="container my-5">
        <h1 class="mb-4">Clima Actual de 5 Ciudades</h1>
        <table class="table table-striped table-bordered table-hover align-middle">
            <thead class="table-dark">
                <tr>
                    <th>Ciudad</th>
                    <th>Temperatura (°C)</th>
                    <th>Sensación Térmica (°C)</th>
                    <th>Humedad (%)</th>
                    <th>Descripción</th>
                    <th>Estado</th>
                </tr>
            </thead>
            <tbody>
                @foreach($weatherData as $weather)
                    <tr>
                        <td>{{ $weather['city'] }}</td>
                        @if(isset($weather['error']))
                            <td colspan="4" class="text-danger">{{ $weather['error'] }}</td>
                            <td><span class="badge bg-danger">Error</span></td>
                        @else
                            <td>{{ $weather['temperature'] }}</td>
                            <td>{{ $weather['feels_like'] }}</td>
                            <td>{{ $weather['humidity'] }}</td>
                            <td>{{ ucfirst($weather['description']) }}</td>
                            <td><span class="badge bg-success">OK</span></td>
                        @endif
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Bootstrap 5 JS Bundle CDN (con Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
