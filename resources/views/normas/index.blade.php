<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fitxategi - Normas</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* TUS ESTILOS ORIGINALES SIN TOCAR */
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

        /* TAMAÑO DE TARJETAS ORIGINAL */
        .norma-card {
            background: white;
            margin-bottom: 15px;
            padding: 20px;
            border-radius: 15px;
            border-left: 10px solid black;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s;
        }
        .norma-card:hover {
            transform: translateX(5px);
        }

        @media print {
            nav, header, .btn-print-ignore, .diagonal-pattern {
                display: none !important;
            }
            main { background: white !important; padding: 0 !important; }
            .norma-card { border: 1px solid #eee; border-left: 10px solid black !important; box-shadow: none !important; }
        }
    </style>
</head>
<body class="min-h-screen w-full bg-gradient-to-br from-purple-100 to-blue-100 flex flex-col">

    <div class="fixed inset-0 -z-10 bg-[#FFFFFF] btn-print-ignore">
        <div class="absolute inset-0 opacity-20 diagonal-pattern"></div>
    </div>
    <div class="flex-1 flex flex-col w-full">
        <header class="h-14 flex-none bg-gradient-to-r from-gray-900 to-black text-white flex items-center justify-between px-4 z-10">
            <div class="flex items-center gap-3">
                <img src="{{ asset('images/fitxategi.png') }}" alt="Logo Fitxategi" class="h-9 w-9 rounded-full shadow-lg object-contain bg-white">
                <div class="hidden xs:block">
                    <div class="font-bold text-sm">Fitxategi</div>
                    <div class="text-xs text-gray-400">Control horario</div>
                </div>
            </div>
            <div class="flex items-center gap-2">
                <button class="h-8 w-8 rounded-full overflow-hidden hover:scale-110 transition shadow-sm border border-white/10">
                    <img src="{{ asset('images/euskalherria.png') }}" class="w-full h-full object-cover">
                </button>
                <button class="h-8 w-8 rounded-full overflow-hidden hover:scale-110 transition shadow-sm border border-white/10">
                    <img src="{{ asset('images/españa.png') }}" class="w-full h-full object-cover">
                </button>
            </div>
        </header>

        <nav class="hidden md:flex items-center justify-center gap-10 bg-gradient-to-r from-[#d7a6ff] to-[#e5b8ff] py-3 font-bold text-black shadow-sm btn-print-ignore">
            <a href="{{ url('/perfil') }}" class="{{ request()->is('perfil*') ? 'nav-active' : '' }} hover:text-purple-800 transition">Perfil</a>
            <a href="{{ route('normas.index') }}" class="{{ request()->is('normas*') ? 'nav-active' : '' }} hover:text-purple-800 transition">Normas</a>
            <a href="{{ url('/incidencias') }}" class="{{ request()->is('incidencias*') ? 'nav-active' : '' }} hover:text-purple-800 transition">Incidencias</a>
            <a href="{{ url('/fichaje') }}" class="{{ request()->is('fichaje*') ? 'nav-active' : '' }} hover:text-purple-800 transition">Fichar</a>
            <a href="{{ url('/horas') }}" class="{{ request()->is('horas*') ? 'nav-active' : '' }} hover:text-purple-800 transition">Tus horas</a>
        </nav>

        <main class="bg-[#f2dcff] p-6 md:p-10 flex-1 pb-24">
            <div class="max-w-2xl mx-auto space-y-6 animate-fade-in">

                <div class="text-center mb-8">
                    <h1 class="text-4xl font-black text-gray-900 tracking-tighter uppercase">Normas de Uso</h1>
                    <div class="h-1.5 w-20 bg-black mx-auto mt-2 rounded-full"></div>
                </div>

                <div class="space-y-4">
                    <div class="norma-card">
                        <span class="block text-xl uppercase font-black">1. Fichaje Obligatorio por QR</span>
                        <p class="text-gray-700 font-medium mt-1">Es obligatorio registrar la entrada y la salida escaneando el código QR. Es el único medio oficial para contabilizar tus horas.</p>
                    </div>

                    <div class="norma-card">
                        <span class="block text-xl uppercase font-black">2. Prohibido fichar por terceros</span>
                        <p class="text-gray-700 font-medium mt-1">El acceso es personal e intransferible. Está totalmente prohibido que alguien fiche por ti o compartir capturas del QR.</p>
                    </div>

                    <div class="norma-card">
                        <span class="block text-xl uppercase font-black">3. Validación de Ubicación</span>
                        <p class="text-gray-700 font-medium mt-1">El sistema verifica que estés en el centro. No se aceptarán registros realizados fuera de las instalaciones.</p>
                    </div>

                    <div class="norma-card">
                        <span class="block text-xl uppercase font-black">4. Gestión de Incidencias</span>
                        <p class="text-gray-700 font-medium mt-1">Si tienes problemas con el móvil o el QR falla, debes avisar mediante el módulo de Incidencias de la App al momento.</p>
                    </div>

                    <div class="norma-card">
                        <span class="block text-xl uppercase font-black">5. Supervisión del Profesorado</span>
                        <p class="text-gray-700 font-medium mt-1">El profesorado tiene acceso total al sistema para supervisar los fichajes en tiempo real. Puede validar, modificar o corregir cualquier registro.</p>
                    </div>
                </div>

                <div class="pt-6 btn-print-ignore">
                    <button onclick="window.print()" class="w-full text-center bg-black text-white font-bold py-5 rounded-2xl text-xl hover:bg-gray-800 transition shadow-xl uppercase tracking-wide">
                        Descargar PDF
                    </button>
                </div>

            </div>
        </main>

        <nav class="md:hidden fixed bottom-0 left-0 right-0 bg-white border-t border-gray-200 z-50 btn-print-ignore">
            <div class="grid grid-cols-5 text-center text-[10px] font-bold uppercase">
                <a href="{{ url('/perfil') }}" class="py-3 flex flex-col items-center gap-1 {{ request()->is('perfil*') ? 'text-purple-600 bg-purple-50' : 'text-gray-400' }}">
                    <span class="text-xl">👤</span><span>Perfil</span>
                </a>
                <a href="{{ route('normas.index') }}" class="py-3 flex flex-col items-center gap-1 {{ request()->is('normas*') ? 'text-purple-600 bg-purple-50' : 'text-gray-400' }}">
                    <span class="text-xl">📋</span><span>Normas</span>
                </a>
                <a href="{{ url('/incidencias') }}" class="py-3 flex flex-col items-center gap-1 {{ request()->is('incidencias*') ? 'text-purple-600 bg-purple-50' : 'text-gray-400' }}">
                    <span class="text-xl">⚠️</span><span>Incidencias</span>
                </a>
                <a href="{{ url('/fichaje') }}" class="py-3 flex flex-col items-center gap-1 {{ request()->is('fichaje*') ? 'text-purple-600 bg-purple-50' : 'text-gray-400' }}">
                    <span class="text-xl">⏱️</span><span>Fichar</span>
                </a>
                <a href="{{ url('/horas') }}" class="py-3 flex flex-col items-center gap-1 {{ request()->is('horas*') ? 'text-purple-600 bg-purple-50' : 'text-gray-400' }}">
                    <span class="text-xl">📊</span><span>Horas</span>
                </a>
            </div>
        </nav>
    </div>
</body>
</html>
