<x-app-layout>

    <style>
        body {
            background: linear-gradient(135deg, #fdf2f8, #fce7f3);
        }

        .full-page {
            min-height: 100vh;
            display: flex;
            justify-content: center;
            padding: 3rem 2rem;
        }

        .attendance-card {
            width: 100%;
            max-width: 1200px;
            background: #ffffff;
            border-radius: 26px;
            padding: 3.5rem;
            box-shadow: 0 25px 50px rgba(236, 72, 153, 0.18);
        }

        .page-title {
            font-size: 2.2rem;
            font-weight: 800;
            color: #be185d;
            margin-bottom: 2.5rem;
            text-align: center;
        }

        .filter-bar {
            display: flex;
            justify-content: center;
            margin-bottom: 2.5rem;
        }

        .filter-select {
            max-width: 350px;
            border-radius: 14px;
            padding: 0.7rem 1rem;
            border: 2px solid #f9a8d4;
            font-weight: 600;
            color: #9d174d;
        }

        .attendance-table {
            width: 100%;
            border-radius: 20px;
            overflow: hidden;
        }

        .attendance-table thead {
            background-color: #fce7f3;
        }

        .attendance-table thead th {
            color: #9d174d;
            font-weight: 700;
            padding: 1.5rem;
        }

        .attendance-table tbody td {
            padding: 1.4rem 1.5rem;
        }

        .attendance-table tbody tr:nth-of-type(odd) {
            background-color: #fdf2f8;
        }

        .attendance-table tbody tr:hover {
            background-color: #fbcfe8;
        }

        .entry {
            color: #16a34a;
            font-weight: 600;
        }

        .exit {
            color: #dc2626;
            font-weight: 600;
        }
    </style>

    <div class="full-page">
        <div class="attendance-card">

            <h1 class="page-title">
                Asistencia del alumnado
            </h1>

            <!-- FILTRO -->
            <form method="GET"
                  action="{{ route('teacher.attendance.index') }}"
                  class="filter-bar">

                <select name="student_id"
                        class="form-select filter-select"
                        onchange="this.form.submit()">

                    <option value="">— Todos los alumnos —</option>

                    @foreach($students as $student)
                        <option value="{{ $student->id }}"
                            {{ $studentId == $student->id ? 'selected' : '' }}>
                            {{ $student->name }}
                        </option>
                    @endforeach
                </select>

            </form>

            <!-- TABLA -->
            <table class="attendance-table table table-striped">
                <thead>
                    <tr>
                        <th>Alumno</th>
                        <th>Fecha</th>
                        <th>Entrada</th>
                        <th>Salida</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($attendances as $attendance)
                        <tr>
                            <td class="fw-semibold">
                                {{ $attendance->user->name }}
                            </td>
                            <td>{{ $attendance->date }}</td>
                            <td class="entry">{{ $attendance->entry_time }}</td>
                            <td class="exit">{{ $attendance->exit_time ?? '—' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted py-4">
                                No hay registros de asistencia
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

        </div>
    </div>

</x-app-layout>
