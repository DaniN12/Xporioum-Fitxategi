<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class IncidenciaController extends Controller
{
    public function create()
    {
        return view('alumno.incidencias.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'fecha'   => 'required|date',
            'motivo'  => 'required|string|max:2000',
            'adjunto' => 'nullable|file|mimes:pdf,jpg,jpeg,png,webp|max:8192',
        ]);

        $alumnoId = (int) session('alumno_id');
        if (!$alumnoId) {
            abort(403, 'NO HAY ALUMNO EN SESIÓN');
        }

        $profesorId = DB::table('alumno')
            ->where('id_alumno', $alumnoId)
            ->value('profesor_id');

        if (!$profesorId) {
            abort(403, 'EL ALUMNO NO TIENE PROFESOR ASIGNADO');
        }

        $adjuntoPath = null;
        $adjuntoNombre = null;

        if ($request->hasFile('adjunto')) {
            $file = $request->file('adjunto');
            $adjuntoPath = $file->store('justificantes', 'public');
            $adjuntoNombre = $file->getClientOriginalName();
        }

        DB::table('incidencia')->insert([
            'alumno_id'      => $alumnoId,
            'profesor_id'    => $profesorId,
            'fecha'          => $request->fecha,
            'motivo'         => $request->motivo,
            'estado'         => 'pendiente',
            'adjunto_path'   => $adjuntoPath,
            'adjunto_nombre' => $adjuntoNombre,
        ]);

        return back()->with('status', 'La incidencia se ha registrado correctamente.');
    }
}
