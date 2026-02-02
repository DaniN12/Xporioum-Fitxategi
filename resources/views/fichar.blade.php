@extends('layouts.alumno')

@section('content')
<div class="flex items-center justify-center">
    <div class="w-full max-w-xl bg-white shadow-xl rounded-2xl p-12 text-center space-y-8">

        <div class="flex justify-center">
            <img src="{{ asset('img/logo-fitxategi.png') }}" class="w-16" alt="Logo">
        </div>

        <h1 class="text-4xl font-bold text-gray-800">
            Bienvenido a <span class="text-indigo-600">Fitxategi</span>
        </h1>

        @if(session('error'))
            <div class="p-3 rounded-lg bg-red-100 text-red-700 font-semibold">
                {{ session('error') }}
            </div>
        @endif

        @if(session('success'))
            <div class="p-3 rounded-lg bg-green-100 text-green-700 font-semibold">
                {{ session('success') }}
            </div>
        @endif

        <div class="space-y-4">

            @if($estado === 'fuera')
                <a href="{{ route('fichar.qr') }}"
                   class="block w-full py-4 rounded-xl font-bold text-xl text-white bg-indigo-600 hover:bg-indigo-700 transition shadow">
                    FICHAR
                </a>

                <a href="{{ route('incidencias.create') }}"
                   class="block w-full py-4 rounded-xl font-bold text-xl text-gray-500 bg-gray-200 opacity-60 cursor-not-allowed">
                    INCIDENCIA
                </a>
            @endif

            @if($estado === 'dentro')
                <form action="{{ route('fichar.descanso') }}" method="POST">
                    @csrf
                    <button type="submit"
                        class="w-full py-4 rounded-xl font-bold text-xl text-white bg-yellow-500 hover:bg-yellow-600 transition shadow">
                        DESCANSO
                    </button>
                </form>

                <form action="{{ route('fichar.salida') }}" method="POST">
                    @csrf
                    <button type="submit"
                        class="w-full py-4 rounded-xl font-bold text-xl text-white bg-red-600 hover:bg-red-700 transition shadow">
                        SALIR
                    </button>
                </form>
            @endif

            @if($estado === 'descanso')
                <form action="{{ route('fichar.retomar') }}" method="POST">
                    @csrf
                    <button type="submit"
                        class="w-full py-4 rounded-xl font-bold text-xl text-white bg-green-600 hover:bg-green-700 transition shadow">
                        RETOMAR
                    </button>
                </form>

                <button class="w-full py-4 rounded-xl font-bold text-gray-400 bg-gray-200 opacity-60 cursor-not-allowed">
                    SALIR
                </button>
            @endif

            @if($estado === 'finalizado')
                <div class="text-green-700 font-bold text-lg">
                    Turno finalizado ✅
                </div>

                <a href="{{ route('fichar.vista') }}"
                   class="block w-full py-4 rounded-xl font-bold text-xl text-white bg-indigo-600 hover:bg-indigo-700 transition shadow">
                    ACTUALIZAR
                </a>
            @endif

        </div>
    </div>
</div>
@endsection
