<x-app-layout>
    <div class="max-w-4xl mx-auto">
        <h1 class="text-2xl font-bold mb-4">Asistencia por alumno</h1>

        {{-- Formulario selección --}}
        <form method="GET" action="{{ route('teacher.attendance.student') }}" class="mb-4">
            <select name="student_id" class="form-select mb-2">
                <option value="">Selecciona un alumno</option>
                @foreach($students as $student)
                    <option value="{{ $student->id }}"
                        {{ request('student_id') == $student->id ? 'selected' : '' }}>
                        {{ $student->name }}
                    </option>
                @endforeach
            </select>

            <button class="btn btn-primary">
                Ver asistencia
            </button>
        </form>

        {{-- Tabla --}}
        @if($attendances->count())
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
        @else
            <p class="text-gray-500">
                Selecciona un alumno para ver su asistencia.
            </p>
        @endif
    </div>
</x-app-layout>
