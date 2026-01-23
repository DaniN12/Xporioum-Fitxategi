<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fitxategi - Fichaje</title>
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
        .card-hover {
            transition: all 0.3s ease;
        }
        .card-hover:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 25px -5px rgb(0 0 0 / 0.1), 0 8px 10px -6px rgb(0 0 0 / 0.1);
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
        .badge {
            display: inline-flex;
            align-items: center;
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 600;
        }
    </style>
</head>
<body class="min-h-screen bg-gradient-to-br from-purple-100 to-blue-100 flex flex-col">
    <div class="fixed inset-0 -z-10 bg-[#FFFFFF]">
        <div class="absolute inset-0 opacity-20 diagonal-pattern"></div>
    </div>

    <div class="flex-1 flex flex-col w-full">
        <div class="relative bg-white shadow-2xl ring-1 ring-black/10 w-full min-h-screen flex flex-col">

            <header class="h-14 flex-none bg-gradient-to-r from-gray-900 to-black text-white flex items-center justify-between px-4 z-10">
                <div class="flex items-center gap-3">
                    <img src="{{ asset('images/fitxategi.png') }}" alt="Logo Fitxategi" class="h-9 w-9 rounded-full shadow-lg object-contain bg-white">
                    <div class="hidden xs:block">
                        <div class="font-bold text-sm">Fitxategi</div>
                        <div class="text-xs text-gray-400">Control horario</div>
                    </div>
                </div>
                <div class="flex items-center gap-2">
                    <button class="h-8 w-8 rounded-full overflow-hidden hover:scale-110 transition"><img src="images/euskalherria.png" class="w-full h-full object-cover"></button>
                    <button class="h-8 w-8 rounded-full overflow-hidden hover:scale-110 transition"><img src="images/españa.png" class="w-full h-full object-cover"></button>
                </div>
            </header>

            <nav class="hidden md:flex flex-none items-center justify-center gap-10 bg-gradient-to-r from-[#d7a6ff] to-[#e5b8ff] py-3 font-bold text-black shadow-sm">
                <a href="{{ url('/perfil') }}" class="{{ request()->is('perfil*') ? 'nav-active' : '' }} hover:text-purple-800 transition">Perfil</a>
                <a href="{{ route('normas.index') }}" class="{{ request()->is('normas*') ? 'nav-active' : '' }} hover:text-purple-800 transition">Normas</a>
                <a href="{{ url('/incidencias') }}" class="{{ request()->is('incidencias*') ? 'nav-active' : '' }} hover:text-purple-800 transition">Incidencias</a>
                <a href="{{ url('/fichaje') }}" class="{{ request()->is('fichaje*') ? 'nav-active' : '' }} hover:text-purple-800 transition">Fichar</a>
                <a href="{{ url('/horas') }}" class="{{ request()->is('horas*') ? 'nav-active' : '' }} hover:text-purple-800 transition">Tus horas</a>
            </nav>

            <main class="flex-1 bg-[#f2dcff] overflow-y-auto pb-20 md:pb-10">
                <div class="max-w-5xl mx-auto p-4 md:p-8 space-y-6 animate-fade-in">

                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                        <div>
                            @auth
                                <h1 class="text-xl font-bold text-gray-800">Hola, {{ Auth::user()->name }} 👋</h1>
                            @else
                                <h1 class="text-xl font-bold text-gray-800">Hola, invitado 👋</h1>
                            @endauth
                            <p class="text-sm text-gray-600">{{ \Carbon\Carbon::now()->locale('es')->isoFormat('dddd, D [de] MMMM') }}</p>
                        </div>
                        <div class="bg-white/50 backdrop-blur-sm px-4 py-2 rounded-xl border border-white/50 flex items-center gap-3 self-start sm:self-auto">
                            <div class="text-right">
                                <div class="text-2xl font-black text-purple-600 leading-none" id="hora-actual">00:00</div>
                                <div class="text-[10px] uppercase tracking-wider text-gray-500 font-bold">Hora actual</div>
                            </div>
                            <span class="text-2xl">⏱️</span>
                        </div>
                    </div>

                    <div class="bg-gradient-to-br from-purple-600 to-indigo-700 rounded-2xl shadow-xl p-6 text-white card-hover">
                        <div class="flex items-center justify-between mb-6">
                            <div>
                                <div class="text-xs uppercase tracking-widest opacity-80 font-bold">Estado del turno</div>
                                <div class="text-3xl font-black mt-1">No fichado</div>
                            </div>
                            <div class="h-14 w-14 bg-white/20 rounded-2xl flex items-center justify-center text-3xl backdrop-blur-md rotate-3">
                                🚪
                            </div>
                        </div>
                        <button class="w-full bg-white text-purple-700 font-black py-4 rounded-xl hover:bg-purple-50 transition-all active:scale-95 shadow-lg uppercase tracking-wide">
                            Registrar Entrada
                        </button>
                    </div>

                    <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 md:gap-4">
                        <div class="bg-white rounded-2xl shadow-sm p-4 border border-purple-100">
                            <div class="text-xl mb-1">📊</div>
                            <div class="text-xl font-black text-gray-800">7.5h</div>
                            <div class="text-[10px] uppercase font-bold text-gray-400">Hoy</div>
                        </div>
                        <div class="bg-white rounded-2xl shadow-sm p-4 border border-purple-100">
                            <div class="text-xl mb-1">📅</div>
                            <div class="text-xl font-black text-gray-800">38h</div>
                            <div class="text-[10px] uppercase font-bold text-gray-400">Semana</div>
                        </div>
                        <div class="bg-white rounded-2xl shadow-sm p-4 border border-purple-100">
                            <div class="text-xl mb-1">🎯</div>
                            <div class="text-xl font-black text-purple-600">95%</div>
                            <div class="text-[10px] uppercase font-bold text-gray-400">Objetivo</div>
                        </div>
                        <div class="bg-white rounded-2xl shadow-sm p-4 border border-purple-100">
                            <div class="text-xl mb-1">⚡</div>
                            <div class="text-xl font-black text-green-600">+2h</div>
                            <div class="text-[10px] uppercase font-bold text-gray-400">Extra</div>
                        </div>
                    </div>

                    <div class="bg-white rounded-2xl shadow-sm border border-purple-100 overflow-hidden">
                        <div class="p-4 border-b border-gray-100 flex items-center justify-between bg-gray-50/50">
                            <h2 class="font-bold text-gray-800 uppercase text-sm tracking-wider">Actividad reciente</h2>
                            <span class="text-[10px] font-bold bg-purple-100 text-purple-700 px-2 py-1 rounded-md">ÚLTIMOS 3 DÍAS</span>
                        </div>
                        <div class="divide-y divide-gray-100">
                            <div class="p-4 flex items-center justify-between hover:bg-gray-50 transition">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-green-50 rounded-xl flex items-center justify-center text-green-600">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" /></svg>
                                    </div>
                                    <div>
                                        <div class="font-bold text-sm text-gray-800">Lunes 19 Ene</div>
                                        <div class="text-xs text-gray-500">08:00 - 16:30</div>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <div class="font-bold text-sm text-gray-800">8.5h</div>
                                    <div class="text-[10px] font-bold text-green-600">+30 min</div>
                                </div>
                            </div>
                            <div class="p-4 flex items-center justify-between hover:bg-gray-50 transition">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-blue-50 rounded-xl flex items-center justify-center text-blue-600">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" /></svg>
                                    </div>
                                    <div>
                                        <div class="font-bold text-sm text-gray-800">Viernes 16 Ene</div>
                                        <div class="text-xs text-gray-500">07:45 - 15:45</div>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <div class="font-bold text-sm text-gray-800">8.0h</div>
                                    <div class="text-[10px] font-bold text-gray-400">COMPLETO</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>

            <nav class="md:hidden fixed bottom-0 left-0 right-0 bg-white/80 backdrop-blur-lg border-t border-gray-200 z-20">
                <div class="grid grid-cols-5 h-16">
                    <a href="{{ url('/perfil') }}" class="flex flex-col items-center justify-center gap-1 {{ request()->is('perfil*') ? 'text-purple-600' : 'text-gray-400' }}">
                        <span class="text-xl">👤</span>
                        <span class="text-[10px] font-bold">Perfil</span>
                    </a>
                    <a href="{{ route('normas.index') }}" class="flex flex-col items-center justify-center gap-1 {{ request()->is('normas*') ? 'text-purple-600' : 'text-gray-400' }}">
                        <span class="text-xl">📋</span>
                        <span class="text-[10px] font-bold">Normas</span>
                    </a>
                    <a href="{{ url('/incidencias') }}" class="flex flex-col items-center justify-center gap-1 {{ request()->is('incidencias*') ? 'text-purple-600' : 'text-gray-400' }}">
                        <span class="text-xl">⚠️</span>
                        <span class="text-[10px] font-bold">Incidencias</span>
                    </a>
                    <a href="{{ url('/fichaje') }}" class="flex flex-col items-center justify-center gap-1 {{ request()->is('fichaje*') ? 'text-purple-600' : 'text-gray-400' }}">
                        <span class="text-xl">⏱️</span>
                        <span class="text-[10px] font-bold">Fichar</span>
                    </a>
                    <a href="{{ url('/horas') }}" class="flex flex-col items-center justify-center gap-1 {{ request()->is('horas*') ? 'text-purple-600' : 'text-gray-400' }}">
                        <span class="text-xl">📊</span>
                        <span class="text-[10px] font-bold">Horas</span>
                    </a>
                </div>
            </nav>

        </div>
    </div>

    <script>
        function updateTime() {
            const now = new Date();
            const timeString = now.toLocaleTimeString('es-ES', { hour: '2-digit', minute: '2-digit' });
            const timeElement = document.getElementById('hora-actual');
            if (timeElement) timeElement.textContent = timeString;
        }
        setInterval(updateTime, 1000);
        updateTime();
    </script>
</body>
</html>
