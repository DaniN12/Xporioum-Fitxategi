<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fitxategi - Fichar</title>
    @vite('resources/css/app.css')
</head>

<body class="min-h-screen flex items-center justify-center px-6
             bg-gradient-to-br from-indigo-400 via-purple-400 to-pink-400 text-gray-900">

    <div class="w-full max-w-md text-center space-y-8">

        {{-- LOGO --}}
        <div class="flex justify-center mb-6">
            <div class="logo-left">
                <img src="{{ asset('img/logo-fitxategi.png') }}" alt="Logo Fitxategi"
                     class="w-48 sm:w-56 animate-pulse drop-shadow-2xl">
            </div>
        </div>

        {{-- SALUDO --}}
        <h1 class="text-4xl sm:text-5xl font-extrabold text-white">
            Bienvenido a <span class="text-indigo-200">Fitxategi</span>
        </h1>

        {{-- MENSAJES --}}
        @if(session('error'))
            <div class="p-4 rounded-lg bg-red-100 text-red-700 font-semibold shadow">
                {{ session('error') }}
            </div>
        @endif

        @if(session('success'))
            <div class="p-4 rounded-lg bg-green-100 text-green-700 font-semibold shadow">
                {{ session('success') }}
            </div>
        @endif

        {{-- BOTONES PRINCIPALES --}}
        <div class="space-y-4">

            {{-- FUERA --}}
            @if($estado === 'fuera')
                <a href="{{ route('fichar.qr') }}"
                   class="block w-full py-4 rounded-xl font-bold text-2xl sm:text-3xl text-white
                          bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500
                          shadow-lg shadow-indigo-200
                          transform hover:scale-105 active:scale-95 transition">
                    FICHAR
                </a>

                <a href="#"
                   class="block w-full py-4 rounded-xl font-bold text-2xl sm:text-3xl text-gray-500
                          bg-white
                          shadow-md
                          opacity-70 cursor-not-allowed">
                    AUSENCIA
                </a>
            @endif

            {{-- DENTRO --}}
            @if($estado === 'dentro')
                <form action="{{ route('fichar.descanso') }}" method="POST">
                    @csrf
                    <button type="submit"
                        class="w-full py-4 rounded-xl font-bold text-2xl sm:text-3xl text-white
                               bg-gradient-to-r from-yellow-400 via-amber-500 to-orange-500
                               shadow-md shadow-yellow-200
                               transform hover:scale-105 active:scale-95 transition">
                        DESCANSO
                    </button>
                </form>

                <form action="{{ route('fichar.salida') }}" method="POST">
                    @csrf
                    <button type="submit"
                        class="w-full py-4 rounded-xl font-bold text-2xl sm:text-3xl text-white
                               bg-gradient-to-r from-red-500 via-rose-500 to-pink-500
                               shadow-md shadow-red-200
                               transform hover:scale-105 active:scale-95 transition">
                        SALIR
                    </button>
                </form>
            @endif

            {{-- DESCANSO --}}
            @if($estado === 'descanso')
                <form action="{{ route('fichar.retomar') }}" method="POST">
                    @csrf
                    <button type="submit"
                        class="w-full py-4 rounded-xl font-bold text-2xl sm:text-3xl text-white
                               bg-gradient-to-r from-green-500 via-emerald-500 to-lime-500
                               shadow-md shadow-green-200
                               transform hover:scale-105 active:scale-95 transition">
                        RETOMAR
                    </button>
                </form>

                <button class="w-full py-4 rounded-xl font-bold text-gray-400
                               bg-white shadow-md opacity-70 cursor-not-allowed">
                    SALIR
                </button>
            @endif

            {{-- FINALIZADO --}}
            @if($estado === 'finalizado')
                <div class="text-green-700 font-bold text-xl sm:text-2xl mb-2">
                    Turno finalizado ✅
                </div>

                <a href="{{ route('fichar.vista') }}"
                   class="block w-full py-4 rounded-xl font-bold text-2xl sm:text-3xl text-white
                          bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500
                          shadow-lg shadow-indigo-200
                          transform hover:scale-105 active:scale-95 transition">
                    ACTUALIZAR
                </a>
            @endif

        </div>

        {{-- BARRA DE ICONOS FLOTANTE --}}
        <div class="fixed bottom-6 left-1/2 -translate-x-1/2
                    bg-white/90 backdrop-blur-md
                    shadow-2xl rounded-full px-8 py-3
                    flex items-center gap-6 z-50">

            {{-- PERFIL --}}
            <a href=""
               class="group flex flex-col items-center text-gray-700 hover:text-indigo-600 transition">
                <i class="bi bi-person-fill text-2xl group-hover:scale-110 transition-transform"></i>
                <span class="text-xs font-semibold">Perfil</span>
            </a>

            {{-- HORAS --}}
            <a href=""
               class="group flex flex-col items-center text-gray-700 hover:text-blue-500 transition">
                <i class="bi bi-clock text-2xl group-hover:scale-110 transition-transform"></i>
                <span class="text-xs font-semibold">Horas</span>
            </a>

            {{-- FICHAR --}}
            <a href=""
               class="group flex flex-col items-center text-white bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500
                      rounded-full px-4 py-2 shadow-lg hover:scale-110 transition transform">
                <i class="bi bi-play-circle-fill text-3xl"></i>
                <span class="text-xs font-bold">Fichar</span>
            </a>

            {{-- NORMAS --}}
            <a href=""
               class="group flex flex-col items-center text-gray-700 hover:text-indigo-600 transition">
                <i class="bi bi-file-earmark-text text-2xl group-hover:scale-110 transition-transform"></i>
                <span class="text-xs font-semibold">Normas</span>
            </a>

            {{-- LOGOUT --}}
            <a href="{{ route('logout') }}"
               class="group flex flex-col items-center text-red-600 hover:text-red-800 transition">
                <i class="bi bi-box-arrow-right text-2xl group-hover:scale-110 transition-transform"></i>
                <span class="text-xs font-semibold">Salir</span>
            </a>

        </div>

    </div>
</body>
</html>
