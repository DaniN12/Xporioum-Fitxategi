<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class AbsenceController extends Controller
{
    // 📋 LISTAR INCIDENCIAS PARA EL PROFESOR
    public function index()
    {
        $absences = DB::table('incidencia as i')
            ->join('alumno as a', 'a.id_alumno', '=', 'i.alumno_id')
            ->join('usuario as u', 'u.id_usuario', '=', 'a.usuario_id')
            ->select(
                'i.id_incidencia',
                'i.fecha',
                'i.motivo',
                'i.estado',
                'i.adjunto_path',
                'i.adjunto_nombre',
                'u.nombre as alumno_nombre',
                'u.email as alumno_email',
                'u.dni as alumno_dni'
            )
            ->orderBy('i.fecha', 'desc')
            ->get();

        return view('teacher.absences.index', compact('absences'));
    }

    // ✅ ACEPTAR INCIDENCIA
    public function accept($id)
    {
        DB::table('incidencia')
            ->where('id_incidencia', $id)
            ->update(['estado' => 'aceptada']);

        return back()->with('success', 'Incidencia aceptada');
    }

    // ❌ RECHAZAR INCIDENCIA
    public function reject($id)
    {
        DB::table('incidencia')
            ->where('id_incidencia', $id)
            ->update(['estado' => 'rechazada']);

        return back()->with('error', 'Incidencia rechazada');
    }
}
