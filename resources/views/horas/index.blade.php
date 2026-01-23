<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fitxategi - Tus Horas</title>
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
        .tab-active {
            border-bottom: 3px solid #7c3aed;
            color: #7c3aed;
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
                <!-- Header y nav -->
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
                    <a href="{{ url('/perfil') }}" class="{{ request()->is('perfil*') ? 'nav-active' : '' }} hover:text-purple-800 transition">Perfil</a>
                    <a href="{{ route('normas.index') }}" class="{{ request()->is('normas*') ? 'nav-active' : '' }} hover:text-purple-800 transition">Normas</a>
                    <a href="{{ url('/incidencias') }}" class="{{ request()->is('incidencias*') ? 'nav-active' : '' }} hover:text-purple-800 transition">Incidencias</a>
                    <a href="{{ url('/fichaje') }}" class="{{ request()->is('fichaje*') ? 'nav-active' : '' }} hover:text-purple-800 transition">Fichar</a>
                    <a href="{{ url('/horas') }}" class="{{ request()->is('horas*') ? 'nav-active' : '' }} hover:text-purple-800 transition">Tus horas</a>
                </nav>
                <main class="bg-[#f2dcff] p-6 md:p-10 min-h-[520px]">
                    <div class="max-w-3xl mx-auto space-y-6 animate-fade-in">
                        <div class="flex items-center justify-between">
                            <div>
                                <h1 class="text-3xl font-bold text-gray-800">Tus horas</h1>
                                <p class="text-gray-600 mt-1">Resumen de actividad</p>
                            </div>
                            <button class="bg-white rounded-xl shadow px-4 py-2 font-semibold text-sm hover:shadow-lg transition">📥 Exportar</button>
                        </div>
                        <div class="bg-gradient-to-br from-purple-500 to-purple-700 rounded-2xl shadow-lg p-6 text-white">
                            <div class="flex items-center justify-between mb-6">
                                <div></div>
                                <div class="text-right"></div>
                            </div>
                            <div class="bg-white/20 rounded-full h-3 overflow-hidden backdrop-blur-sm">
                                <div class="bg-white h-full rounded-full" style="width: 95%"></div>
                            </div>
                            <div class="mt-2 text-sm opacity-90 text-center">95% completado</div>
                        </div>
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                            <div class="bg-white rounded-xl shadow p-4 card-hover text-center">
                                <div class="text-2xl mb-2">📊</div>
                                <div class="text-2xl font-bold text-gray-800">38h</div>
                                <div class="text-xs text-gray-500">Esta semana</div>
                            </div>
                            <div class="bg-white rounded-xl shadow p-4 card-hover text-center">
                                <div class="text-2xl mb-2">⏱️</div>
                                <div class="text-2xl font-bold text-gray-800">7.6h</div>
                                <div class="text-xs text-gray-500">Media diaria</div>
                            </div>
                            <div class="bg-white rounded-xl shadow p-4 card-hover text-center">
                                <div class="text-2xl mb-2">⚡</div>
                                <div class="text-2xl font-bold text-green-600">+8h</div>
                                <div class="text-xs text-gray-500">Horas extra</div>
                            </div>
                            <div class="bg-white rounded-xl shadow p-4 card-hover text-center">
                                <div class="text-2xl mb-2">📅</div>
                                <div class="text-2xl font-bold text-gray-800">18</div>
                                <div class="text-xs text-gray-500">Días trabajados</div>
                            </div>
                        </div>
                        <div class="bg-white rounded-2xl shadow-md overflow-hidden">
                            <div class="flex border-b">
                                <button onclick="changeTab('week')" class="tab-btn tab-active flex-1 py-3 font-semibold text-sm transition">Semana</button>
                                <button onclick="changeTab('month')" class="tab-btn flex-1 py-3 font-semibold text-sm text-gray-500 transition hover:text-gray-800">Mes</button>
                                <button onclick="changeTab('all')" class="tab-btn flex-1 py-3 font-semibold text-sm text-gray-500 transition hover:text-gray-800">Todo</button>
                            </div>
                            <div id="tab-week" class="tab-content p-6">
                                <div class="space-y-3"></div>
                                <div class="mt-6 pt-6 border-t"></div>
                            </div>
                            <div id="tab-month" class="tab-content hidden p-6">
                                <div class="text-center py-12 text-gray-400">Sin datos de mes</div>
                            </div>
                            <div id="tab-all" class="tab-content hidden p-6">
                                <div class="text-center py-12 text-gray-400">Sin datos históricos</div>
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="bg-white rounded-xl shadow p-5">
                                <div class="flex items-center gap-3 mb-4"></div>
                                <div class="text-3xl font-bold text-blue-600">96%</div>
                            </div>
                            <div class="bg-white rounded-xl shadow p-5"></div>
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
                        <a href="{{ url('/incidencias') }}" class="py-3 flex flex-col items-center gap-1 {{ request()->is('incidencias*') ? 'text-purple-600 bg-purple-50 nav-active' : '' }} hover:bg-gray-50 transition">
                            <span class="text-lg">⏱️</span>
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
    <script>
        function changeTab(tabName) {
            document.querySelectorAll('.tab-content').forEach(content => {
                content.classList.add('hidden');
            });
            document.getElementById('tab-' + tabName).classList.remove('hidden');
            document.querySelectorAll('.tab-btn').forEach(btn => {
                btn.classList.remove('tab-active');
                btn.classList.add('text-gray-500');
            });
            event.target.classList.add('tab-active');
            event.target.classList.remove('text-gray-500');
        }
    </script>
</body>
</html>
