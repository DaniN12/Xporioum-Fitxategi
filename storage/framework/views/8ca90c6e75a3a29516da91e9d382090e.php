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
    <div class="fixed inset-0 -z-10 bg-[#FFFFFF]">
        <div class="absolute inset-0 opacity-20 diagonal-pattern"></div>
    </div>
    <div class="flex-1 flex flex-col items-stretch justify-stretch p-0 w-full h-full">
        <div class="w-full">
            <div class="relative overflow-hidden rounded-none bg-white shadow-2xl ring-1 ring-black/10 w-full h-full min-h-screen flex flex-col">
                <!-- Header -->
                <header class="h-14 flex-none bg-gradient-to-r from-gray-900 to-black text-white flex items-center justify-between px-4 z-10">
                    <div class="flex items-center gap-3">
                        <img src="<?php echo e(asset('images/fitxategi.png')); ?>" alt="Logo Fitxategi" class="h-9 w-9 rounded-full shadow-lg object-contain bg-white">
                        <div class="hidden xs:block">
                            <div class="font-bold text-sm">Fitxategi</div>
                            <div class="text-xs text-gray-400">Control horario</div>
                        </div>
                    </div>
                    <div class="flex items-center gap-2">
                        <button class="h-8 w-8 rounded-full overflow-hidden hover:scale-110 transition shadow-sm border border-white/10">
                            <img src="<?php echo e(asset('images/euskalherria.png')); ?>" class="w-full h-full object-cover">
                        </button>
                        <button class="h-8 w-8 rounded-full overflow-hidden hover:scale-110 transition shadow-sm border border-white/10">
                            <img src="<?php echo e(asset('images/españa.png')); ?>" class="w-full h-full object-cover">
                        </button>
                    </div>
                </header>
                <!-- Nav desktop -->
                <nav class="hidden md:flex items-center justify-center gap-10 bg-gradient-to-r from-[#d7a6ff] to-[#e5b8ff] py-3 font-bold text-black shadow-sm">
                    <a href="<?php echo e(url('/perfil')); ?>" class="<?php echo e(request()->is('perfil*') ? 'nav-active' : ''); ?> hover:text-purple-800 cursor-pointer transition">Perfil</a>
                    <a href="<?php echo e(route('normas.index')); ?>" class="<?php echo e(request()->is('normas*') ? 'nav-active' : ''); ?> hover:text-purple-800 cursor-pointer transition">Normas</a>
                    <a href="<?php echo e(url('/incidencias')); ?>" class="<?php echo e(request()->is('incidencias*') ? 'nav-active' : ''); ?> hover:text-purple-800 cursor-pointer transition">Incidencias</a>
                    <a href="<?php echo e(url('/fichaje')); ?>" class="<?php echo e(request()->is('fichaje*') ? 'nav-active' : ''); ?> hover:text-purple-800 cursor-pointer transition">Fichar</a>
                    <a href="<?php echo e(url('/horas')); ?>" class="<?php echo e(request()->is('horas*') ? 'nav-active' : ''); ?> hover:text-purple-800 cursor-pointer transition">Tus horas</a>
                </nav>
                <!-- Contenido principal -->
                <main class="bg-[#f2dcff] p-6 md:p-10 min-h-[520px]">
                    <div class="max-w-3xl mx-auto space-y-6 animate-fade-in">
                        <script>
                            function updateClockFichaje() {
                                const now = new Date();
                                const timeString = now.toLocaleTimeString('es-ES', { hour: '2-digit', minute: '2-digit', second: '2-digit' });
                                document.getElementById('current-time').textContent = timeString;
                                const dateString = now.toLocaleDateString('es-ES', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' });
                                document.getElementById('current-date').textContent = dateString.charAt(0).toUpperCase() + dateString.slice(1);
                            }
                            setInterval(updateClockFichaje, 1000);
                            updateClockFichaje();
                        </script>
                        <!-- Estado actual -->
                        <div class="bg-white rounded-2xl shadow-lg p-6 flex flex-col md:flex-row items-center md:items-stretch gap-6 mb-6">
                            <div class="flex-1 flex flex-col justify-between">
                                <div class="text-sm text-gray-500 mb-1">Estado actual</div>
                                <div class="text-2xl font-bold text-gray-800 mb-4">No fichado</div>
                                <button class="w-full bg-green-500 hover:bg-green-600 text-white font-bold py-4 rounded-xl transition text-lg">FICHAR ENTRADA</button>
                            </div>
                            <div class="flex items-center justify-center">
                                <span class="inline-block w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center text-4xl">⏱️</span>
                            </div>
                        </div>
                        <!-- Estadísticas del día -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                            <div class="bg-white rounded-xl shadow p-4">
                                <div class="text-sm text-gray-500 mb-1">Última entrada</div>
                                <div class="text-lg font-bold text-gray-800">--:--</div>
                            </div>
                            <div class="bg-white rounded-xl shadow p-4">
                                <div class="text-sm text-gray-500 mb-1">Tiempo trabajado hoy</div>
                                <div class="text-lg font-bold text-purple-600">0h 0m</div>
                            </div>
                        </div>
                        <!-- Fichajes de hoy -->
                        <div class="bg-white rounded-2xl shadow-md p-6 mb-6">
                            <h3 class="font-bold text-gray-800 mb-4 flex items-center gap-2">
                                <span class="text-xl">📅</span>
                                Fichajes de hoy
                            </h3>
                            <div class="flex flex-col items-center justify-center py-8 text-gray-400">
                                <span class="text-4xl mb-2">⏰</span>
                                <span class="text-sm">Aún no has fichado hoy</span>
                            </div>
                        </div>
                        <!-- Recordatorio -->
                        <div class="bg-blue-50 border-l-4 border-blue-500 rounded-lg p-4">
                            <div class="flex items-start gap-3">
                                <span class="text-2xl">💡</span>
                                <div class="text-sm text-blue-900">
                                    <div class="font-semibold mb-1">Recordatorio</div>
                                    <p>No olvides fichar tu salida al finalizar la jornada. El horario flexible permite entrada entre 7:00 y 9:00.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
                <!-- Bottom nav móvil -->
                <nav class="md:hidden fixed bottom-0 left-0 right-0 bg-white/80 backdrop-blur-lg border-t border-gray-200 z-20">
                    <div class="grid grid-cols-5 h-16">
                        <a href="<?php echo e(url('/perfil')); ?>" class="flex flex-col items-center justify-center gap-1 <?php echo e(request()->is('perfil*') ? 'text-purple-600' : 'text-gray-400'); ?>">
                            <span class="text-xl">👤</span>
                            <span class="text-[10px] font-bold">Perfil</span>
                        </a>
                        <a href="<?php echo e(route('normas.index')); ?>" class="flex flex-col items-center justify-center gap-1 <?php echo e(request()->is('normas*') ? 'text-purple-600' : 'text-gray-400'); ?>">
                            <span class="text-xl">📋</span>
                            <span class="text-[10px] font-bold">Normas</span>
                        </a>
                        <a href="<?php echo e(url('/incidencias')); ?>" class="flex flex-col items-center justify-center gap-1 <?php echo e(request()->is('incidencias*') ? 'text-purple-600' : 'text-gray-400'); ?>">
                            <span class="text-xl">⚠️</span>
                            <span class="text-[10px] font-bold">Incidencias</span>
                        </a>
                        <a href="<?php echo e(url('/fichaje')); ?>" class="flex flex-col items-center justify-center gap-1 <?php echo e(request()->is('fichaje*') ? 'text-purple-600' : 'text-gray-400'); ?>">
                            <span class="text-xl">⏱️</span>
                            <span class="text-[10px] font-bold">Fichar</span>
                        </a>
                        <a href="<?php echo e(url('/horas')); ?>" class="flex flex-col items-center justify-center gap-1 <?php echo e(request()->is('horas*') ? 'text-purple-600' : 'text-gray-400'); ?>">
                            <span class="text-xl">📊</span>
                            <span class="text-[10px] font-bold">Horas</span>
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
<?php /**PATH D:\Joane\UniServerZ\www\DaniN12-Xporioum-Fitxategi\resources\views/fichaje/index.blade.php ENDPATH**/ ?>