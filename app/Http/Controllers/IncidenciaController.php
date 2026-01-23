<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Incidencia;
use App\Models\Documento;

class IncidenciaController extends Controller {
    public function create() {
        return view('incidencias.create');
    }

    public function store(Request $request) {
    // Guardar texto
    $incidencia = new \App\Models\Incidencia();
    // HEMOS QUITADO: alumno_id y profesor_id
    $incidencia->fecha = $request->fecha;
    $incidencia->motivo = $request->motivo;
    $incidencia->save();

    // Guardar archivo
    if ($request->hasFile('adjunto')) {
        $file = $request->file('adjunto');
        $path = $file->store('justificantes', 'public');

        $doc = new \App\Models\Documento();
        $doc->incidencia_id = $incidencia->id; // Asegúrate de que sea ->id y no ->id_incidencia
        $doc->nombre_archivo = $file->getClientOriginalName();
        $doc->ruta_archivo = $path;
        $doc->save();
    }

    return back()->with('status', '¡Éxito! Se ha guardado correctamente.');
}
}
