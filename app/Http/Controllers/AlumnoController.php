<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AlumnoController extends Controller
{
    private function alumnoId(): int
    {
        $idUsuario = (int) session('id_usuario');

        if (!$idUsuario) {
            abort(403, 'NO HAY USUARIO EN SESIÓN');
        }

        $alumno = DB::table('alumno')->where('usuario_id', $idUsuario)->first();

        if (!$alumno) {
            abort(403, 'NO HAY ALUMNO EN SESIÓN');
        }

        return (int) $alumno->id_alumno;
    }

    public function horas()
    {
        $alumnoId = $this->alumnoId();

        $fichajes = DB::table('fichaje')
            ->where('alumno_id', $alumnoId)
            ->orderByDesc('fecha')
            ->get();

        $totalHoras = (float) $fichajes->sum('total_horas');

        // ✅ como ahora lo moviste dentro de alumno/horas/index.blade.php:
        return view('alumno.horas.index', compact('fichajes', 'totalHoras'));
    }

    public function downloadHoras()
    {
        $alumnoId = $this->alumnoId();

        $fichajes = DB::table('fichaje')
            ->where('alumno_id', $alumnoId)
            ->orderByDesc('fecha')
            ->get();

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
        }, 'tus_horas.csv', ['Content-Type' => 'text/csv; charset=UTF-8']);
    }
}
