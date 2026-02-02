<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fitxategi</title>
    @vite('resources/css/app.css')

    {{-- Bootstrap Icons --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
</head>

<body class="min-h-screen bg-gray-100 text-gray-900">

<div x-data="{ openCuenta: {{ request()->routeIs('cuenta.*') ? 'true' : 'false' }} }" class="min-h-screen md:flex">

    {{-- ================= SIDEBAR DESKTOP ================= --}}
    <aside class="w-64 bg-white border-r px-6 py-8 hidden md:block">

        <div class="flex flex-col items-center mb-10">
            <img src="{{ asset('img/logo-fitxategi.png') }}" class="w-20" alt="Logo">
        </div>

        <nav class="space-y-2 text-gray-600 text-[15px]">

            {{-- INICIO --}}
            <a href="{{ route('fichar.vista') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('fichar.vista') ? 'bg-indigo-50 text-indigo-600 font-semibold' : 'hover:bg-gray-100' }}">
                <i class="bi bi-house"></i> Inicio
            </a>

            {{-- PERFIL DESPLEGABLE --}}
            <button @click="openCuenta = !openCuenta"
                class="w-full flex items-center justify-between px-4 py-3 rounded-xl
                       {{ request()->routeIs('cuenta.*') ? 'bg-indigo-50 text-indigo-600 font-semibold' : 'hover:bg-gray-100' }}">

                <span class="flex items-center gap-3">
                    <i class="bi bi-person"></i> Perfil
                </span>

                <span class="inline-flex items-center justify-center w-7 h-7 rounded-lg bg-white border shadow-sm">
                    <i class="bi transition-transform duration-200"
                       :class="openCuenta ? 'bi-chevron-up' : 'bi-chevron-down'"></i>
                </span>
            </button>

            {{-- SUBMENÚ PERFIL --}}
            <div x-show="openCuenta" x-transition class="ml-6 space-y-1 text-sm text-gray-600">
                <a href="{{ route('cuenta.datos') }}"
                   class="block px-3 py-2 rounded-lg hover:bg-gray-100 {{ request()->routeIs('cuenta.datos') ? 'text-indigo-600 font-semibold' : '' }}">
                    Datos personales
                </a>
                <a href="{{ route('cuenta.documentos') }}"
                   class="block px-3 py-2 rounded-lg hover:bg-gray-100 {{ request()->routeIs('cuenta.documentos') ? 'text-indigo-600 font-semibold' : '' }}">
                    Mis documentos
                </a>
                <a href="{{ route('cuenta.notificaciones') }}"
                   class="block px-3 py-2 rounded-lg hover:bg-gray-100 {{ request()->routeIs('cuenta.notificaciones') ? 'text-indigo-600 font-semibold' : '' }}">
                    Notificaciones
                </a>
                <a href="{{ route('cuenta.password') }}"
                   class="block px-3 py-2 rounded-lg hover:bg-gray-100 {{ request()->routeIs('cuenta.password') ? 'text-indigo-600 font-semibold' : '' }}">
                    Mi contraseña
                </a>
            </div>

            {{-- HORAS --}}
            <a href="{{ route('horas.index') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('horas.*') ? 'bg-indigo-50 text-indigo-600 font-semibold' : 'hover:bg-gray-100' }}">
                <i class="bi bi-clock"></i> Horas
            </a>

            {{-- INCIDENCIAS --}}
            <a href="{{ route('incidencias.create') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('incidencias.*') ? 'bg-indigo-50 text-indigo-600 font-semibold' : 'hover:bg-gray-100' }}">
                <i class="bi bi-exclamation-triangle"></i> Incidencias
            </a>

            {{-- NORMAS --}}
            <a href="{{ route('normas') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('normas') ? 'bg-indigo-50 text-indigo-600 font-semibold' : 'hover:bg-gray-100' }}">
                <i class="bi bi-file-earmark-text"></i> Normas
            </a>

            {{-- LOGOUT --}}
            <form method="POST" action="{{ route('logout') }}" class="pt-6">
                @csrf
                <button type="submit"
                        class="w-full flex items-center gap-3 px-4 py-3 rounded-xl border text-gray-600 hover:bg-gray-50">
                    <i class="bi bi-box-arrow-right"></i> Cerrar sesión
                </button>
            </form>

        </nav>
    </aside>


    {{-- ================= CONTENIDO PRINCIPAL ================= --}}
    <main class="flex-1 px-6 md:px-12 py-10">
        @yield('content')
    </main>

</div>


{{-- ================= NAV MÓVIL ================= --}}
<div class="md:hidden fixed bottom-0 left-0 w-full bg-white border-t shadow-inner flex justify-around py-2 text-xs">

    <a href="{{ route('fichar.vista') }}" class="flex flex-col items-center text-indigo-600">
        <i class="bi bi-house text-lg"></i>
        Inicio
    </a>

    <a href="{{ route('horas.index') }}" class="flex flex-col items-center text-gray-600">
        <i class="bi bi-clock text-lg"></i>
        Horas
    </a>

    <a href="{{ route('cuenta.index') }}" class="flex flex-col items-center text-gray-600">
        <i class="bi bi-person text-lg"></i>
        Perfil
    </a>

    <a href="{{ route('normas') }}" class="flex flex-col items-center text-gray-600">
        <i class="bi bi-file-earmark-text text-lg"></i>
        Normas
    </a>

    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button class="flex flex-col items-center text-red-600">
            <i class="bi bi-box-arrow-right text-lg"></i>
            Salir
        </button>
    </form>

</div>

{{-- AlpineJS para el desplegable --}}
<script src="//unpkg.com/alpinejs" defer></script>

</body>
</html>
