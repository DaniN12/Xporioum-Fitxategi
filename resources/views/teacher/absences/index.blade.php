@extends('layouts.teacher', ['title' => __('message.t_absences_title')])

@section('content')

<div class="w-full">

    {{-- Cabecera --}}
    <div class="mb-6 flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
        <div>
            <h1 class="text-3xl font-extrabold text-gray-900">{{ __('message.t_absences_heading') }}</h1>
            <p class="text-sm text-gray-500">{{ __('message.t_absences_subtitle') }}</p>
        </div>

        <button
            onclick="descargarAbsencesPDF()"
            class="inline-flex items-center gap-2 px-5 py-3 rounded-xl font-extrabold
                   text-white bg-indigo-600 hover:bg-indigo-700 transition shadow">
            {{ __('message.t_absences_download_pdf') }}
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

                <thead class="bg-indigo-50">
                    <tr class="text-indigo-700 text-sm uppercase tracking-wide">
                        <th class="px-6 py-4 font-extrabold">{{ __('message.t_absences_col_student') }}</th>
                        <th class="px-6 py-4 font-extrabold">{{ __('message.t_absences_col_date') }}</th>
                        <th class="px-6 py-4 font-extrabold">{{ __('message.t_absences_col_reason') }}</th>
                        <th class="px-6 py-4 font-extrabold">{{ __('message.t_absences_col_attachment') }}</th>
                        <th class="px-6 py-4 font-extrabold">{{ __('message.t_absences_col_status') }}</th>
                        <th class="px-6 py-4 font-extrabold text-center">{{ __('message.t_absences_col_actions') }}</th>
                    </tr>
                </thead>

                <tbody class="bg-white divide-y divide-gray-100">
                    @forelse($absences as $absence)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-5">
                                <div class="font-semibold text-gray-900">
                                    {{ $absence->alumno_nombre ?? __('message.t_absences_student_fallback') }}
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

                            <td class="px-6 py-5 font-semibold text-gray-700">
                                {{ \Carbon\Carbon::parse($absence->fecha)->format('d/m/Y') }}
                            </td>

                            <td class="px-6 py-5 text-gray-700">
                                {{ $absence->motivo }}
                            </td>

                            {{-- Adjunto --}}
                            <td class="px-6 py-5">
                                @if(!empty($absence->adjunto_path))
                                    <div class="flex items-center gap-3">
                                        <a href="{{ asset('storage/' . $absence->adjunto_path) }}"
                                           target="_blank"
                                           class="text-indigo-600 font-bold hover:underline">
                                            {{ __('message.action_view') }}
                                        </a>

                                        <a href="{{ asset('storage/' . $absence->adjunto_path) }}"
                                           download
                                           class="text-gray-700 font-semibold hover:underline">
                                            {{ __('message.action_download') }}
                                        </a>
                                    </div>

                                    @if(!empty($absence->adjunto_nombre))
                                        <div class="text-xs text-gray-400 mt-1">
                                            {{ $absence->adjunto_nombre }}
                                        </div>
                                    @endif
                                @else
                                    <span class="text-gray-400 italic text-sm">{{ __('message.t_absences_no_file') }}</span>
                                @endif
                            </td>

                            <td class="px-6 py-5">
                                @if($absence->estado === 'aceptada')
                                    <span class="px-3 py-1 rounded-full bg-green-100 text-green-700 font-bold text-xs">
                                        {{ __('message.status_accepted') }}
                                    </span>
                                @elseif($absence->estado === 'rechazada')
                                    <span class="px-3 py-1 rounded-full bg-red-100 text-red-600 font-bold text-xs">
                                        {{ __('message.status_rejected') }}
                                    </span>
                                @else
                                    <span class="px-3 py-1 rounded-full bg-yellow-100 text-yellow-700 font-bold text-xs">
                                        {{ __('message.status_pending') }}
                                    </span>
                                @endif
                            </td>

                            {{-- Acciones --}}
                            <td class="px-6 py-5 text-center">
                                @if($absence->estado === 'pendiente')
                                    <div class="flex items-center justify-center gap-2">
                                        <form method="POST" action="{{ route('teacher.absences.accept', $absence->id_incidencia) }}">
                                            @csrf
                                            <button type="submit"
                                                class="px-3 py-2 rounded-xl bg-green-600 text-white font-bold hover:bg-green-700 transition text-sm">
                                                {{ __('message.action_accept') }}
                                            </button>
                                        </form>

                                        <form method="POST"
                                              action="{{ route('teacher.absences.reject', $absence->id_incidencia) }}"
                                              onsubmit="return confirm(@js(__('message.t_absences_confirm_reject')));">
                                            @csrf
                                            <button type="submit"
                                                class="px-3 py-2 rounded-xl bg-red-600 text-white font-bold hover:bg-red-700 transition text-sm">
                                                {{ __('message.action_reject') }}
                                            </button>
                                        </form>
                                    </div>
                                @else
                                    <span class="text-gray-400 text-sm">—</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-10 text-center text-gray-400 font-semibold">
                                {{ __('message.t_absences_empty') }}
                            </td>
                        </tr>
                    @endforelse
                </tbody>

            </table>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.31/jspdf.plugin.autotable.min.js"></script>

<script>
function descargarAbsencesPDF() {
    const { jsPDF } = window.jspdf;
    const doc = new jsPDF('l', 'mm', 'a4');

    doc.setFontSize(16);
    doc.text(@js(__('message.t_absences_pdf_title')), 14, 15);

    doc.autoTable({
        html: '#tabla-absences-pdf',
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
        didParseCell: function (data) {
            if (data.column.index === 5) data.cell.text = ['—'];

            if (data.column.index === 3) {
                const txt = data.cell.raw?.innerText || '';
                data.cell.text = [txt.includes(@js(__('message.action_view'))) ? @js(__('message.yes'))) : @js(__('message.no'))];
            }

            if (data.column.index === 4) {
                const txt = data.cell.raw?.innerText || '';
                if (txt.includes(@js(__('message.status_accepted')))) data.cell.text = [@js(__('message.status_accepted'))];
                else if (txt.includes(@js(__('message.status_rejected')))) data.cell.text = [@js(__('message.status_rejected'))];
                else data.cell.text = [@js(__('message.status_pending'))];
            }
        }
    });

    doc.save(@js(__('message.t_absences_pdf_filename')));
}
</script>

@endsection
