@extends('layouts.teacher', ['title' => 'Registrar alumno'])

@section('content')
  <div class="max-w-4xl mx-auto">
    <div class="rounded-3xl bg-white border border-slate-200 shadow-xl shadow-slate-200/40 overflow-hidden">
      <div class="p-6 md:p-8 border-b border-slate-100">
        <h1 class="text-3xl font-extrabold tracking-tight">Registrar nuevo alumno</h1>
        <p class="text-slate-500 mt-1 text-sm font-semibold">
          Crea un alumno y asígnalo a una empresa.
        </p>
      </div>

      <div class="p-6 md:p-8">
        @if (session('success'))
          <div class="mb-5 rounded-2xl border border-green-200 bg-green-50 p-4 text-green-700 font-bold">
            {{ session('success') }}
          </div>
        @endif

        @include('teacher.students._form', ['companies' => $companies])
      </div>

      <div class="p-6 md:p-8 border-t border-slate-100 bg-slate-50">
        <a href="{{ route('teacher.students.index') }}"
           class="inline-flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-4 py-2
                  font-extrabold text-slate-700 hover:bg-slate-50 transition">
          <i class="bi bi-arrow-left"></i>
          Gestionar alumnos
        </a>
      </div>
    </div>
  </div>
@endsection
