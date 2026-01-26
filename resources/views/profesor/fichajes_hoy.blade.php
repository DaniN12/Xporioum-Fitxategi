<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profesor - Fichajes de hoy</title>
    @vite('resources/css/app.css')
</head>
<body class="min-h-screen bg-slate-950 text-white px-6 py-10">
    <div class="max-w-5xl mx-auto">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold">Fichajes de hoy ({{ $hoy }})</h1>
            <a href="{{ route('profesor.dashboard') }}" class="text-white/70 underline">Volver</a>
        </div>

        <div class="bg-white/5 border border-white/10 rounded-2xl overflow-hidden">
            <table class="w-full text-left">
                <thead class="bg-white/10">
                    <tr>
                        <th class="p-3">Alumno</th>
                        <th class="p-3">Email</th>
                        <th class="p-3">Entrada</th>
                        <th class="p-3">Salida</th>
                        <th class="p-3">Descanso (min)</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($fichajes as $f)
                        <tr class="border-t border-white/10">
                            <td class="p-3">{{ $f->nombre ?? 'Alumno' }}</td>
                            <td class="p-3 text-white/70">{{ $f->email }}</td>
                            <td class="p-3">{{ $f->hora_entrada ?? '-' }}</td>
                            <td class="p-3">{{ $f->hora_salida ?? '-' }}</td>
                            <td class="p-3">{{ $f->minutos_descanso ?? 0 }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td class="p-6 text-white/60" colspan="5">No hay fichajes hoy.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
