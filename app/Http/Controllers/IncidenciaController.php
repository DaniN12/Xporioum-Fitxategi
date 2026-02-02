<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class IncidenciaController extends Controller
{
    public function create()
    {
        // ✅ tu vista ahora está en resources/views/alumno/incidencias/create.blade.php
        return view('alumno.incidencias.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'fecha'   => 'required|date',
            'motivo'  => 'required|string|max:2000',
            'adjunto' => 'nullable|file|mimes:pdf,jpg,jpeg,png,webp|max:8192',
        ]);

        // ✅ aquí usamos tu sesión (ajusta si tu sesión se llama distinto)
        $alumnoId = (int) session('alumno_id');
        if (!$alumnoId) {
            abort(403, 'NO HAY ALUMNO EN SESIÓN');
        }

        // ✅ subimos archivo si existe
        $adjuntoPath = null;
        $adjuntoNombre = null;

        if ($request->hasFile('adjunto')) {
            $file = $request->file('adjunto');
            $adjuntoPath = $file->store('justificantes', 'public');
            $adjuntoNombre = $file->getClientOriginalName();
        }

        // ✅ guardamos en tabla incidencia (NO en Documento)
        DB::table('incidencia')->insert([
            'alumno_id'      => $alumnoId,
            'profesor_id'    => null,              // luego el profe puede asignarse si quieres
            'fecha'          => $request->fecha,
            'motivo'         => $request->motivo,
            'estado'         => 'pendiente',
            'adjunto_path'   => $adjuntoPath,
            'adjunto_nombre' => $adjuntoNombre,
        ]);

        return back()->with('status', 'La incidencia se ha registrado correctamente.');
    }
}
