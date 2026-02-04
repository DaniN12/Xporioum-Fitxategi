<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    public function index(Request $request)
    {
        $empresaId = $request->get('empresa_id');
        $studentId = $request->get('student_id');

        // Empresas para el select
        $empresas = DB::table('empresa')
            ->orderBy('nombre')
            ->get();

        $studentsQuery = DB::table('alumno as a')
            ->join('usuario as u', 'u.id_usuario', '=', 'a.usuario_id')
            ->select([
                'a.id_alumno',
                'u.nombre',
                'u.email',
                'a.empresa_id',
            ])
            ->orderBy('u.nombre');

        if (!empty($empresaId)) {
            $studentsQuery->where('a.empresa_id', $empresaId);
        }

        $students = $studentsQuery->get();

        $q = DB::table('fichaje as f')
            ->join('alumno as a', 'a.id_alumno', '=', 'f.alumno_id')
            ->join('usuario as u', 'u.id_usuario', '=', 'a.usuario_id')
            ->leftJoin('empresa as e', 'e.id_empresa', '=', 'a.empresa_id')
            ->select([
                'f.id_fichaje',
                'e.nombre as empresa_nombre',
                'a.id_alumno as alumno_id',
                'u.nombre',
                'u.email',
                'f.fecha',
                'f.hora_entrada',
                'f.hora_salida',
                'f.hora_inicio_descanso',
                'f.hora_fin_descanso',
                'f.minutos_descanso as minutos_descanso',
                'f.total_horas',
            ])
            ->orderByDesc('f.fecha')
            ->orderByDesc('f.hora_entrada');

        // Filtro empresa
        if (!empty($empresaId)) {
            $q->where('a.empresa_id', $empresaId);
        }

        // Filtro alumno
        if (!empty($studentId)) {
            $q->where('a.id_alumno', $studentId);
        }

        $attendances = $q->get();

        return view('teacher.attendance.index', compact(
            'attendances',
            'empresas',
            'students',
            'empresaId',
            'studentId'
        ));
    }

    public function byStudent(Request $request)
    {
        return $this->index($request);
    }

    public function update(Request $request, int $id)
    {
        $request->validate([
            'hora_entrada'         => ['nullable', 'date_format:H:i'],
            'hora_salida'          => ['nullable', 'date_format:H:i'],
            'hora_inicio_descanso' => ['nullable', 'date_format:H:i'],
            'hora_fin_descanso'    => ['nullable', 'date_format:H:i'],
        ]);

        $f = DB::table('fichaje')->where('id_fichaje', $id)->first();
        if (!$f) {
            return back()->with('error', 'No existe ese fichaje.');
        }

        $toTime = function ($v) {
            if ($v === null || $v === '') return null;
            return strlen($v) === 5 ? ($v . ':00') : $v;
        };

        DB::table('fichaje')->where('id_fichaje', $id)->update([
            'hora_entrada'         => $toTime($request->hora_entrada),
            'hora_salida'          => $toTime($request->hora_salida),
            'hora_inicio_descanso' => $toTime($request->hora_inicio_descanso),
            'hora_fin_descanso'    => $toTime($request->hora_fin_descanso),
        ]);


        $f = DB::table('fichaje')->where('id_fichaje', $id)->first();

        $minDescanso = 0;


        if (!empty($f->hora_inicio_descanso) && !empty($f->hora_fin_descanso)) {
            $iniD = Carbon::createFromFormat('H:i:s', substr($f->hora_inicio_descanso, 0, 8));
            $finD = Carbon::createFromFormat('H:i:s', substr($f->hora_fin_descanso, 0, 8));
            $minDescanso = max(0, $iniD->diffInMinutes($finD));
        }

        if (empty($f->hora_entrada) || empty($f->hora_salida)) {
            DB::table('fichaje')->where('id_fichaje', $id)->update([
                'minutos_descanso' => $minDescanso,
                'total_horas'      => null,
            ]);

            return back()->with('success', 'Fichaje actualizado. (Falta entrada o salida, total no calculado)');
        }

        $entrada = Carbon::createFromFormat('H:i:s', substr($f->hora_entrada, 0, 8));
        $salida  = Carbon::createFromFormat('H:i:s', substr($f->hora_salida, 0, 8));

        $minTrabajados = max(0, $entrada->diffInMinutes($salida) - $minDescanso);
        $horasFinal = round($minTrabajados / 60, 2);

        DB::table('fichaje')->where('id_fichaje', $id)->update([
            'minutos_descanso' => $minDescanso,
            'total_horas'      => $horasFinal,
        ]);

        return back()->with('success', 'Fichaje corregido correctamente.');
    }
}
