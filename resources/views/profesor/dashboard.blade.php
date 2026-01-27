<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profesor - Fitxategi</title>
    @vite('resources/css/app.css')
</head>

<body class="min-h-screen bg-slate-950 text-white flex items-center justify-center px-6">
    <div class="w-full max-w-md bg-white/5 border border-white/10 rounded-2xl p-6 text-center">
        <h1 class="text-2xl font-bold mb-6">Panel Profesor</h1>

        <div class="space-y-3">
            <a href="{{ route('profesor.qr') }}"
               class="block w-full bg-indigo-600 hover:bg-indigo-700 rounded-xl py-3 font-semibold transition">
                Generar QR (dinámico)
            </a>

            <a href="{{ route('profesor.alumnos') }}"
               class="block w-full bg-white/10 hover:bg-white/15 rounded-xl py-3 font-semibold border border-white/10 transition">
                Gestionar alumnos
            </a>

            <a href="{{ route('profesor.fichajes.hoy') }}"
               class="block w-full bg-white/10 hover:bg-white/15 rounded-xl py-3 font-semibold border border-white/10 transition">
                Ver fichajes de hoy
            </a>

            <a href="{{ route('logout') }}" class="block pt-4 text-white/70 underline">
                Cerrar sesión
            </a>
        </div>
    </div>
</body>
</html>
