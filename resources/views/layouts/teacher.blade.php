<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel administrador</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-gradient-to-br from-purple-50 via-fuchsia-50 to-pink-50">

<div class="flex min-h-screen">

    <!-- SIDEBAR -->
    <aside class="w-64 bg-gradient-to-b from-purple-700 to-purple-900 text-white shadow-xl">
        <div class="p-6 text-2xl font-bold border-b border-purple-500/40">
            Coworking
            <p class="text-sm text-purple-200 font-normal">
                Panel administrador
            </p>
        </div>

        <nav class="p-4 space-y-2 text-sm">
            <a href="{{ route('teacher.dashboard') }}"
               class="block px-4 py-3 rounded-xl hover:bg-purple-600 transition">
                Registrar alumno
            </a>

            <a href="{{ route('teacher.students.index') }}"
               class="block px-4 py-3 rounded-xl hover:bg-purple-600 transition">
                Gestión alumnos
            </a>

            <a href="{{ route('teacher.attendance.index') }}"
                class="block px-4 py-3 rounded-xl hover:bg-purple-600 transition">
                Asistencia
            </a>

            <a href="{{ route('teacher.absences.index') }}"
               class="block px-4 py-3 rounded-xl hover:bg-purple-600 transition">
                Ausencias
            </a>
        </nav>

        <div class="p-4 border-t border-purple-500/40">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button
                    class="w-full text-left px-4 py-3 rounded-xl hover:bg-purple-600 transition">
                    Cerrar sesión
                </button>
            </form>
        </div>
    </aside>

    <!-- CONTENIDO -->
    <main class="flex-1 p-10">
        {{ $slot }}
    </main>

</div>

</body>
</html>
