<!-- Vista moderna de fichar -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fitxategi - Fichar</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .diagonal-pattern { background-image: repeating-linear-gradient(135deg, rgba(255,255,255,.35) 0 2px, transparent 2px 32px); }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
        .animate-fade-in { animation: fadeIn 0.5s ease-out forwards; }
        .animate-pulse-slow { animation: pulse 2s ease-in-out infinite; }
        @keyframes pulse { 0%, 100% { transform: scale(1); } 50% { transform: scale(1.05); } }
        .card-hover { transition: all 0.3s ease; }
        .card-hover:hover { transform: translateY(-4px); box-shadow: 0 20px 25px -5px rgb(0 0 0 / 0.1), 0 8px 10px -6px rgb(0 0 0 / 0.1); }
        .nav-active { position: relative; }
        .nav-active::after { content: ''; position: absolute; bottom: -12px; left: 50%; transform: translateX(-50%); width: 24px; height: 3px; background: white; border-radius: 2px; }
        .clock-display { font-family: 'Courier New', monospace; letter-spacing: 0.1em; }
    </style>
</head>
<body class="min-h-screen bg-slate-100">
    <div class="fixed inset-0 -z-10 bg-[#7f95ff]">
        <div class="absolute inset-0 opacity-20 diagonal-pattern"></div>
    </div>
    <div class="min-h-screen flex items-center justify-center p-4">
        <div class="w-full max-w-sm sm:max-w-md md:max-w-4xl">
            <div class="relative overflow-hidden rounded-[28px] bg-white shadow-2xl ring-1 ring-black/10">
                <!-- Header -->
                <header class="h-14 bg-gradient-to-r from-gray-900 to-black text-white flex items-center justify-between px-4">
                    <div class="flex items-center gap-3">
                        <div class="h-9 w-9 bg-gradient-to-br from-purple-400 to-pink-400 rounded-full flex items-center justify-center text-xl shadow-lg">🐰</div>
                        <div class="hidden sm:block">
                            <div class="font-bold text-sm">Fitxategi</div>
                            <div class="text-xs text-gray-400">Control horario</div>
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="hidden sm:flex items-center gap-2 text-xs bg-white/10 rounded-full px-3 py-1">
                            <span class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></span>
                            <span>En línea</span>
                        </div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button class="h-8 w-8 rounded-full bg-white/10 hover:bg-white/20 transition flex items-center justify-center" title="Cerrar sesión">🚪</button>
                        </form>
                    </div>
                </header>
                <!-- Nav desktop -->
                <nav class="hidden md:flex items-center justify-center gap-10 bg-gradient-to-r from-[#d7a6ff] to-[#e5b8ff] py-3 font-bold text-black shadow-sm">
                    <a href="{{ route('profile.edit') }}" class="hover:text-purple-800 cursor-pointer transition">Perfil</a>
                    <a href="#" class="hover:text-purple-800 cursor-pointer transition">Normas</a>
                    <a class="nav-active hover:text-purple-800 cursor-pointer transition">Fichar</a>
                    <a href="{{ route('horas.usuario') }}" class="hover:text-purple-800 cursor-pointer transition">Tus horas</a>
                </nav>
                <!-- Contenido principal -->
                <main class="bg-[#f2dcff] p-6 md:p-10 min-h-[520px]">
                    <div class="max-w-2xl mx-auto space-y-6 animate-fade-in">
                        <!-- Reloj grande -->
                        <div class="bg-gradient-to-br from-gray-800 to-black rounded-3xl shadow-2xl p-8 text-white text-center">
                            <div class="text-sm opacity-75 mb-2">Hora actual</div>
                            <div id="current-time" class="text-6xl md:text-7xl font-bold clock-display mb-2">--:--:--</div>
                            <div id="current-date" class="text-lg opacity-90">--</div>
                        </div>
                        <!-- Estado de fichaje y botón -->
                        <div class="bg-white rounded-2xl shadow-lg p-6">
                            <div class="flex items-center justify-between mb-6">
                                <div class="flex items-center gap-3">
                                    <div id="status-icon" class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center text-3xl">⏱️</div>
                                    <div>
                                        <div id="status-text" class="font-bold text-lg text-gray-800">No fichado</div>
                                        <div class="text-xs text-gray-500">Última entrada: <span id="last-entry">—</span></div>
                                    </div>
                                </div>
                            </div>
                            <form method="POST" action="{{ route('fichar.accion') }}">
                                @csrf
                                <button id="clock-btn" type="submit" class="w-full bg-gradient-to-r from-green-500 to-green-700 text-white font-bold py-4 rounded-xl hover:shadow-xl transition animate-pulse-slow">
                                    <span class="text-xl">FICHAR ENTRADA</span>
                                </button>
                            </form>
                        </div>
                        <!-- Fichajes de hoy -->
                        <div class="bg-white rounded-2xl shadow-md p-6">
                            <h3 class="font-bold text-gray-800 mb-4 flex items-center gap-2">Fichajes de hoy</h3>
                            <div>
                                @if($fichajesHoy->isEmpty())
                                    <div class="text-center py-8 text-gray-400">
                                        <div class="text-4xl mb-2">⏰</div>
                                        <div class="text-sm">Aún no has fichado hoy</div>
                                    </div>
                                @else
                                    @foreach($fichajesHoy as $index => $fichaje)
                                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg mb-2">
                                            <div class="flex items-center gap-3">
                                                <div class="w-10 h-10 {{ $fichaje->tipo == 'entrada' ? 'bg-green-100' : 'bg-red-100' }} rounded-full flex items-center justify-center">
                                                    <span class="{{ $fichaje->tipo == 'entrada' ? 'text-green-600' : 'text-red-600' }} font-bold">
                                                        {{ $fichaje->tipo == 'entrada' ? 'E' : 'S' }}
                                                    </span>
                                                </div>
                                                <div>{{ $fichaje->hora }}</div>
                                            </div>
                                            <div class="text-xs text-gray-400">#{{ $index + 1 }}</div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                </main>
                <!-- Bottom nav móvil -->
                <nav class="md:hidden border-t bg-white shadow-lg">
                    <div class="grid grid-cols-4 text-center text-xs font-semibold">
                        <a href="{{ route('profile.edit') }}" class="py-3 flex flex-col items-center gap-1 hover:bg-gray-50 transition">
                            <span class="text-lg">👤</span>
                            <span>Perfil</span>
                        </a>
                        <a href="#" class="py-3 flex flex-col items-center gap-1 hover:bg-gray-50 transition">
                            <span class="text-lg">📋</span>
                            <span>Normas</span>
                        </a>
                        <a class="py-3 flex flex-col items-center gap-1 text-purple-600 bg-purple-50 transition">
                            <span class="text-lg">⏱️</span>
                            <span>Fichar</span>
                        </a>
                        <a href="{{ route('horas.usuario') }}" class="py-3 flex flex-col items-center gap-1 hover:bg-gray-50 transition">
                            <span class="text-lg">📊</span>
                            <span>Horas</span>
                        </a>
                    </div>
                </nav>
            </div>
        </div>
    </div>
    <script>
        function updateClock() {
            const now = new Date();
            const timeString = now.toLocaleTimeString('es-ES');
            const dateString = now.toLocaleDateString('es-ES', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' });
            document.getElementById('current-time').textContent = timeString;
            document.getElementById('current-date').textContent = dateString.charAt(0).toUpperCase() + dateString.slice(1);
        }
        setInterval(updateClock, 1000);
        updateClock();
    </script>
</body>
</html>
