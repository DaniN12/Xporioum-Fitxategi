<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class AbsenceController extends Controller
{
    public function index()
    {
        $profesorId = (int) session('profesor_id');
        if (!$profesorId) {
            abort(403, 'NO HAY PROFESOR EN SESIÓN');
        }

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
            ->where('i.profesor_id', $profesorId)
            ->orderBy('i.fecha', 'desc')
            ->get();

        return view('teacher.absences.index', compact('absences'));
    }

    public function accept($id)
    {
        DB::table('incidencia')
            ->where('id_incidencia', $id)
            ->update(['estado' => 'aceptada']);

        return back()->with('success', 'Incidencia aceptada');
    }

    public function reject($id)
    {
        DB::table('incidencia')
            ->where('id_incidencia', $id)
            ->update(['estado' => 'rechazada']);

        return back()->with('error', 'Incidencia rechazada');
    }
}
