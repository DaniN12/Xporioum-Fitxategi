<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\StreamedResponse;

class HorasController extends Controller
{
    private function alumnoId(): int
    {
        // ✅ Opción A: si usas Auth con usuarios normales
        // return (int) auth()->id();

        // ✅ Opción B: si guardas el alumno en sesión al hacer login
        return (int) session('alumno_id');
    }

    public function index(Request $request)
    {
        $alumnoId = $this->alumnoId();

        $fichajes = DB::table('fichaje')
            ->where('alumno_id', $alumnoId)
            ->orderByDesc('fecha')
            ->get();

        // Total (sumando total_horas si lo guardas como decimal)
        $totalHoras = (float) $fichajes->sum('total_horas');

        return view('horas.index', compact('fichajes', 'totalHoras'));
    }

    public function download(): StreamedResponse
    {
        $alumnoId = $this->alumnoId();

        $fichajes = DB::table('fichaje')
            ->where('alumno_id', $alumnoId)
            ->orderByDesc('fecha')
            ->get();

        $filename = 'tus_horas.csv';

        return response()->streamDownload(function () use ($fichajes) {
            $out = fopen('php://output', 'w');

            // Cabecera CSV
            fputcsv($out, ['Fecha', 'Entrada', 'Salida', 'Descanso(min)', 'Horas trabajadas']);

            foreach ($fichajes as $f) {
                // Si falta entrada/salida => AUSENCIA
                $entrada = $f->hora_entrada ?? 'AUSENCIA';
                $salida  = $f->hora_salida ?? 'AUSENCIA';

                // minutos_desc… (en tu captura se ve minutos_desc... INT)
                $descansoMin = $f->minutos_desc ?? 0;

                // total_horas decimal => lo formateamos bonito
                $horasTrab = $f->total_horas === null ? 'AUSENCIA' : number_format((float)$f->total_horas, 2);

                fputcsv($out, [$f->fecha, $entrada, $salida, $descansoMin, $horasTrab]);
            }

            fclose($out);
        }, $filename, [
            'Content-Type' => 'text/csv; charset=UTF-8',
        ]);
    }
}
