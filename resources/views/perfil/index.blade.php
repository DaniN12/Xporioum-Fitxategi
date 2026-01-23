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
        .progress-ring {
            transform: rotate(-90deg);
        }
    </style>
</head>
<body class="min-h-screen w-screen h-screen bg-gradient-to-br from-purple-100 to-blue-100 flex flex-col">
    <!-- Fondo con patrón -->
    <div class="fixed inset-0 -z-10 bg-[#FFFFFF]">
        <div class="absolute inset-0 opacity-20 diagonal-pattern"></div>
    </div>
    <!-- Contenedor principal FULL SCREEN -->
    <div class="flex-1 flex flex-col items-stretch justify-stretch p-0 w-full h-full">
        <div class="w-full h-full">
            <div class="relative overflow-hidden rounded-none bg-white shadow-2xl ring-1 ring-black/10 w-full h-full min-h-screen">
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
                <!-- Contenido principal FULL WIDTH -->
                <main class="bg-[#f2dcff] p-0 md:p-0 min-h-[calc(100vh-110px)] w-full h-full flex flex-col items-center justify-start">
                    <div class="w-full h-full flex flex-col items-center justify-start space-y-6 animate-fade-in px-2 py-6 md:px-8 md:py-10">
                        <!-- Bienvenida -->
                        @auth
                        <div class="flex items-center justify-between w-full max-w-5xl">
                            <div>

                        {{ \Carbon\Carbon::now()->locale('es')->isoFormat('dddd, D [de] MMMM [de] YYYY') }}
                            </div>
                            <div class="hidden sm:block">

                                <div class="text-right">
                                    <div class="text-2xl font-bold text-purple-600" id="hora-actual">08:23</div>
                                    <div class="text-xs text-gray-500">Hora actual</div>
                                </div>
                            </div>
                        </div>
                        @else
                        <div class="flex items-center justify-between w-full max-w-5xl">
                            <div>
                                 <h1 class="text-2xl font-bold mb-1">Hola, invitado 👋</h1>
                            </div>
                        </div>
                        @endauth
                        <!-- Estado actual -->
                        <div class="bg-gradient-to-br from-purple-500 to-purple-700 rounded-2xl shadow-lg p-6 text-white card-hover w-full max-w-3xl">
                            <div class="flex items-center justify-between mb-4">
                                <div>
                                    <div class="text-sm opacity-90">Estado actual</div>
                                    <div class="text-2xl font-bold mt-1">No fichado</div>
                                </div>
                                <div class="h-16 w-16 bg-white/20 rounded-full flex items-center justify-center text-3xl backdrop-blur-sm">
                                    ⏱️
                                </div>
                            </div>
                            <button class="w-full bg-white text-purple-600 font-bold py-3 rounded-xl hover:bg-purple-50 transition shadow-md">
                                FICHAR ENTRADA
                            </button>
                        </div>
                        <!-- Estadísticas del día -->
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 w-full max-w-5xl">
                            <div class="bg-white rounded-xl shadow p-4 card-hover">
                                <div class="text-2xl mb-2">📊</div>
                                <div class="text-2xl font-bold text-gray-800">7.5h</div>
                                <div class="text-xs text-gray-500">Hoy</div>
                            </div>
                            <div class="bg-white rounded-xl shadow p-4 card-hover">
                                <div class="text-2xl mb-2">📅</div>
                                <div class="text-2xl font-bold text-gray-800">38h</div>
                                <div class="text-xs text-gray-500">Esta semana</div>
                            </div>
                            <div class="bg-white rounded-xl shadow p-4 card-hover">
                                <div class="text-2xl mb-2">🎯</div>
                                <div class="text-2xl font-bold text-purple-600">95%</div>
                                <div class="text-xs text-gray-500">Cumplimiento</div>
                            </div>
                            <div class="bg-white rounded-xl shadow p-4 card-hover">
                                <div class="text-2xl mb-2">⚡</div>
                                <div class="text-2xl font-bold text-green-600">+2h</div>
                                <div class="text-xs text-gray-500">Extra</div>
                            </div>
                        </div>
                        <!-- Últimos fichajes -->
                        <div class="bg-white rounded-2xl shadow-md p-6 w-full max-w-5xl">
                            <div class="flex items-center justify-between mb-4">
                                <h2 class="text-xl font-semibold text-gray-800">Últimos fichajes</h2>
                                <span class="badge bg-purple-100 text-purple-700">Esta semana</span>
                            </div>
                            <div class="space-y-3">
                                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center">
                                            <span class="text-green-600 font-bold">↓</span>
                                        </div>
                                        <div>
                                            <div class="font-semibold text-gray-800">Lunes 19 Ene</div>
                                            <div class="text-sm text-gray-500">08:00 - 16:30</div>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <div class="font-bold text-gray-800">8.5h</div>
                                        <div class="text-xs text-green-600">+0.5h</div>
                                    </div>
                                </div>
                                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center">
                                            <span class="text-green-600 font-bold">↓</span>
                                        </div>
                                        <div>
                                            <div class="font-semibold text-gray-800">Viernes 16 Ene</div>
                                            <div class="text-sm text-gray-500">07:45 - 15:45</div>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <div class="font-bold text-gray-800">8.0h</div>
                                        <div class="text-xs text-gray-600">Normal</div>
                                    </div>
                                </div>
                                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 bg-orange-100 rounded-full flex items-center justify-center">
                                            <span class="text-orange-600 font-bold">↓</span>
                                        </div>
                                        <div>
                                            <div class="font-semibold text-gray-800">Jueves 15 Ene</div>
                                            <div class="text-sm text-gray-500">08:15 - 16:00</div>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <div class="font-bold text-gray-800">7.75h</div>
                                        <div class="text-xs text-orange-600">-0.25h</div>
                                    </div>
                                </div>
                            </div>
                        </div>
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
                        <a href="{{ url('/fichaje') }}" class="py-3 flex flex-col items-center gap-1 {{ request()->is('fichaje*') ? 'text-purple-600 bg-purple-50 nav-active' : '' }} hover:bg-gray-50 transition">
                            <span class="text-lg">⏱️</span>
                            <span>Fichaje</span>
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
    <script>
        // Actualizar hora en tiempo real
        function updateTime() {
            const now = new Date();
            const timeString = now.toLocaleTimeString('es-ES', { hour: '2-digit', minute: '2-digit' });
            const timeElement = document.getElementById('hora-actual');
            if (timeElement) {
                timeElement.textContent = timeString;
            }
            // Actualizar fecha
            const fechaElement = document.getElementById('fecha-hoy');
            if (fechaElement) {
                const opciones = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
                fechaElement.textContent = now.toLocaleDateString('es-ES', opciones);
            }
        }
        setInterval(updateTime, 1000);
        updateTime();
    </script>
</body>
</html>
