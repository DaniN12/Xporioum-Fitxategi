@extends('layouts.alumno')

@section('content')
<div class="w-full flex justify-center">

    <div class="w-full max-w-2xl">

        {{-- CABECERA DE PÁGINA (se verá dentro del layout) --}}
        <div class="mb-6">
            <h1 class="text-2xl font-extrabold text-gray-900">Cuenta</h1>
            <p class="text-sm text-gray-500">Gestiona tu perfil y ajustes.</p>
        </div>

        @php
            $rDatos = \Illuminate\Support\Facades\Route::has('alumno.cuenta.datos') ? 'alumno.cuenta.datos' : 'cuenta.datos';
            $rDocs  = \Illuminate\Support\Facades\Route::has('alumno.cuenta.documentos') ? 'alumno.cuenta.documentos' : 'cuenta.documentos';
            $rNoti  = \Illuminate\Support\Facades\Route::has('alumno.cuenta.notificaciones') ? 'alumno.cuenta.notificaciones' : 'cuenta.notificaciones';
            $rPass  = \Illuminate\Support\Facades\Route::has('alumno.cuenta.password') ? 'alumno.cuenta.password' : 'cuenta.password';
        @endphp

        {{-- TARJETAS --}}
        <div class="grid grid-cols-1 gap-4">

            <a href="{{ route($rDatos) }}"
               class="group bg-white rounded-2xl shadow p-5 hover:shadow-lg transition border border-transparent hover:border-indigo-100">
                <div class="flex items-center justify-between">
                    <div>
                        <div class="font-bold text-gray-900">Mi perfil</div>
                        <div class="text-sm text-gray-500">Tu información de contacto.</div>
                    </div>
                    <span class="text-gray-400 group-hover:text-indigo-600 transition">›</span>
                </div>
            </a>

            <a href="{{ route($rDocs) }}"
               class="group bg-white rounded-2xl shadow p-5 hover:shadow-lg transition border border-transparent hover:border-indigo-100">
                <div class="flex items-center justify-between">
                    <div>
                        <div class="font-bold text-gray-900">Mis documentos</div>
                        <div class="text-sm text-gray-500">Tus documentos útiles y personales.</div>
                    </div>
                    <span class="text-gray-400 group-hover:text-indigo-600 transition">›</span>
                </div>
            </a>

            <a href="{{ route($rNoti) }}"
               class="group bg-white rounded-2xl shadow p-5 hover:shadow-lg transition border border-transparent hover:border-indigo-100">
                <div class="flex items-center justify-between">
                    <div>
                        <div class="font-bold text-gray-900">Notificaciones</div>
                        <div class="text-sm text-gray-500">Aceptado / rechazado, mensajes del admin, etc.</div>
                    </div>
                    <span class="text-gray-400 group-hover:text-indigo-600 transition">›</span>
                </div>
            </a>

            <a href="{{ route($rPass) }}"
               class="group bg-white rounded-2xl shadow p-5 hover:shadow-lg transition border border-transparent hover:border-indigo-100">
                <div class="flex items-center justify-between">
                    <div>
                        <div class="font-bold text-gray-900">Contraseña</div>
                        <div class="text-sm text-gray-500">Puedes cambiarla cuando quieras.</div>
                    </div>
                    <span class="text-gray-400 group-hover:text-indigo-600 transition">›</span>
                </div>
            </a>

            {{-- LOGOUT --}}
            <form method="POST" action="{{ route('logout') }}" class="pt-2">
                @csrf
                <button type="submit"
                        class="w-full bg-white rounded-2xl shadow p-5 hover:shadow-lg transition border border-red-100 hover:border-red-200 text-left">
                    <div class="font-bold text-red-600">Cerrar sesión</div>
                    <div class="text-sm text-gray-500">Salir de tu cuenta.</div>
                </button>
            </form>

        </div>
    </div>
</div>
@endsection
