<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Horas</title>
    @vite('resources/css/app.css')

    {{-- Icons (bootstrap icons) --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>

<body class="min-h-screen bg-gray-100 text-gray-900">

    {{-- ========================= DESKTOP (SIDEBAR + TABLE) ========================= --}}
    <div class="hidden md:flex min-h-screen">

        {{-- SIDEBAR --}}
        <aside class="w-64 bg-white border-r px-6 py-8">
            <div class="flex flex-col items-center mb-8">
                <img src="{{ asset('img/logo-fitxategi.png') }}" class="w-20" alt="Logo">
            </div>

            <nav class="space-y-2 text-gray-600">

                <a href="{{ route('fichar.vista') }}"
                   class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-gray-100">
                    <i class="bi bi-house"></i> Inicio
                </a>

                <a href="{{ route('cuenta.index') }}"
                   class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-gray-100">
                    <i class="bi bi-person"></i> Perfil
                </a>

                <a href="{{ route('horas.index') }}"
                   class="flex items-center gap-3 px-4 py-3 rounded-xl bg-indigo-50 text-indigo-600 font-semibold">
                    <i class="bi bi-clock"></i> Horas
                </a>

                <a href="{{ route('incidencias.create') }}"
                   class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-gray-100">
                    <i class="bi bi-exclamation-triangle"></i> Incidencias
                </a>

                <a href="{{ route('normas') }}"
                   class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-gray-100">
                    <i class="bi bi-file-earmark-text"></i> Normas
                </a>

                <form method="POST" action="{{ route('logout') }}" class="pt-4">
                    @csrf
                    <button type="submit"
                            class="w-full flex items-center gap-3 px-4 py-3 rounded-xl border text-gray-600 hover:bg-gray-50">
                        <i class="bi bi-box-arrow-right"></i> Cerrar sesión
                    </button>
                </form>

            </nav>
        </aside>

        {{-- CONTENT --}}
        <main class="flex-1 px-10 py-10">
            <div class="max-w-6xl mx-auto">

                <div class="flex items-start justify-between gap-4 mb-6">
                    <div>
                        <h1 class="text-3xl font-extrabold">Horas</h1>
                        <p class="text-gray-500">Historial completo de horas trabajadas.</p>
                    </div>

                    {{-- BOTÓN PDF (reemplaza Excel) --}}
                    <button onclick="descargarHorasPDF()"
                            class="inline-flex items-center gap-2 px-4 py-2 rounded-xl font-bold text-white bg-indigo-600 hover:bg-indigo-700 transition shadow">
                        <i class="bi bi-file-earmark-pdf"></i>
                        Descargar PDF
                    </button>
                </div>

                <div class="bg-white rounded-2xl shadow border overflow-hidden">
                    <div class="overflow-x-auto">
                        <table id="tabla-horas-pdf" class="w-full text-left">
                            <thead class="bg-gray-50 text-gray-600 text-sm">
                                <tr>
                                    <th class="p-4 font-bold">Fecha</th>
                                    <th class="p-4 font-bold">Entrada</th>
                                    <th class="p-4 font-bold">Salida</th>
                                    <th class="p-4 font-bold">Descanso</th>
                                    <th class="p-4 font-bold">Total</th>
                                </tr>
                            </thead>

                            <tbody class="divide-y">
                            @forelse($fichajes as $f)
                                <tr class="hover:bg-gray-50">
                                    <td class="p-4 font-semibold">
                                        {{ \Carbon\Carbon::parse($f->fecha)->format('d/m/Y') }}
                                    </td>

                                    <td class="p-4">
                                        {{ $f->hora_entrada ?? 'AUSENCIA' }}
                                    </td>

                                    <td class="p-4">
                                        {{ $f->hora_salida ?? 'AUSENCIA' }}
                                    </td>

                                    <td class="p-4">
                                        @if($f->hora_entrada === null || $f->hora_salida === null)
                                            —
                                        @else
                                            {{ ($f->minutos_desc ?? 0) }} min
                                        @endif
                                    </td>

                                    <td class="p-4 font-extrabold">
                                        @if($f->total_horas === null)
                                            —
                                        @else
                                            {{ number_format((float)$f->total_horas, 2) }} h
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="p-8 text-center text-gray-500 font-semibold">
                                        No hay horas registradas todavía.
                                    </td>
                                </tr>
                            @endforelse
                            </tbody>

                            @if($fichajes->count())
                            <tfoot class="bg-gray-50">
                                <tr>
                                    <td colspan="4" class="p-4 text-right font-extrabold text-gray-700">
                                        Total
                                    </td>
                                    <td class="p-4 font-extrabold text-gray-900">
                                        {{ number_format((float)$totalHoras, 2) }} h
                                    </td>
                                </tr>
                            </tfoot>
                            @endif
                        </table>
                    </div>
                </div>

            </div>
        </main>
    </div>

    {{-- ========================= MÓVIL ========================= --}}
    <div class="md:hidden min-h-screen px-4 pt-6 pb-24">

        <div class="flex items-start justify-between gap-4 mb-5">
            <div>
                <h1 class="text-2xl font-extrabold">Horas</h1>
                <p class="text-gray-500 text-sm">Tus registros.</p>
            </div>

            {{-- BOTÓN PDF MÓVIL --}}
            <button onclick="descargarHorasPDF()"
                    class="inline-flex items-center gap-2 px-3 py-2 rounded-xl font-bold text-white bg-indigo-600 hover:bg-indigo-700 transition shadow text-sm">
                <i class="bi bi-file-earmark-pdf"></i>
                PDF
            </button>
        </div>

        {{-- (el resto del móvil NO SE TOCA) --}}
        {{-- … --}}
    </div>

{{-- jsPDF + AutoTable --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.31/jspdf.plugin.autotable.min.js"></script>

<script>
function descargarHorasPDF() {
    const { jsPDF } = window.jspdf;
    const doc = new jsPDF('p', 'mm', 'a4');

    doc.setFontSize(16);
    doc.text('Historial de horas trabajadas', 14, 15);

    doc.autoTable({
        html: '#tabla-horas-pdf',
        startY: 22,
        theme: 'grid',
        styles: { fontSize: 9, cellPadding: 3 },
        headStyles: { fillColor: [79, 70, 229], textColor: 255 },
        alternateRowStyles: { fillColor: [248, 250, 252] },
        margin: { left: 14, right: 14 }
    });

    doc.save('horas_trabajadas.pdf');
}
</script>

</body>
</html>
