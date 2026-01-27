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

        .students-card {
            width: 100%;
            max-width: 1200px;
            background: #ffffff;
            border-radius: 26px;
            padding: 3.5rem;
            box-shadow: 0 25px 50px rgba(236, 72, 153, 0.18);
            animation: fadeIn 0.5s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .page-title {
            font-size: 2.2rem;
            font-weight: 800;
            color: #be185d;
            margin-bottom: 2.5rem;
            text-align: center;
        }

        .btn-pink {
            background: linear-gradient(135deg, #ec4899, #f472b6);
            border: none;
            color: #fff;
            font-weight: 700;
            border-radius: 18px;
            padding: 0.85rem 1.8rem;
            transition: all 0.3s ease;
        }

        .btn-pink:hover {
            background: linear-gradient(135deg, #db2777, #ec4899);
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(236, 72, 153, 0.4);
        }

        /* TABLA GRANDE */
        .students-table {
            width: 100%;
            margin-top: 2.5rem;
            border-radius: 20px;
            overflow: hidden;
        }

        .students-table thead {
            background-color: #fce7f3;
        }

        .students-table thead th {
            color: #9d174d;
            font-weight: 700;
            padding: 1.5rem;
            border-bottom: none;
        }

        .students-table tbody td {
            padding: 1.4rem 1.5rem;
            vertical-align: middle;
        }

        .students-table tbody tr:nth-of-type(odd) {
            background-color: #fdf2f8;
        }

        .students-table tbody tr:hover {
            background-color: #fbcfe8;
        }

        .btn-edit {
            background-color: #fbcfe8;
            color: #9d174d;
            border: none;
            font-weight: 600;
            border-radius: 12px;
        }

        .btn-edit:hover {
            background-color: #f9a8d4;
            color: #831843;
        }

        .btn-delete {
            background-color: #fecdd3;
            color: #9f1239;
            border: none;
            font-weight: 600;
            border-radius: 12px;
        }

        .btn-delete:hover {
            background-color: #fda4af;
            color: #881337;
        }

        .actions {
            display: flex;
            gap: 0.6rem;
        }

        @media (max-width: 768px) {
            .students-card {
                padding: 2.5rem 2rem;
            }

            .page-title {
                font-size: 1.8rem;
            }
        }
    </style>

    <div class="full-page">

        <div class="students-card">

            <h1 class="page-title">
                Alumnos
            </h1>

            <div class="d-flex justify-content-center mb-4">
                <a href="{{ route('teacher.students.create') }}" class="btn btn-pink">
                    + Nuevo alumno
                </a>
            </div>

            <table class="students-table table table-striped">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Email</th>
                        <th>DNI</th>
                        <th style="width: 200px;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($students as $student)
                        <tr>
                            <td class="fw-semibold">{{ $student->name }}</td>
                            <td>{{ $student->email }}</td>
                            <td>{{ $student->dni }}</td>
                            <td>
                                <div class="actions">
                                    <a href="{{ route('teacher.students.edit', $student) }}"
                                       class="btn btn-edit btn-sm">
                                        Editar
                                    </a>

                                    <form method="POST"
                                          action="{{ route('teacher.students.destroy', $student) }}"
                                          onsubmit="return confirm('¿Eliminar este alumno?')">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-delete btn-sm">
                                            Eliminar
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

        </div>

    </div>

</x-app-layout>
