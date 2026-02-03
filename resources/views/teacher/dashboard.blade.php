@extends('layouts.teacher', ['title' => __('message.t_student_create_title')])

@section('content')

<div class="max-w-5xl mx-auto">
    <div class="bg-white rounded-2xl shadow-xl border border-slate-100 overflow-hidden">

        <div class="px-6 md:px-10 py-8 border-b bg-gradient-to-r from-indigo-50 to-white">
            <h1 class="text-2xl md:text-3xl font-extrabold text-slate-900">
                {{ __('message.t_student_create_heading') }}
            </h1>
            <p class="text-sm text-slate-600 mt-1">
                {{ __('message.t_student_create_subtitle') }}
            </p>
        </div>

        <div class="p-6 md:p-10">

            {{-- SUCCESS --}}
            @if (session('success'))
                <div class="mb-6 p-4 rounded-xl bg-green-50 text-green-700 font-semibold border border-green-100">
                    {{ session('success') }}
                </div>
            @endif

            <form method="POST" action="{{ route('teacher.students.store') }}">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                    {{-- NOMBRE --}}
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">
                            {{ __('message.t_student_name') }}
                        </label>

                        <input type="text"
                               name="nombre"
                               value="{{ old('nombre') }}"
                               class="w-full rounded-xl px-4 py-3 bg-slate-50 border
                                      focus:outline-none focus:ring-2
                                      @error('nombre')
                                          border-red-400 focus:ring-red-200
                                      @else
                                          border-slate-200 focus:ring-indigo-300 focus:border-indigo-300
                                      @enderror">

                        @error('nombre')
                            <p class="mt-1 text-sm text-red-600 font-semibold">
                                {{ __('message.t_student_err_name_required') }}
                            </p>
                        @enderror
                    </div>

                    {{-- EMAIL --}}
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">
                            {{ __('message.email') }}
                        </label>

                        <input type="email"
                               name="email"
                               value="{{ old('email') }}"
                               class="w-full rounded-xl px-4 py-3 bg-slate-50 border
                                      focus:outline-none focus:ring-2
                                      @error('email')
                                          border-red-400 focus:ring-red-200
                                      @else
                                          border-slate-200 focus:ring-indigo-300 focus:border-indigo-300
                                      @enderror">

                        @error('email')
                            <p class="mt-1 text-sm text-red-600 font-semibold">
                                {{ __('message.t_student_err_email_valid') }}
                            </p>
                        @enderror
                    </div>

                    {{-- DNI --}}
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">
                            {{ __('message.t_student_dni') }}
                        </label>

                        <input type="text"
                               name="dni"
                               value="{{ old('dni') }}"
                               class="w-full rounded-xl px-4 py-3 bg-slate-50 border
                                      focus:outline-none focus:ring-2
                                      @error('dni')
                                          border-red-400 focus:ring-red-200
                                      @else
                                          border-slate-200 focus:ring-indigo-300 focus:border-indigo-300
                                      @enderror">

                        @error('dni')
                            <p class="mt-1 text-sm text-red-600 font-semibold">
                                {{ __('message.t_student_err_dni_required') }}
                            </p>
                        @enderror
                    </div>

                    {{-- EMPRESA --}}
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">
                            {{ __('message.t_student_company') }}
                        </label>

                        <select name="empresa_id"
                                class="w-full rounded-xl px-4 py-3 bg-slate-50 border
                                       focus:outline-none focus:ring-2
                                       @error('empresa_id')
                                           border-red-400 focus:ring-red-200
                                       @else
                                           border-slate-200 focus:ring-indigo-300 focus:border-indigo-300
                                       @enderror">
                            <option value="">{{ __('message.t_student_company_pick') }}</option>
                            @foreach($companies as $company)
                                <option value="{{ $company->id_empresa }}"
                                    @selected(old('empresa_id') == $company->id_empresa)>
                                    {{ $company->nombre }}
                                </option>
                            @endforeach
                        </select>

                        @error('empresa_id')
                            <p class="mt-1 text-sm text-red-600 font-semibold">
                                {{ __('message.t_student_err_company_required') }}
                            </p>
                        @enderror
                    </div>

                    {{-- CONTRASEÑA --}}
                    <div class="md:col-span-2">
                        <label class="block text-sm font-bold text-slate-700 mb-2">
                            {{ __('message.t_student_password_initial') }}
                        </label>

                        <input type="password"
                               name="contrasena"
                               class="w-full rounded-xl px-4 py-3 bg-slate-50 border
                                      focus:outline-none focus:ring-2
                                      @error('contrasena')
                                          border-red-400 focus:ring-red-200
                                      @else
                                          border-slate-200 focus:ring-indigo-300 focus:border-indigo-300
                                      @enderror">

                        @error('contrasena')
                            <p class="mt-1 text-sm text-red-600 font-semibold">
                                {{ __('message.t_student_err_password_required') }}
                            </p>
                        @enderror
                    </div>

                    {{-- BOTÓN --}}
                    <div class="md:col-span-2 pt-2">
                        <button type="submit"
                                class="w-full py-3 rounded-xl font-extrabold text-white
                                       bg-indigo-600 hover:bg-indigo-700 transition shadow">
                            {{ __('message.t_student_create_button') }}
                        </button>
                    </div>

                </div>
            </form>

            <div class="mt-8 pt-6 border-t flex items-center justify-center">
                <a href="{{ route('teacher.students.index') }}"
                   class="inline-flex items-center gap-2 px-5 py-2 rounded-xl border border-slate-200
                          text-slate-700 font-bold hover:bg-slate-50 transition">
                    <i class="bi bi-arrow-left"></i>
                    {{ __('message.t_student_back_manage') }}
                </a>
            </div>

        </div>
    </div>
</div>

@endsection
