<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mis horas</title>
</head>
<body>

<h1>Mis horas</h1>

<form method="POST" action="{{ route('logout') }}" style="margin-bottom: 20px;">
    @csrf
    <button type="submit">Cerrar sesión</button>
</form>

@if($fichajes->isEmpty())
    <p>No tienes fichajes registrados todavía.</p>
@else
    <table border="1" cellpadding="8">
        <thead>
            <tr>
                <th>Fecha</th>
                <th>Hora de entrada</th>
                <th>Hora de salida</th>
                <th>Total de horas</th>
            </tr>
        </thead>
        <tbody>
            @foreach($fichajes as $fichaje)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($fichaje->fecha)->format('d/m/Y') }}</td>
                    <td>{{ $fichaje->hora_entrada }}</td>
                    <td>{{ $fichaje->hora_salida ?? '—' }}</td>
                    <td>{{ $fichaje->total_horas ?? '—' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endif

</body>
</html>
