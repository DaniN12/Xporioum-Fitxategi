<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Panel profesor' }}</title>

    {{-- Tailwind por Vite --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Bootstrap Icons --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>

<body class="min-h-screen bg-slate-50 text-slate-900">

<div class="min-h-screen flex">

    {{-- =========================
        SIDEBAR (DESKTOP)
    ========================= --}}
    <aside class="hidden md:flex md:w-72 md:flex-col bg-white border-r border-slate-200">

        {{-- Brand --}}
        <div class="px-6 py-6 border-b border-slate-200">
            <div class="flex items-center gap-3">
                <img src="{{ asset('img/logo-fitxategi.png') }}" class="w-10 h-10" alt="Logo">
                <div>
                    <div class="font-extrabold text-lg leading-5">Profesor</div>
                    <div class="text-xs text-slate-500">Panel de gestión</div>
                </div>
            </div>
        </div>

        {{-- Menu --}}
        <nav class="p-4 space-y-2 text-slate-700">

            <a href="{{ route('teacher.dashboard') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-xl transition
               {{ request()->routeIs('teacher.dashboard') ? 'bg-indigo-50 text-indigo-700 font-extrabold' : 'hover:bg-slate-50' }}">
                <i class="bi bi-person-plus"></i>
                <span>Registrar alumno</span>
            </a>

            <a href="{{ route('teacher.students.index') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-xl transition
               {{ request()->routeIs('teacher.students.*') ? 'bg-indigo-50 text-indigo-700 font-extrabold' : 'hover:bg-slate-50' }}">
                <i class="bi bi-people"></i>
                <span>Gestión alumnos</span>
            </a>

            <a href="{{ route('teacher.attendance.index') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-xl transition
               {{ request()->routeIs('teacher.attendance.*') ? 'bg-indigo-50 text-indigo-700 font-extrabold' : 'hover:bg-slate-50' }}">
                <i class="bi bi-check2-square"></i>
                <span>Asistencia</span>
            </a>

            <a href="{{ route('teacher.absences.index') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-xl transition
               {{ request()->routeIs('teacher.absences.*') ? 'bg-indigo-50 text-indigo-700 font-extrabold' : 'hover:bg-slate-50' }}">
                <i class="bi bi-calendar2-x"></i>
                <span>Ausencias</span>
            </a>

            <a href="{{ route('teacher.qr') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-xl transition
               {{ request()->routeIs('teacher.qr*') ? 'bg-indigo-50 text-indigo-700 font-extrabold' : 'hover:bg-slate-50' }}">
                <i class="bi bi-qr-code"></i>
                <span>Generar QR</span>
            </a>

            <form method="POST" action="{{ route('logout') }}" class="pt-4">
                @csrf
                <button type="submit"
                        class="w-full flex items-center gap-3 px-4 py-3 rounded-xl border border-slate-200
                               text-red-600 font-extrabold hover:bg-red-50 transition">
                    <i class="bi bi-box-arrow-right"></i>
                    <span>Cerrar sesión</span>
                </button>
            </form>

        </nav>

        <div class="mt-auto p-4 border-t border-slate-200 text-xs text-slate-500">
            {{ auth()->user()->email ?? '' }}
        </div>
    </aside>

    {{-- =========================
        MAIN
    ========================= --}}
    <div class="flex-1 min-w-0">

        {{-- TOPBAR --}}
        <header class="bg-white border-b border-slate-200">
            <div class="px-4 md:px-8 py-4 flex items-center justify-between">

                <div>
                    <div class="font-extrabold text-lg">{{ $title ?? 'Panel profesor' }}</div>
                    <div class="text-xs text-slate-500 hidden sm:block">
                        Gestiona alumnos, asistencia, ausencias y QR.
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    <div class="text-right">
                        <div class="text-sm font-extrabold">{{ auth()->user()->name ?? 'Profesor' }}</div>
                        <div class="text-xs text-slate-500 hidden sm:block">{{ auth()->user()->email ?? '' }}</div>
                    </div>
                </div>

            </div>
        </header>

        {{-- CONTENT (en móvil dejamos hueco para la bottom nav) --}}
        <main class="p-4 md:p-8 pb-24 md:pb-8">
            <div class="w-full max-w-6xl mx-auto">
                @yield('content')
            </div>
        </main>
    </div>
</div>

{{-- =========================
    BOTTOM NAV (MÓVIL)
========================= --}}
<nav class="md:hidden fixed bottom-0 left-0 w-full bg-white border-t border-slate-200 shadow-[0_-10px_30px_-20px_rgba(0,0,0,0.35)] z-50">
    <div class="max-w-md mx-auto px-4 py-2 flex items-center justify-between">

        <a href="{{ route('teacher.dashboard') }}"
           class="flex flex-col items-center gap-1 px-3 py-2 rounded-xl transition
           {{ request()->routeIs('teacher.dashboard') ? 'text-indigo-600 font-extrabold bg-indigo-50' : 'text-slate-600' }}">
            <i class="bi bi-person-plus text-xl"></i>
            <span class="text-[11px]">Crear</span>
        </a>

        <a href="{{ route('teacher.students.index') }}"
           class="flex flex-col items-center gap-1 px-3 py-2 rounded-xl transition
           {{ request()->routeIs('teacher.students.*') ? 'text-indigo-600 font-extrabold bg-indigo-50' : 'text-slate-600' }}">
            <i class="bi bi-people text-xl"></i>
            <span class="text-[11px]">Alumnos</span>
        </a>

        <a href="{{ route('teacher.attendance.index') }}"
           class="flex flex-col items-center gap-1 px-3 py-2 rounded-xl transition
           {{ request()->routeIs('teacher.attendance.*') ? 'text-indigo-600 font-extrabold bg-indigo-50' : 'text-slate-600' }}">
            <i class="bi bi-check2-square text-xl"></i>
            <span class="text-[11px]">Asistencia</span>
        </a>

        <a href="{{ route('teacher.qr') }}"
           class="flex flex-col items-center gap-1 px-3 py-2 rounded-xl transition
           {{ request()->routeIs('teacher.qr*') ? 'text-indigo-600 font-extrabold bg-indigo-50' : 'text-slate-600' }}">
            <i class="bi bi-qr-code text-xl"></i>
            <span class="text-[11px]">QR</span>
        </a>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit"
                    class="flex flex-col items-center gap-1 px-3 py-2 rounded-xl transition text-red-600">
                <i class="bi bi-box-arrow-right text-xl"></i>
                <span class="text-[11px]">Salir</span>
            </button>
        </form>

    </div>
</nav>

</body>
</html>
