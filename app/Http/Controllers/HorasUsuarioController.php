<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Fichaje;

class HorasUsuarioController extends Controller
{
    public function index()
{
    $fichajes = Fichaje::where('alumno_id', auth()->id())
        ->latest('fecha')
        ->latest('hora_entrada')
        ->get();

    return view('horas.usuario', compact('fichajes'));
}

}
