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

        .absences-card {
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

        .absences-table {
            width: 100%;
            border-radius: 20px;
            overflow: hidden;
        }

        .absences-table thead {
            background-color: #fce7f3;
        }

        .absences-table thead th {
            color: #9d174d;
            font-weight: 700;
            padding: 1.5rem;
        }

        .absences-table tbody td {
            padding: 1.4rem 1.5rem;
            vertical-align: middle;
        }

        .absences-table tbody tr:nth-of-type(odd) {
            background-color: #fdf2f8;
        }

        .absences-table tbody tr:hover {
            background-color: #fbcfe8;
        }

        .download-link {
            background-color: #fbcfe8;
            color: #9d174d;
            padding: 0.5rem 1rem;
            border-radius: 12px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.2s ease;
        }

        .download-link:hover {
            background-color: #f9a8d4;
            color: #831843;
        }

        .no-file {
            color: #9ca3af;
            font-style: italic;
        }
    </style>

    <div class="full-page">
        <div class="absences-card">

            <h1 class="page-title">
                Ausencias
            </h1>

            <table class="absences-table table table-striped">
                <thead>
                    <tr>
                        <th>Alumno</th>
                        <th>Fecha</th>
                        <th>Motivo</th>
                        <th>Justificante</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($absences as $absence)
                        <tr>
                            <td class="fw-semibold">
                                {{ $absence->user->name }}
                            </td>
                            <td>
                                {{ $absence->date }}
                            </td>
                            <td>
                                {{ $absence->reason }}
                            </td>
                            <td>
                                @if($absence->file_path)
                                    <a href="{{ asset('storage/' . $absence->file_path) }}"
                                       class="download-link"
                                       target="_blank">
                                        Descargar
                                    </a>
                                @else
                                    <span class="no-file">
                                        Sin archivo
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted py-4">
                                No hay ausencias registradas
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

        </div>
    </div>

</x-app-layout>
