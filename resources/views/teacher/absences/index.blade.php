@extends('layouts.teacher')

@section('content')

<div class="w-full">

    {{-- Cabecera --}}
    <div class="mb-6 flex items-start justify-between gap-4">
        <div>
            <h1 class="text-3xl font-extrabold text-slate-800">Ausencias</h1>
            <p class="text-sm text-gray-500">Gestiona justificantes y solicitudes de ausencia.</p>
        </div>

        {{-- Botón PDF --}}
        <button
            onclick="descargarAbsencesPDF()"
            class="inline-flex items-center gap-2 px-4 py-2 rounded-xl font-bold
                   text-white bg-indigo-600 hover:bg-indigo-700 transition shadow">
            <i class="bi bi-file-earmark-pdf"></i>
            Descargar PDF
        </button>
    </div>

    {{-- Alertas --}}
    @if(session('success'))
        <div class="mb-4 rounded-xl bg-green-50 border border-green-200 px-4 py-3 text-green-700 font-semibold">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="mb-4 rounded-xl bg-red-50 border border-red-200 px-4 py-3 text-red-700 font-semibold">
            {{ session('error') }}
        </div>
    @endif

    {{-- Card --}}
    <div class="bg-white rounded-3xl shadow-xl border border-gray-100 overflow-hidden">

        <div class="overflow-x-auto">
            <table id="tabla-absences-pdf" class="min-w-full text-left">
                <thead class="bg-slate-50">
                    <tr class="text-slate-700 text-sm uppercase tracking-wide">
                        <th class="px-6 py-4 font-bold">Alumno</th>
                        <th class="px-6 py-4 font-bold">Fecha</th>
                        <th class="px-6 py-4 font-bold">Motivo</th>
                        <th class="px-6 py-4 font-bold">Adjunto</th>
                        <th class="px-6 py-4 font-bold">Estado</th>
                        <th class="px-6 py-4 font-bold text-center">Acciones</th>
                    </tr>
                </thead>

                <tbody class="bg-white divide-y divide-gray-100">
                    @forelse($absences as $absence)
                        <tr class="hover:bg-slate-50 transition">
                            <td class="px-6 py-5">
                                <div class="font-semibold text-slate-800">
                                    {{ $absence->alumno_nombre ?? 'Alumno' }}
                                </div>

                                @if(!empty($absence->alumno_email) || !empty($absence->alumno_dni))
                                    <div class="text-xs text-gray-500 mt-1">
                                        {{ $absence->alumno_email ?? '' }}
                                        @if(!empty($absence->alumno_email) && !empty($absence->alumno_dni))
                                            ·
                                        @endif
                                        {{ $absence->alumno_dni ?? '' }}
                                    </div>
                                @endif
                            </td>

                            <td class="px-6 py-5 font-semibold text-slate-700">
                                {{ \Carbon\Carbon::parse($absence->fecha)->format('d/m/Y') }}
                            </td>

                            <td class="px-6 py-5 text-slate-700">
                                {{ $absence->motivo }}
                            </td>

                            <td class="px-6 py-5">
                                @if(!empty($absence->adjunto_path))
                                    <span class="text-slate-700 font-semibold">Sí</span>
                                @else
                                    <span class="text-gray-400 italic text-sm">No</span>
                                @endif
                            </td>

                            <td class="px-6 py-5">
                                @if($absence->estado === 'aceptada')
                                    <span class="px-3 py-1 rounded-full bg-green-100 text-green-700 font-bold text-xs">
                                        Aceptada
                                    </span>
                                @elseif($absence->estado === 'rechazada')
                                    <span class="px-3 py-1 rounded-full bg-red-100 text-red-600 font-bold text-xs">
                                        Rechazada
                                    </span>
                                @else
                                    <span class="px-3 py-1 rounded-full bg-yellow-100 text-yellow-700 font-bold text-xs">
                                        Pendiente
                                    </span>
                                @endif
                            </td>

                            <td class="px-6 py-5 text-center">
                                @if($absence->estado === 'pendiente')
                                    Pendiente
                                @else
                                    —
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-10 text-center text-gray-400 font-semibold">
                                No hay ausencias registradas
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
</div>

{{-- jsPDF + AutoTable --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.31/jspdf.plugin.autotable.min.js"></script>

<script>
function descargarAbsencesPDF() {
    const { jsPDF } = window.jspdf;
    const doc = new jsPDF('l', 'mm', 'a4');

    doc.setFontSize(16);
    doc.text('Listado de ausencias', 14, 15);

    doc.autoTable({
        html: '#tabla-absences-pdf',
        startY: 22,
        theme: 'grid',
        styles: {
            fontSize: 9,
            cellPadding: 3
        },
        headStyles: {
            fillColor: [51, 65, 85], // slate-700
            textColor: 255,
            fontStyle: 'bold'
        },
        alternateRowStyles: {
            fillColor: [248, 250, 252]
        },
        margin: { left: 14, right: 14 },
        didParseCell: function (data) {
            // Evitamos botones/acciones visuales raras en PDF
            if (data.column.index === 5) {
                data.cell.text = ['—'];
            }
        }
    });

    doc.save('ausencias.pdf');
}
</script>

@endsection
