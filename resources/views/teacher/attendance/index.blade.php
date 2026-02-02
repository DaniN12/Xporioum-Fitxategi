@extends('layouts.teacher')

@section('content')
<div class="w-full">

    {{-- Cabecera --}}
    <div class="mb-6 flex items-start justify-between gap-4">
        <div>
            <h1 class="text-3xl font-extrabold text-gray-900">Asistencia del alumnado</h1>
            <p class="text-sm text-gray-500">Consulta entradas, salidas, descansos y horas trabajadas.</p>
        </div>

        {{-- Botón PDF --}}
        <button
            onclick="descargarAttendancePDF()"
            class="inline-flex items-center gap-2 px-4 py-2 rounded-xl font-bold
                   text-white bg-indigo-600 hover:bg-indigo-700 transition shadow">
            <i class="bi bi-file-earmark-pdf"></i>
            Descargar PDF
        </button>
    </div>

    {{-- Card --}}
    <div class="bg-white rounded-3xl shadow-xl border border-gray-100 overflow-hidden">

        {{-- Filtro --}}
        <div class="px-6 py-5 bg-gradient-to-r from-indigo-50 to-blue-50 border-b">
            <form method="GET" action="{{ route('teacher.attendance.index') }}"
                  class="flex flex-col sm:flex-row sm:items-center gap-3">

                <select name="student_id"
                        onchange="this.form.submit()"
                        class="w-full sm:w-96 rounded-xl border border-indigo-200 px-4 py-3 font-semibold
                               text-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-200 bg-white">
                    <option value="">— Todos los alumnos —</option>

                    @foreach($students as $student)
                        <option value="{{ $student->id_alumno }}"
                            {{ (string)$studentId === (string)$student->id_alumno ? 'selected' : '' }}>
                            {{ $student->nombre ?? ('Alumno #'.$student->id_alumno) }}
                        </option>
                    @endforeach
                </select>

                @if($studentId)
                    <a href="{{ route('teacher.attendance.index') }}"
                       class="w-full sm:w-auto text-center rounded-xl px-5 py-3 font-bold text-gray-700 bg-white
                              border border-gray-200 hover:bg-gray-50 transition">
                        Quitar filtro
                    </a>
                @endif
            </form>
        </div>

        {{-- Tabla --}}
        <div class="p-6">
            <div class="overflow-x-auto rounded-2xl border border-gray-100">
                <table id="tabla-attendance-pdf" class="min-w-full text-left">
                    <thead class="bg-indigo-50">
                        <tr class="text-indigo-700">
                            <th class="px-4 py-4 font-extrabold">Nombre</th>
                            <th class="px-4 py-4 font-extrabold">Email</th>
                            <th class="px-4 py-4 font-extrabold">Fecha</th>
                            <th class="px-4 py-4 font-extrabold">Entrada</th>
                            <th class="px-4 py-4 font-extrabold">Salida</th>
                            <th class="px-4 py-4 font-extrabold">Descanso</th>
                            <th class="px-4 py-4 font-extrabold">Total horas</th>
                        </tr>
                    </thead>

                    <tbody class="bg-white">
                        @forelse($attendances as $a)
                            <tr class="border-t hover:bg-gray-50 transition">
                                <td class="px-4 py-4 font-semibold text-gray-900">
                                    {{ $a->nombre ?? ('Alumno #'.$a->alumno_id) }}
                                </td>

                                <td class="px-4 py-4 text-gray-600">
                                    {{ $a->email ?? '—' }}
                                </td>

                                <td class="px-4 py-4 text-gray-700">
                                    {{ \Carbon\Carbon::parse($a->fecha)->format('d/m/Y') }}
                                </td>

                                <td class="px-4 py-4 font-extrabold text-green-600">
                                    {{ $a->hora_entrada ? substr($a->hora_entrada, 0, 5) : '—' }}
                                </td>

                                <td class="px-4 py-4 font-extrabold text-red-600">
                                    {{ $a->hora_salida ? substr($a->hora_salida, 0, 5) : '—' }}
                                </td>

                                <td class="px-4 py-4 font-bold text-gray-700">
                                    @if(!empty($a->hora_inicio_descanso) && !empty($a->hora_fin_descanso))
                                        {{ substr($a->hora_inicio_descanso,0,5) }} - {{ substr($a->hora_fin_descanso,0,5) }}
                                    @elseif(!empty($a->minutos_descanso))
                                        {{ $a->minutos_descanso }} min
                                    @else
                                        —
                                    @endif
                                </td>

                                <td class="px-4 py-4 font-extrabold text-indigo-700">
                                    {{ $a->total_horas !== null ? number_format((float)$a->total_horas, 2) : '—' }}
                                </td>
                            </tr>
                        @empty
                            <tr class="border-t">
                                <td colspan="7" class="px-4 py-10 text-center">
                                    <div class="font-extrabold text-gray-900">No hay registros de asistencia</div>
                                    <div class="text-sm text-gray-500 mt-1">
                                        Cuando el alumnado fiche, aquí verás entradas, salidas y descansos.
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

{{-- jsPDF + AutoTable --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.31/jspdf.plugin.autotable.min.js"></script>

<script>
function descargarAttendancePDF() {
    const { jsPDF } = window.jspdf;
    const doc = new jsPDF('l', 'mm', 'a4');

    doc.setFontSize(16);
    doc.text('Asistencia del alumnado', 14, 15);

    doc.autoTable({
        html: '#tabla-attendance-pdf',
        startY: 22,
        theme: 'grid',
        styles: {
            fontSize: 9,
            cellPadding: 3
        },
        headStyles: {
            fillColor: [79, 70, 229], // indigo-600
            textColor: 255,
            fontStyle: 'bold'
        },
        alternateRowStyles: {
            fillColor: [245, 247, 255]
        },
        margin: { left: 14, right: 14 },
    });

    doc.save('asistencia_alumnado.pdf');
}
</script>
@endsection
