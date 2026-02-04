<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\StreamedResponse;

class HorasController extends Controller
{
    private function alumnoId(): int
    {
        return (int) session('alumno_id');
    }

    public function index(Request $request)
    {
        $alumnoId = $this->alumnoId();

        $fichajes = DB::table('fichaje')
            ->where('alumno_id', $alumnoId)
            ->orderByDesc('fecha')
            ->get();

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

            fputcsv($out, ['Fecha', 'Entrada', 'Salida', 'Descanso(min)', 'Horas trabajadas']);

            foreach ($fichajes as $f) {
                $entrada = $f->hora_entrada ?? 'AUSENCIA';
                $salida  = $f->hora_salida ?? 'AUSENCIA';

                $descansoMin = $f->minutos_desc ?? 0;

                $horasTrab = $f->total_horas === null ? 'AUSENCIA' : number_format((float)$f->total_horas, 2);

                fputcsv($out, [$f->fecha, $entrada, $salida, $descansoMin, $horasTrab]);
            }

            fclose($out);
        }, $filename, [
            'Content-Type' => 'text/csv; charset=UTF-8',
        ]);
    }
}
