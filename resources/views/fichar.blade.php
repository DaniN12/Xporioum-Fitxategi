<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fitxategi - Fichar</title>
    @vite('resources/css/app.css')
</head>

<body class="min-h-screen bg-[#f3d9ff] flex items-center justify-center px-6">
    <div class="w-full max-w-md text-center">

        <h1 class="text-4xl sm:text-5xl font-medium text-black mb-12">
            Bienvenido a Fitxategi
        </h1>

        {{-- Mensajes --}}
        @if(session('error'))
            <div class="mb-6 text-red-600 font-bold">
                {{ session('error') }}
            </div>
        @endif

        @if(session('success'))
            <div class="mb-6 text-green-700 font-bold">
                {{ session('success') }}
            </div>
        @endif

        <div class="space-y-6">

            {{-- ESTADO: FUERA (NO HA FICHADO) --}}
            @if($estado === 'fuera')
                <a href="{{ route('fichar.qr') }}"
                   class="block w-full py-4 rounded-full font-extrabold text-4xl text-black
                          shadow-lg shadow-black/20
                          bg-gradient-to-r from-cyan-200 via-sky-300 to-purple-300
                          hover:scale-[1.02] active:scale-[0.99] transition">
                    FICHAR
                </a>

                <a href="#"
                   class="block w-full py-4 rounded-full font-extrabold text-4xl text-black
                          shadow-lg shadow-black/20
                          bg-gradient-to-r from-cyan-200 via-sky-300 to-purple-300
                          hover:scale-[1.02] active:scale-[0.99] transition">
                    AUSENCIA
                </a>
            @endif

            {{-- ESTADO: DENTRO (HA ENTRADO, PUEDE DESCANSO / SALIR) --}}
            @if($estado === 'dentro')
                <form action="{{ route('fichar.descanso') }}" method="POST">
                    @csrf
                    <button type="submit"
                        class="w-full py-4 rounded-full font-extrabold text-4xl text-black
                               shadow-lg shadow-black/20
                               bg-gradient-to-r from-yellow-200 via-amber-300 to-orange-300
                               hover:scale-[1.02] active:scale-[0.99] transition">
                        DESCANSO
                    </button>
                </form>

                <form action="{{ route('fichar.salida') }}" method="POST">
                    @csrf
                    <button type="submit"
                        class="w-full py-4 rounded-full font-extrabold text-4xl text-black
                               shadow-lg shadow-black/20
                               bg-gradient-to-r from-rose-200 via-red-300 to-pink-300
                               hover:scale-[1.02] active:scale-[0.99] transition">
                        SALIR
                    </button>
                </form>
            @endif

            {{-- ESTADO: DESCANSO (RETOMAR) --}}
            @if($estado === 'descanso')
                <form action="{{ route('fichar.retomar') }}" method="POST">
                    @csrf
                    <button type="submit"
                        class="w-full py-4 rounded-full font-extrabold text-4xl text-black
                               shadow-lg shadow-black/20
                               bg-gradient-to-r from-emerald-200 via-green-300 to-lime-300
                               hover:scale-[1.02] active:scale-[0.99] transition">
                        RETOMAR
                    </button>
                </form>

                <button
                    class="w-full py-4 rounded-full font-extrabold text-4xl text-black/40
                           shadow-lg shadow-black/10
                           bg-gradient-to-r from-rose-200 via-red-300 to-pink-300
                           opacity-60 cursor-not-allowed">
                    SALIR
                </button>
            @endif

            {{-- ESTADO: FINALIZADO --}}
            @if($estado === 'finalizado')
                <div class="text-green-700 font-bold text-xl mb-2">
                    Turno finalizado ✅
                </div>

                <a href="{{ route('fichar.vista') }}"
                   class="block w-full py-4 rounded-full font-extrabold text-3xl text-black
                          shadow-lg shadow-black/20
                          bg-gradient-to-r from-cyan-200 via-sky-300 to-purple-300
                          hover:scale-[1.02] active:scale-[0.99] transition">
                    ACTUALIZAR
                </a>
            @endif

        </div>

        <div class="mt-10">
            <a href="{{ route('logout') }}" class="text-black underline">
                Cerrar sesión
            </a>
        </div>
    </div>
</body>
</html>
