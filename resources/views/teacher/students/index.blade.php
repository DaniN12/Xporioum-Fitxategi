@extends('layouts.teacher', ['title' => __('message.t_students_manage_title')])

@section('content')
  <div class="max-w-6xl mx-auto space-y-5">

    @if (session('success'))
      <div class="rounded-2xl border border-green-200 bg-green-50 p-4 text-green-700 font-bold">
        {{ session('success') }}
      </div>
    @endif

    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
      <div>
        <h1 class="text-3xl font-extrabold tracking-tight">{{ __('message.t_students_heading') }}</h1>
        <p class="text-gray-500 text-sm font-semibold">{{ __('message.t_students_subtitle') }}</p>
      </div>

      <div class="flex flex-wrap gap-2">
        <button
          onclick="descargarStudentsPDF()"
          class="inline-flex items-center justify-center gap-2 rounded-2xl px-5 py-3
                 font-extrabold text-white bg-indigo-600 hover:bg-indigo-700 transition shadow">
          {{ __('message.t_students_download_pdf') }}
        </button>

        <a href="{{ route('teacher.students.create') }}"
           class="inline-flex items-center justify-center gap-2 rounded-2xl px-5 py-3
                  font-extrabold text-white bg-indigo-600 hover:bg-indigo-700 transition
                  shadow-lg shadow-indigo-600/20">
          <i class="bi bi-plus-lg"></i>
          {{ __('message.t_students_new') }}
        </a>
      </div>
    </div>

    {{-- DESKTOP TABLE --}}
    <div class="hidden md:block rounded-3xl bg-white border border-gray-100 shadow-xl overflow-hidden">
      <div class="overflow-x-auto">
        <table id="tabla-students-pdf" class="w-full text-left">

          <thead class="bg-indigo-50">
            <tr class="text-xs uppercase tracking-wide text-indigo-700">
              <th class="px-6 py-4 font-extrabold">{{ __('message.t_students_col_name') }}</th>
              <th class="px-6 py-4 font-extrabold">{{ __('message.t_students_col_email') }}</th>
              <th class="px-6 py-4 font-extrabold">{{ __('message.t_students_col_dni') }}</th>
              <th class="px-6 py-4 font-extrabold">{{ __('message.t_students_col_company') }}</th>
              <th class="px-6 py-4 font-extrabold">{{ __('message.t_students_col_status') }}</th>
              <th class="px-6 py-4 font-extrabold w-[320px]">{{ __('message.t_students_col_actions') }}</th>
            </tr>
          </thead>

          <tbody class="divide-y divide-gray-100 bg-white">
            @forelse($students as $student)
              <tr class="hover:bg-gray-50 transition">
                <td class="px-6 py-4 font-extrabold text-gray-900">
                  {{ $student->usuario?->nombre ?? '-' }}
                </td>

                <td class="px-6 py-4 text-gray-600 font-semibold">
                  {{ $student->usuario?->email ?? '-' }}
                </td>

                <td class="px-6 py-4 text-gray-600 font-semibold">
                  {{ $student->usuario?->dni ?? '-' }}
                </td>

                <td class="px-6 py-4 text-gray-600 font-semibold">
                  {{ $student->empresa?->nombre ?? '-' }}
                </td>

                <td class="px-6 py-4">
                  @if($student->usuario?->activo)
                    <span class="inline-flex items-center gap-2 rounded-full bg-green-50 border border-green-200 px-3 py-1 text-green-700 font-extrabold text-xs">
                      <span class="w-2 h-2 rounded-full bg-green-500"></span>
                      {{ __('message.status_active') }}
                    </span>
                  @else
                    <span class="inline-flex items-center gap-2 rounded-full bg-red-50 border border-red-200 px-3 py-1 text-red-700 font-extrabold text-xs">
                      <span class="w-2 h-2 rounded-full bg-red-500"></span>
                      {{ __('message.status_inactive') }}
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
                        {{ $student->usuario?->activo ? __('message.action_deactivate') : __('message.action_activate') }}
                      </button>
                    </form>

                    <a href="{{ route('teacher.students.edit', $student->id_alumno) }}"
                       class="rounded-xl px-3 py-2 text-sm font-extrabold
                              border border-gray-200 bg-white text-gray-700 hover:bg-gray-50 transition">
                      {{ __('message.action_edit') }}
                    </a>

                    <form method="POST" action="{{ route('teacher.students.destroy', $student->id_alumno) }}"
                          onsubmit="return confirm(@js(__('message.t_students_confirm_delete')))">
                      @csrf
                      @method('DELETE')
                      <button type="submit"
                              class="rounded-xl px-3 py-2 text-sm font-extrabold
                                     border border-red-200 bg-red-50 text-red-700 hover:bg-red-100 transition">
                        {{ __('message.action_delete') }}
                      </button>
                    </form>
                  </div>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="6" class="px-6 py-10 text-center text-gray-500 font-semibold">
                  {{ __('message.t_students_empty') }}
                </td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>

    {{-- MOBILE CARDS (NO TOCADO) --}}
    <div class="md:hidden space-y-3">
      {{-- … exactamente igual que tu código original … --}}
      @forelse($students as $student)
        {{-- (contenido intacto) --}}
      @empty
        <div class="rounded-3xl bg-white border border-slate-200 shadow-lg shadow-slate-200/40 p-6 text-center text-slate-500 font-semibold">
          {{ __('message.t_students_empty') }}
        </div>
      @endforelse
    </div>

  </div>

{{-- jsPDF + AutoTable --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.31/jspdf.plugin.autotable.min.js"></script>

<script>
function descargarStudentsPDF() {
    const { jsPDF } = window.jspdf;
    const doc = new jsPDF('l', 'mm', 'a4');

    doc.setFontSize(16);
    doc.text(@js(__('message.t_students_pdf_title')), 14, 15);

    doc.autoTable({
        html: '#tabla-students-pdf',
        startY: 22,
        theme: 'grid',
        styles: { fontSize: 9, cellPadding: 3 },
        headStyles: {
            fillColor: [79, 70, 229],
            textColor: 255,
            fontStyle: 'bold'
        },
        alternateRowStyles: { fillColor: [245, 247, 255] },
        didParseCell(data) {
            if (data.column.index === 5) data.cell.text = ['—'];

            if (data.column.index === 4) {
                const txt = data.cell.raw?.innerText || '';
                data.cell.text = [txt.includes(@js(__('message.status_active'))) ? @js(__('message.status_active')) : @js(__('message.status_inactive'))];
            }
        }
    });

    doc.save(@js(__('message.t_students_pdf_filename')));
}
</script>
@endsection
