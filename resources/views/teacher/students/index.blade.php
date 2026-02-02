@extends('layouts.teacher', ['title' => 'Gestión alumnos'])

@section('content')
  <div class="max-w-6xl mx-auto space-y-5">

    @if (session('success'))
      <div class="rounded-2xl border border-green-200 bg-green-50 p-4 text-green-700 font-bold">
        {{ session('success') }}
      </div>
    @endif

    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
      <div>
        <h1 class="text-3xl font-extrabold tracking-tight">Alumnos</h1>
        <p class="text-slate-500 text-sm font-semibold">Gestiona alumnos, estado y edición.</p>
      </div>

      <a href="{{ route('teacher.students.create') }}"
         class="inline-flex items-center justify-center gap-2 rounded-2xl px-5 py-3
                font-extrabold text-white bg-indigo-600 hover:bg-indigo-700 transition
                shadow-lg shadow-indigo-600/20">
        <i class="bi bi-plus-lg"></i>
        Nuevo alumno
      </a>
    </div>

    {{-- DESKTOP TABLE --}}
    <div class="hidden md:block rounded-3xl bg-white border border-slate-200 shadow-xl shadow-slate-200/40 overflow-hidden">
      <div class="overflow-x-auto">
        <table class="w-full text-left">
          <thead class="bg-slate-50 text-slate-700">
            <tr class="text-xs uppercase tracking-wide">
              <th class="px-6 py-4 font-extrabold">Nombre</th>
              <th class="px-6 py-4 font-extrabold">Email</th>
              <th class="px-6 py-4 font-extrabold">DNI</th>
              <th class="px-6 py-4 font-extrabold">Empresa</th>
              <th class="px-6 py-4 font-extrabold">Estado</th>
              <th class="px-6 py-4 font-extrabold w-[320px]">Acciones</th>
            </tr>
          </thead>

          <tbody class="divide-y divide-slate-100">
            @forelse($students as $student)
              <tr class="hover:bg-slate-50/60">
                <td class="px-6 py-4 font-extrabold">
                  {{ $student->usuario?->nombre ?? '-' }}
                </td>

                <td class="px-6 py-4 text-slate-600 font-semibold">
                  {{ $student->usuario?->email ?? '-' }}
                </td>

                <td class="px-6 py-4 text-slate-600 font-semibold">
                  {{ $student->usuario?->dni ?? '-' }}
                </td>

                <td class="px-6 py-4 text-slate-600 font-semibold">
                  {{ $student->empresa?->nombre ?? '-' }}
                </td>

                <td class="px-6 py-4">
                  @if($student->usuario?->activo)
                    <span class="inline-flex items-center gap-2 rounded-full bg-green-50 border border-green-200 px-3 py-1 text-green-700 font-extrabold text-xs">
                      <span class="w-2 h-2 rounded-full bg-green-500"></span>
                      Activo
                    </span>
                  @else
                    <span class="inline-flex items-center gap-2 rounded-full bg-red-50 border border-red-200 px-3 py-1 text-red-700 font-extrabold text-xs">
                      <span class="w-2 h-2 rounded-full bg-red-500"></span>
                      Inactivo
                    </span>
                  @endif
                </td>

                <td class="px-6 py-4">
                  <div class="flex flex-wrap gap-2">
                    <form method="POST" action="{{ route('teacher.students.toggle', $student->id_alumno) }}">
                      @csrf
                      @method('PATCH')
                      <button type="submit"
                              class="rounded-xl px-3 py-2 text-sm font-extrabold
                                     border border-amber-200 bg-amber-50 text-amber-800 hover:bg-amber-100 transition">
                        {{ $student->usuario?->activo ? 'Desactivar' : 'Activar' }}
                      </button>
                    </form>

                    <a href="{{ route('teacher.students.edit', $student->id_alumno) }}"
                       class="rounded-xl px-3 py-2 text-sm font-extrabold
                              border border-slate-200 bg-white text-slate-700 hover:bg-slate-50 transition">
                      Editar
                    </a>

                    <form method="POST" action="{{ route('teacher.students.destroy', $student->id_alumno) }}"
                          onsubmit="return confirm('⚠️ Esto borrará el alumno DEFINITIVAMENTE. ¿Continuar?')">
                      @csrf
                      @method('DELETE')
                      <button type="submit"
                              class="rounded-xl px-3 py-2 text-sm font-extrabold
                                     border border-red-200 bg-red-50 text-red-700 hover:bg-red-100 transition">
                        Eliminar
                      </button>
                    </form>
                  </div>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="6" class="px-6 py-10 text-center text-slate-500 font-semibold">
                  No hay alumnos todavía.
                </td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>

    {{-- MOBILE CARDS --}}
    <div class="md:hidden space-y-3">
      @forelse($students as $student)
        <div class="rounded-3xl bg-white border border-slate-200 shadow-lg shadow-slate-200/40 p-4">
          <div class="flex items-start justify-between gap-3">
            <div>
              <div class="font-extrabold text-slate-900">{{ $student->usuario?->nombre ?? '-' }}</div>
              <div class="text-sm text-slate-500 font-semibold">{{ $student->usuario?->email ?? '-' }}</div>
              <div class="text-sm text-slate-500 font-semibold mt-1">
                DNI: <span class="text-slate-700">{{ $student->usuario?->dni ?? '-' }}</span>
              </div>
              <div class="text-sm text-slate-500 font-semibold">
                Empresa: <span class="text-slate-700">{{ $student->empresa?->nombre ?? '-' }}</span>
              </div>
            </div>

            <div>
              @if($student->usuario?->activo)
                <span class="inline-flex items-center gap-2 rounded-full bg-green-50 border border-green-200 px-3 py-1 text-green-700 font-extrabold text-xs">
                  <span class="w-2 h-2 rounded-full bg-green-500"></span>
                  Activo
                </span>
              @else
                <span class="inline-flex items-center gap-2 rounded-full bg-red-50 border border-red-200 px-3 py-1 text-red-700 font-extrabold text-xs">
                  <span class="w-2 h-2 rounded-full bg-red-500"></span>
                  Inactivo
                </span>
              @endif
            </div>
          </div>

          <div class="mt-4 flex flex-wrap gap-2">
            <form method="POST" action="{{ route('teacher.students.toggle', $student->id_alumno) }}">
              @csrf
              @method('PATCH')
              <button type="submit"
                      class="rounded-xl px-3 py-2 text-sm font-extrabold
                             border border-amber-200 bg-amber-50 text-amber-800 hover:bg-amber-100 transition">
                {{ $student->usuario?->activo ? 'Desactivar' : 'Activar' }}
              </button>
            </form>

            <a href="{{ route('teacher.students.edit', $student->id_alumno) }}"
               class="rounded-xl px-3 py-2 text-sm font-extrabold
                      border border-slate-200 bg-white text-slate-700 hover:bg-slate-50 transition">
              Editar
            </a>

            <form method="POST" action="{{ route('teacher.students.destroy', $student->id_alumno) }}"
                  onsubmit="return confirm('⚠️ Esto borrará el alumno DEFINITIVAMENTE. ¿Continuar?')">
              @csrf
              @method('DELETE')
              <button type="submit"
                      class="rounded-xl px-3 py-2 text-sm font-extrabold
                             border border-red-200 bg-red-50 text-red-700 hover:bg-red-100 transition">
                Eliminar
              </button>
            </form>
          </div>
        </div>
      @empty
        <div class="rounded-3xl bg-white border border-slate-200 shadow-lg shadow-slate-200/40 p-6 text-center text-slate-500 font-semibold">
          No hay alumnos todavía.
        </div>
      @endforelse
    </div>

  </div>
@endsection
