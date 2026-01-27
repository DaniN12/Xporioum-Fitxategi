<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profesor - Alumnos</title>
    @vite('resources/css/app.css')
</head>
<body class="min-h-screen bg-slate-950 text-white px-6 py-10">
    <div class="max-w-5xl mx-auto">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold">Alumnos</h1>
            <a href="{{ route('profesor.dashboard') }}" class="text-white/70 underline">Volver</a>
        </div>

        @if(session('success'))
            <div class="mb-4 bg-green-600/20 border border-green-500/30 text-green-200 px-4 py-2 rounded-xl">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="mb-4 bg-red-600/20 border border-red-500/30 text-red-200 px-4 py-2 rounded-xl">
                {{ session('error') }}
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div class="bg-white/5 border border-white/10 rounded-2xl p-6">
                <h2 class="text-lg font-semibold mb-4">Dar de alta alumno</h2>

                <form action="{{ route('profesor.alumnos.crear') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block mb-1 text-sm text-white/70">Nombre</label>
                        <input name="nombre" class="w-full rounded-xl bg-black/30 border border-white/10 px-4 py-2" required>
                    </div>
                    <div>
                        <label class="block mb-1 text-sm text-white/70">DNI</label>
                        <input name="dni" class="w-full rounded-xl bg-black/30 border border-white/10 px-4 py-2" required>
                    </div>
                    <div>
                        <label class="block mb-1 text-sm text-white/70">Email</label>
                        <input type="email" name="email" class="w-full rounded-xl bg-black/30 border border-white/10 px-4 py-2" required>
                    </div>
                    <div>
                        <label class="block mb-1 text-sm text-white/70">Contraseña</label>
                        <input type="password" name="contrasena" class="w-full rounded-xl bg-black/30 border border-white/10 px-4 py-2" required>
                    </div>

                    <button class="w-full bg-indigo-600 hover:bg-indigo-700 rounded-xl py-3 font-semibold">
                        Crear alumno
                    </button>
                </form>
            </div>

            <div class="bg-white/5 border border-white/10 rounded-2xl p-6">
                <h2 class="text-lg font-semibold mb-4">Listado</h2>
                <div class="space-y-3">
                    @foreach($alumnos as $a)
                        <div class="rounded-xl bg-black/20 border border-white/10 p-4">
                            <div class="font-semibold">{{ $a->nombre ?? 'Alumno' }}</div>
                            <div class="text-sm text-white/70">{{ $a->email }}</div>
                            <div class="text-sm text-white/50">DNI: {{ $a->dni }}</div>
                        </div>
                    @endforeach
                    @if(count($alumnos) === 0)
                        <div class="text-white/60">No hay alumnos aún.</div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</body>
</html>
