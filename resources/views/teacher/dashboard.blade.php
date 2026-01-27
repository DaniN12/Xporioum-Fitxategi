<x-app-layout>

    <style>
        /* Fondo general */
        body {
            background: linear-gradient(135deg, #fdf2f8, #fce7f3);
        }

        /* Pantalla completa */
        .full-page {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 3rem 2rem;
        }

        /* Card principal */
        .student-card {
            width: 100%;
            max-width: 1000px;
            background: #ffffff;
            border-radius: 26px;
            padding: 4rem 3.5rem;
            box-shadow: 0 25px 50px rgba(236, 72, 153, 0.18);
            animation: fadeIn 0.6s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(24px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Título */
        .student-title {
            font-size: 2.1rem;
            font-weight: 800;
            color: #be185d;
            text-align: center;
            margin-bottom: 3rem;
        }

        /* Wrapper del formulario (clave para que no se vea apretado) */
        .form-wrapper {
            max-width: 760px;
            margin: 0 auto;
        }

        /* Labels */
        .form-label {
            font-weight: 600;
            color: #9d174d;
            margin-bottom: 0.75rem;
        }

        /* Inputs */
        .form-control,
        .form-select {
            border-radius: 16px;
            padding: 0.95rem 1.15rem;
            border: 1px solid #f9a8d4;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #ec4899;
            box-shadow: 0 0 0 0.25rem rgba(236, 72, 153, 0.25);
        }

        /* Separación vertical real entre campos */
        .form-group {
            margin-bottom: 1.8rem;
        }

        /* Botón principal */
        .btn-pink {
            background: linear-gradient(135deg, #ec4899, #f472b6);
            border: none;
            color: white;
            font-weight: 700;
            border-radius: 18px;
            padding: 1rem;
            font-size: 1.05rem;
            transition: all 0.3s ease;
        }

        .btn-pink:hover {
            background: linear-gradient(135deg, #db2777, #ec4899);
            transform: translateY(-3px);
            box-shadow: 0 14px 30px rgba(236, 72, 153, 0.45);
        }

        /* Botón secundario */
        .btn-outline-pink {
            border: 2px solid #ec4899;
            color: #ec4899;
            font-weight: 600;
            border-radius: 16px;
            padding: 0.75rem 1.6rem;
        }

        .btn-outline-pink:hover {
            background-color: #ec4899;
            color: #fff;
        }

        /* Alert */
        .alert-success {
            background-color: #fce7f3;
            border-color: #f9a8d4;
            color: #9d174d;
            border-radius: 16px;
            margin-bottom: 2.5rem;
        }

        hr {
            border-top: 1px dashed #f9a8d4;
            margin: 3.5rem 0;
        }

        /* Mobile */
        @media (max-width: 768px) {
            .student-card {
                padding: 2.5rem 2rem;
            }

            .student-title {
                font-size: 1.8rem;
            }
        }
    </style>

    <div class="full-page">

        <div class="student-card">

            <h1 class="student-title">
                Registrar nuevo alumno
            </h1>

            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <form method="POST" action="{{ route('teacher.students.store') }}">
                @csrf

                <div class="form-wrapper">

                    <div class="row g-5">

                        <div class="col-md-6 form-group">
                            <label class="form-label">Nombre completo</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>

                        <div class="col-md-6 form-group">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>

                        <div class="col-md-6 form-group">
                            <label class="form-label">DNI</label>
                            <input type="text" name="dni" class="form-control" required>
                        </div>

                        <div class="col-md-6 form-group">
                            <label class="form-label">Empresa</label>
                            <select name="company_id" class="form-select">
                                <option value="">-- Selecciona empresa --</option>
                                @foreach($companies as $company)
                                    <option value="{{ $company->id }}">
                                        {{ $company->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-12 form-group">
                            <label class="form-label">Contraseña inicial</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>

                        <div class="col-12 d-grid mt-4">
                            <button class="btn btn-pink">
                                Crear alumno
                            </button>
                        </div>

                    </div>

                </div>
            </form>

            <hr>

            <div class="text-center">
                <a href="{{ route('teacher.students.index') }}" class="btn btn-outline-pink">
                    ← Gestionar alumnos
                </a>
            </div>

        </div>

    </div>

</x-app-layout>
