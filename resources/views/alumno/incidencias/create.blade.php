@extends('layouts.alumno')

@section('title', 'Registrar incidencia')

@section('content')
<div class="w-full max-w-3xl mx-auto px-4 sm:px-6 lg:px-10 py-10">

    {{-- =========================
        MENSAJE OK
    ========================= --}}
    @if(session('status'))
        <div class="bg-white rounded-2xl shadow border border-green-100 p-8 text-center">
            <div class="text-5xl mb-3">✅</div>
            <div class="font-extrabold text-2xl text-gray-900 mb-2">
                {{ session('status') }}
            </div>
            <p class="text-gray-500 mb-6">
                Tu incidencia se ha registrado correctamente.
            </p>

            <a href="{{ route('incidencias.create') }}"
               class="inline-flex items-center justify-center px-6 py-3 rounded-xl font-bold text-white bg-indigo-600 hover:bg-indigo-700 transition">
                Hacer otra incidencia
            </a>
        </div>

    @else

        {{-- =========================
            ERRORES
        ========================= --}}
        @if ($errors->any())
            <div class="mb-6 bg-red-50 border border-red-200 text-red-700 rounded-2xl p-4">
                <div class="font-extrabold mb-2">Revisa estos errores:</div>
                <ul class="list-disc pl-5 space-y-1">
                    @foreach ($errors->all() as $error)
                        <li class="font-medium">{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- =========================
            HEADER
        ========================= --}}
        <div class="mb-8 text-center">
            <div class="inline-flex items-center justify-center w-14 h-14 rounded-2xl bg-indigo-50 text-indigo-600 text-2xl shadow-sm">
                📝
            </div>
            <h1 class="mt-4 text-3xl sm:text-4xl font-extrabold text-gray-900 tracking-tight">
                Registrar incidencia
            </h1>
            <p class="mt-2 text-gray-500 font-medium">
                Justifica tu incidencia (puedes adjuntar PDF o imagen)
            </p>
        </div>

        {{-- =========================
            FORM
        ========================= --}}
        <form action="{{ route('incidencias.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <div class="bg-white rounded-2xl shadow border border-gray-100 p-6 sm:p-8 space-y-6">

                {{-- Fecha --}}
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">
                        Fecha de la incidencia
                    </label>
                    <input
                        type="date"
                        name="fecha"
                        value="{{ old('fecha') }}"
                        required
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-300 focus:border-transparent"
                    >
                </div>

                {{-- Motivo --}}
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">
                        Motivo detallado
                    </label>
                    <textarea
                        name="motivo"
                        required
                        rows="5"
                        placeholder="Explica brevemente lo ocurrido..."
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-300 focus:border-transparent"
                    >{{ old('motivo') }}</textarea>
                </div>

                {{-- Adjunto --}}
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">
                        Adjuntar justificante (opcional)
                    </label>

                    <label class="group w-full cursor-pointer block">
                        <div class="w-full rounded-2xl border-2 border-dashed border-gray-300 bg-gray-50
                                    p-6 flex items-center justify-between gap-4
                                    group-hover:bg-gray-100 transition">
                            <div class="flex items-center gap-3">
                                <div class="w-11 h-11 rounded-xl bg-white border flex items-center justify-center text-xl">
                                    📎
                                </div>

                                <div>
                                    <div class="font-bold text-gray-800">
                                        Click para subir PDF o imagen
                                    </div>
                                    <div class="text-sm text-gray-500">
                                        (pdf, jpg, jpeg, png, webp) máx 8MB
                                    </div>
                                </div>
                            </div>

                            <div class="text-gray-400 group-hover:text-gray-600 transition">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1M12 12v9m0-9l-3 3m3-3l3 3M12 3v9" />
                                </svg>
                            </div>
                        </div>

                        <input
                            type="file"
                            name="adjunto"
                            class="hidden"
                            accept=".pdf,image/*"
                        />
                    </label>

                    <p class="mt-2 text-xs text-gray-400">
                        Consejo: adjunta un justificante solo si lo tienes (no es obligatorio).
                    </p>
                </div>
            </div>

            {{-- Botón --}}
            <button
                type="submit"
                class="w-full py-4 rounded-2xl font-extrabold text-white bg-gray-900 hover:bg-black transition shadow-lg"
            >
                Registrar ahora
            </button>
        </form>

    @endif
</div>
@endsection
