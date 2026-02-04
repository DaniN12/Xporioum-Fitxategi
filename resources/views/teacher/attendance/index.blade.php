@extends('layouts.teacher', ['title' => __('message.t_attendance_title')])

@section('content')
<div class="w-full">

    <div class="mb-6 flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
        <div>
            <h1 class="text-3xl font-extrabold text-gray-900">{{ __('message.t_attendance_heading') }}</h1>
            <p class="text-sm text-gray-500">{{ __('message.t_attendance_subtitle') }}</p>
        </div>

        <button
            onclick="descargarAttendancePDF()"
            class="inline-flex items-center gap-2 px-5 py-3 rounded-xl font-extrabold
                   text-white bg-indigo-600 hover:bg-indigo-700 transition shadow">
            {{ __('message.t_attendance_download_pdf') }}
        </button>
    </div>

    <div class="bg-white rounded-3xl shadow-xl border border-gray-100 overflow-hidden">

        <div class="px-6 py-5 bg-gradient-to-r from-indigo-50 to-blue-50 border-b">
            <form method="GET" action="{{ route('teacher.attendance.index') }}"
                  class="flex flex-col lg:flex-row lg:items-center gap-3">

                {{-- Filtro empresa --}}
                <select name="empresa_id"
                        onchange="this.form.submit()"
                        class="w-full lg:w-80 rounded-xl border border-indigo-200 px-4 py-3 font-semibold
                               text-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-200 bg-white">
                    <option value="">{{ __('message.t_attendance_filter_companies') }}</option>
                    @foreach($empresas as $e)
                        <option value="{{ $e->id_empresa }}"
                            {{ (string)$empresaId === (string)$e->id_empresa ? 'selected' : '' }}>
                            {{ $e->nombre }}
                        </option>
                    @endforeach
                </select>

                {{-- Filtro alumno --}}
                <select name="student_id"
                        onchange="this.form.submit()"
                        class="w-full lg:w-96 rounded-xl border border-indigo-200 px-4 py-3 font-semibold
                               text-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-200 bg-white">
                    <option value="">{{ __('message.t_attendance_filter_students') }}</option>
                    @foreach($students as $s)
                        <option value="{{ $s->id_alumno }}"
                            {{ (string)$studentId === (string)$s->id_alumno ? 'selected' : '' }}>
                            {{ $s->nombre }} ({{ $s->email }})
                        </option>
                    @endforeach
                </select>

                @if($empresaId || $studentId)
                    <a href="{{ route('teacher.attendance.index') }}"
                       class="w-full lg:w-auto text-center rounded-xl px-5 py-3 font-bold text-gray-700 bg-white
                              border border-gray-200 hover:bg-gray-50 transition">
                        {{ __('message.t_attendance_clear_filters') }}
                    </a>
                @endif
            </form>
        </div>

        <div class="p-6">
            <div class="overflow-x-auto rounded-2xl border border-gray-100">
                <table id="tabla-attendance-pdf" class="min-w-full text-left">
                    <thead class="bg-indigo-50">
                        <tr class="text-indigo-700">
                            <th class="px-4 py-4 font-extrabold">{{ __('message.t_attendance_col_company') }}</th>
                            <th class="px-4 py-4 font-extrabold">{{ __('message.t_attendance_col_name') }}</th>
                            <th class="px-4 py-4 font-extrabold">{{ __('message.t_attendance_col_email') }}</th>
                            <th class="px-4 py-4 font-extrabold">{{ __('message.t_attendance_col_date') }}</th>
                            <th class="px-4 py-4 font-extrabold">{{ __('message.t_attendance_col_in') }}</th>
                            <th class="px-4 py-4 font-extrabold">{{ __('message.t_attendance_col_out') }}</th>
                            <th class="px-4 py-4 font-extrabold">{{ __('message.t_attendance_col_break') }}</th>
                            <th class="px-4 py-4 font-extrabold">{{ __('message.t_attendance_col_total') }}</th>
                            <th class="px-4 py-4 font-extrabold">{{ __('message.t_attendance_col_actions') }}</th>
                        </tr>
                    </thead>

                    <tbody class="bg-white">
                        @forelse($attendances as $a)
                            <tr class="border-t hover:bg-gray-50 transition">
                                <td class="px-4 py-4 text-gray-700 font-semibold">
                                    {{ $a->empresa_nombre ?? __('message.dash') }}
                                </td>

                                <td class="px-4 py-4 font-semibold text-gray-900">
                                    {{ $a->nombre ?? __('message.t_attendance_student_fallback', ['id' => $a->alumno_id]) }}
                                </td>

                                <td class="px-4 py-4 text-gray-600">
                                    {{ $a->email ?? __('message.dash') }}
                                </td>

                                <td class="px-4 py-4 text-gray-700">
                                    {{ \Carbon\Carbon::parse($a->fecha)->format('d/m/Y') }}
                                </td>

                                <td class="px-4 py-4 font-extrabold text-green-600">
                                    {{ $a->hora_entrada ? substr($a->hora_entrada, 0, 5) : __('message.dash') }}
                                </td>

                                <td class="px-4 py-4 font-extrabold text-red-600">
                                    {{ $a->hora_salida ? substr($a->hora_salida, 0, 5) : __('message.dash') }}
                                </td>

                                <td class="px-4 py-4 font-bold text-gray-700">
                                    @if(!empty($a->hora_inicio_descanso) && !empty($a->hora_fin_descanso))
                                        {{ substr($a->hora_inicio_descanso,0,5) }} - {{ substr($a->hora_fin_descanso,0,5) }}
                                    @elseif(!empty($a->minutos_descanso))
                                        {{ $a->minutos_descanso }} {{ __('message.minutes') }}
                                    @else
                                        {{ __('message.dash') }}
                                    @endif
                                </td>

                                <td class="px-4 py-4 font-extrabold text-indigo-700">
                                    {{ $a->total_horas !== null ? number_format((float)$a->total_horas, 2) : __('message.dash') }}
                                </td>

                                <td class="px-4 py-4">
                                    <button type="button"
                                            class="px-3 py-2 rounded-xl font-bold text-white bg-indigo-600 hover:bg-indigo-700 transition"
                                            onclick="document.getElementById('edit-{{ $a->id_fichaje }}').showModal()">
                                        {{ __('message.action_edit') }}
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr class="border-t">
                                <td colspan="9" class="px-4 py-10 text-center">
                                    <div class="font-extrabold text-gray-900">{{ __('message.t_attendance_empty_title') }}</div>
                                    <div class="text-sm text-gray-500 mt-1">
                                        {{ __('message.t_attendance_empty_subtitle') }}
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.31/jspdf.plugin.autotable.min.js"></script>

<script>
function descargarAttendancePDF() {
    const { jsPDF } = window.jspdf;
    const doc = new jsPDF('l', 'mm', 'a4');

    doc.setFontSize(16);
    doc.text(@js(__('message.t_attendance_pdf_title')), 14, 15);

    doc.autoTable({
        html: '#tabla-attendance-pdf',
        startY: 22,
        theme: 'grid',
        styles: { fontSize: 9, cellPadding: 3 },
        headStyles: {
            fillColor: [79, 70, 229],
            textColor: 255,
            fontStyle: 'bold'
        },
        alternateRowStyles: { fillColor: [245, 247, 255] },
        margin: { left: 14, right: 14 },
        didParseCell(data) {
            if (data.column.index === 8) data.cell.text = ['—'];
        }
    });

    doc.save(@js(__('message.t_attendance_pdf_filename')));
}
</script>
@endsection
