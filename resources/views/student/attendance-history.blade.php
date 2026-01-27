<x-app-layout>
    <h1 class="text-2xl font-bold mb-4">Historial de asistencia</h1>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>Fecha</th>
                <th>Entrada</th>
                <th>Salida</th>
                <th>Horas</th>
            </tr>
        </thead>
        <tbody>
            @foreach($attendances as $attendance)
                <tr>
                    <td>{{ $attendance->date }}</td>
                    <td>{{ $attendance->entry_time ?? '-' }}</td>
                    <td>{{ $attendance->exit_time ?? '-' }}</td>
                    <td>{{ $attendance->total_hours ?? '-' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</x-app-layout>
