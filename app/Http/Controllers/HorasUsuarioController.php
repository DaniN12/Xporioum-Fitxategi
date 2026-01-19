<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Fichaje;

class HorasUsuarioController extends Controller
{
    public function index()
    {
        $usuario = Auth::user();

        $fichajes = Fichaje::where('alumno_id', $usuario->id)
            ->orderBy('fecha', 'desc')
            ->orderBy('hora_entrada', 'desc')
            ->get();

        return view('horas.usuario', compact('fichajes'));
    }
}
