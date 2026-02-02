@extends('layouts.teacher', ['title' => 'Registrar alumno'])

@section('content')

<div class="max-w-5xl mx-auto">
    <div class="bg-white rounded-2xl shadow-xl border border-slate-100 overflow-hidden">

        <div class="px-6 md:px-10 py-8 border-b bg-gradient-to-r from-indigo-50 to-white">
            <h1 class="text-2xl md:text-3xl font-extrabold text-slate-900">
                Registrar nuevo alumno
            </h1>
            <p class="text-sm text-slate-600 mt-1">
                Crea un alumno y asígnalo a una empresa.
            </p>
        </div>

        <div class="p-6 md:p-10">

            @if (session('success'))
                <div class="mb-6 p-4 rounded-xl bg-green-50 text-green-700 font-semibold border border-green-100">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-6 p-4 rounded-xl bg-red-50 text-red-700 border border-red-100">
                    <div class="font-extrabold mb-2">Revisa estos errores:</div>
                    <ul class="list-disc pl-5 space-y-1">
                        @foreach ($errors->all() as $error)
                            <li class="font-semibold">{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('teacher.students.store') }}">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Nombre completo</label>
                        <input type="text" name="nombre" value="{{ old('nombre') }}" required
                               class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3
                                      focus:outline-none focus:ring-2 focus:ring-indigo-300 focus:border-indigo-300">
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Email</label>
                        <input type="email" name="email" value="{{ old('email') }}" required
                               class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3
                                      focus:outline-none focus:ring-2 focus:ring-indigo-300 focus:border-indigo-300">
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">DNI</label>
                        <input type="text" name="dni" value="{{ old('dni') }}" required
                               class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3
                                      focus:outline-none focus:ring-2 focus:ring-indigo-300 focus:border-indigo-300">
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Empresa</label>
                        <select name="empresa_id" required
                                class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3
                                       focus:outline-none focus:ring-2 focus:ring-indigo-300 focus:border-indigo-300">
                            <option value="">-- Selecciona empresa --</option>
                            @foreach($companies as $company)
                                <option value="{{ $company->id_empresa }}"
                                    @selected(old('empresa_id') == $company->id_empresa)>
                                    {{ $company->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-sm font-bold text-slate-700 mb-2">Contraseña inicial</label>
                        <input type="password" name="contrasena" required
                               class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3
                                      focus:outline-none focus:ring-2 focus:ring-indigo-300 focus:border-indigo-300">
                    </div>

                    <div class="md:col-span-2 pt-2">
                        <button type="submit"
                                class="w-full py-3 rounded-xl font-extrabold text-white
                                       bg-indigo-600 hover:bg-indigo-700 transition shadow">
                            Crear alumno
                        </button>
                    </div>

                </div>
            </form>

            <div class="mt-8 pt-6 border-t flex items-center justify-center">
                <a href="{{ route('teacher.students.index') }}"
                   class="inline-flex items-center gap-2 px-5 py-2 rounded-xl border border-slate-200
                          text-slate-700 font-bold hover:bg-slate-50 transition">
                    <i class="bi bi-arrow-left"></i>
                    Gestionar alumnos
                </a>
            </div>

        </div>
    </div>
</div>

@endsection
