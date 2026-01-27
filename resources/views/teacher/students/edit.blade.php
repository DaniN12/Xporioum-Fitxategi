<x-app-layout>

    <style>
        body {
            background: linear-gradient(135deg, #fdf2f8, #fce7f3);
        }

        .full-page {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 3rem 2rem;
        }

        .student-card {
            width: 100%;
            max-width: 900px;
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

        .student-title {
            font-size: 2.1rem;
            font-weight: 800;
            color: #be185d;
            text-align: center;
            margin-bottom: 3rem;
        }

        .form-wrapper {
            max-width: 760px;
            margin: 0 auto;
        }

        .form-group {
            margin-bottom: 2rem;
        }

        .form-label {
            font-weight: 600;
            color: #9d174d;
            margin-bottom: 0.75rem;
            display: block;
        }

        .form-control {
            border-radius: 16px;
            padding: 0.95rem 1.15rem;
            border: 1px solid #f9a8d4;
        }

        .form-control:focus {
            border-color: #ec4899;
            box-shadow: 0 0 0 0.25rem rgba(236, 72, 153, 0.25);
        }

        .btn-pink {
            background: linear-gradient(135deg, #ec4899, #f472b6);
            border: none;
            color: white;
            font-weight: 700;
            border-radius: 18px;
            padding: 1rem;
            font-size: 1.05rem;
            width: 100%;
            transition: all 0.3s ease;
        }

        .btn-pink:hover {
            background: linear-gradient(135deg, #db2777, #ec4899);
            transform: translateY(-3px);
            box-shadow: 0 14px 30px rgba(236, 72, 153, 0.45);
        }

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
                ✏️ Editar alumno
            </h1>

            <form method="POST" action="{{ route('teacher.students.update', $student) }}">
                @csrf
                @method('PUT')

                <div class="form-wrapper">

                    <div class="row g-5">

                        <!-- Nombre -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Nombre completo</label>
                                <input
                                    name="name"
                                    value="{{ $student->name }}"
                                    class="form-control"
                                    required
                                >
                            </div>
                        </div>

                        <!-- Email -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Email</label>
                                <input
                                    name="email"
                                    type="email"
                                    value="{{ $student->email }}"
                                    class="form-control"
                                    required
                                >
                            </div>
                        </div>

                        <!-- DNI -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">DNI</label>
                                <input
                                    name="dni"
                                    value="{{ $student->dni }}"
                                    class="form-control"
                                    required
                                >
                            </div>
                        </div>

                        <!-- Botón -->
                        <div class="col-12 mt-3">
                            <button class="btn btn-pink">
                                Actualizar alumno
                            </button>
                        </div>

                    </div>

                </div>
            </form>

            <div class="text-center mt-4">
                <a href="{{ route('teacher.students.index') }}" class="btn btn-outline-pink">
                    ← Volver al listado
                </a>
            </div>

        </div>

    </div>

</x-app-layout>
