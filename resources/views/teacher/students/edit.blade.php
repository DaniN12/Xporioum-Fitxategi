@extends('layouts.teacher', ['title' => 'Editar alumno'])

@section('content')
  <div class="max-w-4xl mx-auto">
    <div class="rounded-3xl bg-white border border-slate-200 shadow-xl shadow-slate-200/40 overflow-hidden">
      <div class="p-6 md:p-8 border-b border-slate-100">
        <h1 class="text-3xl font-extrabold tracking-tight">Editar alumno</h1>
        <p class="text-slate-500 mt-1 text-sm font-semibold">
          Modifica sus datos y la empresa asignada.
        </p>
      </div>

      <div class="p-6 md:p-8">
        @include('teacher.students._form', ['student' => $student, 'companies' => $companies])
      </div>

      <div class="p-6 md:p-8 border-t border-slate-100 bg-slate-50">
        <a href="{{ route('teacher.students.index') }}"
           class="inline-flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-4 py-2
                  font-extrabold text-slate-700 hover:bg-slate-50 transition">
          <i class="bi bi-arrow-left"></i>
          Volver al listado
        </a>
      </div>
    </div>
  </div>
@endsection
