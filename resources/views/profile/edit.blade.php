<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fitxategi - {{ __('messages.perfil') }}</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        .diagonal-pattern {
            background-image: repeating-linear-gradient(
                135deg,
                rgba(255,255,255,.35) 0 2px,
                transparent 2px 32px
            );
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in {
            animation: fadeIn 0.5s ease-out forwards;
        }
    </style>
</head>

<body class="min-h-screen bg-slate-100">

<!-- Fondo -->
<div class="fixed inset-0 -z-10 bg-[#7f95ff]">
    <div class="absolute inset-0 opacity-20 diagonal-pattern"></div>
</div>

<div class="min-h-screen flex items-center justify-center p-4">
<div class="w-full max-w-5xl">

<div class="overflow-hidden rounded-[28px] bg-white shadow-2xl ring-1 ring-black/10">

<!-- ================= HEADER ================= -->
<header class="h-14 bg-gradient-to-r from-gray-900 to-black text-white flex items-center justify-between px-4">

    <!-- Logo -->
    <div class="flex items-center gap-3">
        <div class="h-9 w-9 bg-gradient-to-br from-purple-400 to-pink-400 rounded-full flex items-center justify-center text-xl shadow-lg">
            🐰
        </div>
        <div class="hidden sm:block">
            <div class="font-bold text-sm">Fitxategi</div>
            <div class="text-xs text-gray-400">Control horario</div>
        </div>
    </div>

    <!-- Idiomas + logout -->
    <div class="flex items-center gap-4">

        <!-- Idiomas -->
        <div class="flex items-center gap-2 text-sm font-bold">
            <a href="{{ route('idioma.cambiar', 'es') }}"
               class="px-2 py-1 rounded {{ app()->getLocale() === 'es' ? 'bg-white text-black' : 'text-white/70 hover:text-white' }}">
                ES
            </a>

            <a href="{{ route('idioma.cambiar', 'eu') }}"
               class="px-2 py-1 rounded {{ app()->getLocale() === 'eu' ? 'bg-white text-black' : 'text-white/70 hover:text-white' }}">
                EU
            </a>
        </div>

        <!-- Logout -->
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="h-8 w-8 rounded-full bg-white/10 hover:bg-white/20 transition flex items-center justify-center">
                🚪
            </button>
        </form>

    </div>
</header>

<!-- ================= NAV ================= -->
<nav class="fixed bottom-0 left-0 right-0 md:static bg-white md:bg-gradient-to-r md:from-[#d7a6ff] md:to-[#e5b8ff] border-t md:border-0 shadow-lg md:shadow-none z-50">
    <div class="grid grid-cols-3 md:flex md:justify-center md:gap-10 text-xs md:text-base font-semibold">

        <a href="{{ route('profile.edit') }}" class="py-3 flex flex-col md:flex-row items-center gap-1 text-purple-600 font-bold">
            👤 {{ __('messages.perfil') }}
        </a>

        <a href="{{ route('horas') }}" class="py-3 flex flex-col md:flex-row items-center gap-1">
            📊 {{ __('messages.horas') }}
        </a>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="py-3 flex flex-col md:flex-row items-center gap-1">
                🚪 {{ __('messages.salir') }}
            </button>
        </form>

    </div>
</nav>

<!-- ================= CONTENIDO ================= -->
<main class="bg-[#f2dcff] p-6 md:p-10 min-h-[520px] pb-24 md:pb-0">
<div class="max-w-4xl mx-auto space-y-6 animate-fade-in">

<!-- CABECERA PERFIL -->
<div class="bg-gradient-to-br from-purple-500 to-purple-700 rounded-2xl p-6 text-white">
    <div class="flex items-center gap-6">
        <div class="w-20 h-20 bg-white text-purple-700 rounded-full flex items-center justify-center text-4xl font-bold">
            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
        </div>
        <div>
            <h1 class="text-2xl font-bold">{{ Auth::user()->name }}</h1>
            <p class="opacity-90">{{ Auth::user()->email }}</p>
        </div>
    </div>
</div>

<!-- FORMULARIO PERFIL -->
<div class="bg-white rounded-2xl shadow-md p-6">
    @include('profile.partials.update-profile-information-form')
</div>

<!-- FORMULARIO PASSWORD -->
<div class="bg-white rounded-2xl shadow-md p-6">
    @include('profile.partials.update-password-form')
</div>

</div>
</main>

</div>
</div>
</div>

</body>
</html>
