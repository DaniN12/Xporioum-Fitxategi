<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AttendanceController extends Controller
{
    public function index(Request $request)
    {
        $studentId = $request->get('student_id');

        /**
         * Sacamos listado de alumnos con su usuario (nombre/email)
         * IMPORTANTE: ajusta el join si tu FK es distinta.
         * Asumo:
         *  - alumno.id_alumno
         *  - usuario.id_usuario
         *  - alumno.usuario_id  (o similar)
         *
         * Si tu columna NO se llama alumno.usuario_id, cámbiala aquí.
         */
        $students = DB::table('alumno as a')
            ->leftJoin('usuario as u', 'u.id_usuario', '=', 'a.usuario_id') // <-- AJUSTA si tu FK es otra
            ->select([
                'a.id_alumno',
                'u.nombre as nombre',
                'u.email as email',
            ])
            ->orderBy('u.nombre')
            ->get();

        /**
         * Fichajes
         * Tabla: fichaje
         * Campos según tu screenshot:
         * - alumno_id, fecha, hora_entrada, hora_salida, total_horas, minutos_descanso,
         *   hora_inicio_descanso, hora_fin_descanso
         */
        $attendances = DB::table('fichaje as f')
            ->leftJoin('alumno as a', 'a.id_alumno', '=', 'f.alumno_id')
            ->leftJoin('usuario as u', 'u.id_usuario', '=', 'a.usuario_id') // <-- AJUSTA si tu FK es otra
            ->select([
                'f.*',
                'u.nombre as alumno_nombre',
                'u.email as alumno_email',
                'a.id_alumno as alumno_id',
            ])
            ->when($studentId, fn($q) => $q->where('f.alumno_id', $studentId))
            ->orderBy('f.fecha', 'desc')
            ->get();

        return view('teacher.attendance.index', compact('attendances', 'students', 'studentId'));
    }
}
