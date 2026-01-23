<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fitxategi - Incidencia</title>
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
        .nav-active {
            position: relative;
        }
        .nav-active::after {
            content: '';
            position: absolute;
            bottom: -12px;
            left: 50%;
            transform: translateX(-50%);
            width: 24px;
            height: 3px;
            background: white;
            border-radius: 2px;
        }
    </style>
</head>
<body class="min-h-screen w-screen h-screen bg-gradient-to-br from-purple-100 to-blue-100 flex flex-col">
    <div class="fixed inset-0 -z-10 bg-[#FFFFFF]">
        <div class="absolute inset-0 opacity-20 diagonal-pattern"></div>
    </div>
    <div class="flex-1 flex flex-col items-stretch justify-stretch p-0 w-full h-full">
        <div class="w-full">
            <div class="relative overflow-hidden rounded-none bg-white shadow-2xl ring-1 ring-black/10 w-full h-full min-h-screen flex flex-col">
                <!-- Header -->
                <header class="h-14 bg-gradient-to-r from-gray-900 to-black text-white flex items-center justify-between px-4">
                    <div class="flex items-center gap-3">
                                                <img src="{{ asset('images/logofitxategi.png') }}" alt="Logo Fitxategi" class="h-9 w-9 rounded-full shadow-lg object-contain bg-white">
                        <div class="hidden sm:block">
                            <div class="font-bold text-sm">Fitxategi</div>
                            <div class="text-xs text-gray-400">Control horario</div>
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="hidden sm:flex rounded-full">
                        </div>
                        <div class="flex items-center gap-2">
                            <button class="h-8 w-8 rounded-full"><img src="images/euskalherria.png"></button>
                            <button class="h-8 w-8 rounded-full"><img src="images/españa.png"></button>
                        </div>
                    </div>
                </header>
                <!-- Nav desktop -->
                <nav class="hidden md:flex items-center justify-center gap-10 bg-gradient-to-r from-[#d7a6ff] to-[#e5b8ff] py-3 font-bold text-black shadow-sm">
                    <a href="{{ url('/perfil') }}" class="{{ request()->is('perfil*') ? 'nav-active' : '' }} hover:text-purple-800 cursor-pointer transition">Perfil</a>
                    <a href="{{ route('normas.index') }}" class="{{ request()->is('normas*') ? 'nav-active' : '' }} hover:text-purple-800 cursor-pointer transition">Normas</a>
                    <a href="{{ url('/incidencias') }}" class="{{ request()->is('incidencias*') ? 'nav-active' : '' }} hover:text-purple-800 cursor-pointer transition">Incidencias</a>
                    <a href="{{ url('/fichaje') }}" class="{{ request()->is('fichaje*') ? 'nav-active' : '' }} hover:text-purple-800 cursor-pointer transition">Fichar</a>
                    <a href="{{ url('/horas') }}" class="{{ request()->is('horas*') ? 'nav-active' : '' }} hover:text-purple-800 cursor-pointer transition">Tus horas</a>
                </nav>
                <main class="bg-[#f2dcff] p-6 md:p-10 min-h-[400px]">
                    <div class="max-w-xl mx-auto space-y-6 animate-fade-in">
                        @if(session('status'))
                            <div class="bg-gradient-to-br from-green-500 to-green-700 rounded-2xl shadow-lg p-8 text-white text-center">
                                <div class="text-4xl mb-2">✅</div>
                                <div class="font-bold text-2xl mb-2">{{ session('status') }}</div>
                                <a href="{{ route('incidencias.create') }}" class="mt-6 inline-block bg-white text-green-700 font-bold py-3 px-6 rounded-xl shadow hover:bg-green-50 transition">Hacer otra incidencia</a>
                            </div>
                        @else
                            <div class="text-center mb-8">
                                <div class="text-5xl mb-3">📝</div>
                                <h1 class="text-3xl font-bold text-gray-800">Registrar incidencia</h1>
                                <p class="text-gray-600 mt-2">Rellena el formulario para justificar tu ausencia o incidencia</p>
                            </div>
                            <form action="{{ route('incidencias.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
                                @csrf
                                <div>
                                    <label class="block text-lg font-semibold text-gray-700 mb-1">Fecha</label>
                                    <input type="date" name="fecha" required class="w-full p-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-purple-400">
                                </div>
                                <div>
                                    <label class="block text-lg font-semibold text-gray-700 mb-1">Motivo</label>
                                    <textarea name="motivo" required rows="3" class="w-full p-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-purple-400"></textarea>
                                </div>
                                <div>
                                    <label class="block text-lg font-semibold text-gray-700 mb-1">Adjuntar justificante (opcional)</label>
                                    <input type="file" name="adjunto" class="w-full p-2 rounded-lg border border-gray-300">
                                </div>
                                <button type="submit" class="w-full bg-gradient-to-r from-purple-500 to-purple-700 text-white font-bold py-4 rounded-xl hover:shadow-lg transition">Registrar ahora</button>
                            </form>
                        @endif
                    </div>
                </main>
                <!-- Bottom nav móvil -->
                <nav class="md:hidden border-t bg-white shadow-lg">
                    <div class="grid grid-cols-4 text-center text-xs font-semibold">
                        <a href="{{ url('/perfil') }}" class="py-3 flex flex-col items-center gap-1 {{ request()->is('perfil*') ? 'text-purple-600 bg-purple-50 nav-active' : '' }} hover:bg-gray-50 transition">
                            <span class="text-lg">👤</span>
                            <span>Perfil</span>
                        </a>
                        <a href="{{ route('normas.index') }}" class="py-3 flex flex-col items-center gap-1 {{ request()->is('normas*') ? 'text-purple-600 bg-purple-50 nav-active' : '' }} hover:bg-gray-50 transition">
                            <span class="text-lg">📋</span>
                            <span>Normas</span>
                        </a>
                        <a href="{{ url('/incidencias') }}" class="py-3 flex flex-col items-center gap-1 {{ request()->is('incidencias*') ? 'text-purple-600 bg-purple-50 nav-active' : '' }} hover:bg-gray-50 transition">
                            <span class="text-lg">📋</span>
                            <span>Incidencias</span>
                        </a>
                        <a href="{{ url('/fichaje') }}" class="py-3 flex flex-col items-center gap-1 {{ request()->is('fichaje*') ? 'text-purple-600 bg-purple-50 nav-active' : '' }} hover:bg-gray-50 transition">
                            <span class="text-lg">⏱️</span>
                            <span>Fichar</span>
                        </a>
                        <a href="{{ url('/horas') }}" class="py-3 flex flex-col items-center gap-1 {{ request()->is('horas*') ? 'text-purple-600 bg-purple-50 nav-active' : '' }} hover:bg-gray-50 transition">
                            <span class="text-lg">📊</span>
                            <span>Horas</span>
                        </a>
                    </div>
                </nav>
            </div>
        </div>
    </div>
</body>
</html>
