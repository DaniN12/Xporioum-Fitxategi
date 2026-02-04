<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fitxategi</title>
    @vite('resources/css/app.css')

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
</head>

<body class="min-h-screen bg-gray-100 text-gray-900">

@if (request()->boolean('sheet'))
    <main class="min-h-screen px-6 py-8 bg-gray-100">
        @yield('content')
    </main>

@else

<div x-data="{ openCuenta: {{ request()->routeIs('cuenta.*') ? 'true' : 'false' }} }" class="min-h-screen md:flex relative">

   <div class="absolute top-3 right-4 md:top-6 md:right-6 flex gap-2 z-50">

        <a href="{{ route('setLocale', 'es') }}">
            <img src="{{ asset('img/español.png') }}" class="w-10 hover:scale-110 transition-transform" alt="Español">
        </a>
        <a href="{{ route('setLocale', 'en') }}">
            <img src="{{ asset('img/ingles.png') }}" class="w-10 hover:scale-110 transition-transform" alt="English">
        </a>
        <a href="{{ route('setLocale', 'eu') }}">
            <img src="{{ asset('img/euskera.png') }}" class="w-10 hover:scale-110 transition-transform" alt="Euskera">
        </a>
    </div>

    <aside class="w-64 bg-white border-r px-6 py-8 hidden md:block">

        <div class="flex flex-col items-center mb-10">
            <img src="{{ asset('img/logo-fitxategi.png') }}" class="w-20" alt="Logo">
        </div>

        <nav class="space-y-2 text-gray-600 text-[15px]">

            <a href="{{ route('fichar.vista') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('fichar.vista') ? 'bg-indigo-50 text-indigo-600 font-semibold' : 'hover:bg-gray-100' }}">
                <i class="bi bi-house"></i> {{ __('message.nav_home') }}
            </a>

            <button @click="openCuenta = !openCuenta"
                class="w-full flex items-center justify-between px-4 py-3 rounded-xl
                       {{ request()->routeIs('cuenta.*') ? 'bg-indigo-50 text-indigo-600 font-semibold' : 'hover:bg-gray-100' }}">

                <span class="flex items-center gap-3">
                    <i class="bi bi-person"></i> {{ __('message.nav_profile') }}
                </span>

                <span class="inline-flex items-center justify-center w-7 h-7 rounded-lg bg-white border shadow-sm">
                    <i class="bi transition-transform duration-200"
                       :class="openCuenta ? 'bi-chevron-up' : 'bi-chevron-down'"></i>
                </span>
            </button>

            <div x-show="openCuenta" x-transition class="ml-6 space-y-1 text-sm text-gray-600">
                <a href="{{ route('cuenta.datos') }}"
                   class="block px-3 py-2 rounded-lg hover:bg-gray-100 {{ request()->routeIs('cuenta.datos') ? 'text-indigo-600 font-semibold' : '' }}">
                    {{ __('message.nav_personal_data') }}
                </a>
                <a href="{{ route('cuenta.documentos') }}"
                   class="block px-3 py-2 rounded-lg hover:bg-gray-100 {{ request()->routeIs('cuenta.documentos') ? 'text-indigo-600 font-semibold' : '' }}">
                    {{ __('message.nav_documents') }}
                </a>
                <a href="{{ route('cuenta.notificaciones') }}"
                   class="block px-3 py-2 rounded-lg hover:bg-gray-100 {{ request()->routeIs('cuenta.notificaciones') ? 'text-indigo-600 font-semibold' : '' }}">
                    {{ __('message.nav_notifications') }}
                </a>
                <a href="{{ route('cuenta.password') }}"
                   class="block px-3 py-2 rounded-lg hover:bg-gray-100 {{ request()->routeIs('cuenta.password') ? 'text-indigo-600 font-semibold' : '' }}">
                    {{ __('message.nav_password') }}
                </a>
            </div>

            <a href="{{ route('horas.index') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('horas.*') ? 'bg-indigo-50 text-indigo-600 font-semibold' : 'hover:bg-gray-100' }}">
                <i class="bi bi-clock"></i> {{ __('message.nav_hours') }}
            </a>

            <a href="{{ route('incidencias.create') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('incidencias.*') ? 'bg-indigo-50 text-indigo-600 font-semibold' : 'hover:bg-gray-100' }}">
                <i class="bi bi-exclamation-triangle"></i> {{ __('message.nav_incidents') }}
            </a>

            <a href="{{ route('normas') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('normas') ? 'bg-indigo-50 text-indigo-600 font-semibold' : 'hover:bg-gray-100' }}">
                <i class="bi bi-file-earmark-text"></i> {{ __('message.nav_rules') }}
            </a>

            <form method="POST" action="{{ route('logout') }}" class="pt-6">
                @csrf
                <button type="submit"
                        class="w-full flex items-center gap-3 px-4 py-3 rounded-xl border text-gray-600 hover:bg-gray-50">
                    <i class="bi bi-box-arrow-right"></i> {{ __('message.nav_logout') }}
                </button>
            </form>

        </nav>
    </aside>

    <main class="flex-1 px-6 md:px-12 py-10 pt-16 md:pt-10">

        @yield('content')
    </main>

</div>

@php
    $isInicio = request()->routeIs('fichar.vista');
    $isHoras  = request()->routeIs('horas.*');
    $isPerfil = request()->routeIs('cuenta.*');
    $isNormas = request()->routeIs('normas');
@endphp

<div class="md:hidden fixed bottom-0 left-0 w-full bg-white border-t shadow-inner flex justify-around py-2 text-xs">

    <a href="{{ route('fichar.vista') }}"
       class="flex flex-col items-center {{ $isInicio ? 'text-indigo-600' : 'text-gray-600' }}">
        <i class="bi bi-house text-lg"></i>
        <span class="{{ $isInicio ? 'font-semibold' : '' }}">{{ __('message.nav_home') }}</span>
    </a>

    <a href="{{ route('horas.index') }}"
       class="flex flex-col items-center {{ $isHoras ? 'text-indigo-600' : 'text-gray-600' }}">
        <i class="bi bi-clock text-lg"></i>
        <span class="{{ $isHoras ? 'font-semibold' : '' }}">{{ __('message.nav_hours') }}</span>
    </a>

    <a href="{{ route('cuenta.index') }}"
       class="flex flex-col items-center {{ $isPerfil ? 'text-indigo-600' : 'text-gray-600' }}">
        <i class="bi bi-person text-lg"></i>
        <span class="{{ $isPerfil ? 'font-semibold' : '' }}">{{ __('message.nav_profile') }}</span>
    </a>

    <a href="{{ route('normas') }}"
       class="flex flex-col items-center {{ $isNormas ? 'text-indigo-600' : 'text-gray-600' }}">
        <i class="bi bi-file-earmark-text text-lg"></i>
        <span class="{{ $isNormas ? 'font-semibold' : '' }}">{{ __('message.nav_rules') }}</span>
    </a>

    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button class="flex flex-col items-center text-red-600">
            <i class="bi bi-box-arrow-right text-lg"></i>
            <span>{{ __('message.nav_exit') }}</span>
        </button>
    </form>

</div>

<script src="//unpkg.com/alpinejs" defer></script>

@endif

</body>
</html>
