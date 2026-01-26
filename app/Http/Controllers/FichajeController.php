<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Fichaje;

class FichajeController extends Controller
{
    public function vistaFichar(Request $request)
    {
        $idUsuario = $request->session()->get('id_usuario');
        if (!$idUsuario) {
            return redirect()->route('login.form')->with('error', 'Debes iniciar sesión.');
        }

        $alumno = DB::table('alumno')->where('usuario_id', $idUsuario)->first();
        if (!$alumno) {
            return redirect('/')->with('error', 'Este usuario no es alumno.');
        }

        $hoy = date('Y-m-d');

        // fichaje de hoy (si existe)
        $fichajeHoy = Fichaje::where('alumno_id', $alumno->id_alumno)
            ->where('fecha', $hoy)
            ->first();

        // Estado según columnas:
        // - fuera: no hay fichaje hoy
        // - dentro: hay entrada y no hay salida y no está en descanso
        // - descanso: hay descanso_inicio
        // - finalizado: hora_salida no es null
        $estado = 'fuera';

        if ($fichajeHoy) {
            if ($fichajeHoy->hora_salida) {
                $estado = 'finalizado';
            } elseif ($fichajeHoy->descanso_inicio) {
                $estado = 'descanso';
            } elseif ($fichajeHoy->hora_entrada) {
                $estado = 'dentro';
            }
        }

        return view('fichar', [
            'estado' => $estado,
        ]);
    }

    // Pantalla de escaneo QR
    public function vistaEscanearQR(Request $request)
    {
        $idUsuario = $request->session()->get('id_usuario');
        if (!$idUsuario) {
            return redirect()->route('login.form')->with('error', 'Debes iniciar sesión.');
        }

        return view('escanear_qr');
    }

    // Valida QR y registra ENTRADA
    public function validarQR(Request $request)
    {
        $request->validate([
            'token' => 'required|string',
        ]);

        $idUsuario = $request->session()->get('id_usuario');
        if (!$idUsuario) {
            return redirect()->route('login.form')->with('error', 'Debes iniciar sesión.');
        }

        $alumno = DB::table('alumno')->where('usuario_id', $idUsuario)->first();
        if (!$alumno) {
            return redirect('/')->with('error', 'Este usuario no es alumno.');
        }

        // 1) Validar token en BBDD
        $qr = DB::table('qr_tokens')
            ->where('token', $request->token)
            ->where('tipo', 'entrada')
            ->first();

        if (!$qr) {
            return back()->with('error', 'QR no válido.');
        }

        if (strtotime($qr->expires_at) < time()) {
            return back()->with('error', 'QR caducado. Pide que lo generen de nuevo.');
        }

        // 2) Evitar doble entrada: si ya hay fichaje hoy, no crees otro
        $hoy = date('Y-m-d');

        $fichajeHoy = Fichaje::where('alumno_id', $alumno->id_alumno)
            ->where('fecha', $hoy)
            ->first();

        if ($fichajeHoy && $fichajeHoy->hora_entrada) {
            return redirect()->route('fichar.vista')->with('error', 'Ya tienes una entrada registrada hoy.');
        }

        if (!$fichajeHoy) {
            $fichajeHoy = new Fichaje();
            $fichajeHoy->alumno_id = $alumno->id_alumno;
            $fichajeHoy->fecha = $hoy;
            $fichajeHoy->minutos_descanso = 0;
        }

        $fichajeHoy->hora_entrada = date('H:i:s');
        $fichajeHoy->hora_salida = null;
        $fichajeHoy->descanso_inicio = null;
        $fichajeHoy->save();

        return redirect()->route('fichar.vista')->with('success', 'Entrada registrada correctamente.');
    }

    public function iniciarDescanso(Request $request)
    {
        $idUsuario = $request->session()->get('id_usuario');
        if (!$idUsuario) {
            return redirect()->route('login.form')->with('error', 'Debes iniciar sesión.');
        }

        $alumno = DB::table('alumno')->where('usuario_id', $idUsuario)->first();
        if (!$alumno) {
            return redirect('/')->with('error', 'Este usuario no es alumno.');
        }

        $hoy = date('Y-m-d');

        $fichajeHoy = Fichaje::where('alumno_id', $alumno->id_alumno)
            ->where('fecha', $hoy)
            ->whereNull('hora_salida')
            ->first();

        if (!$fichajeHoy || !$fichajeHoy->hora_entrada) {
            return back()->with('error', 'No puedes iniciar descanso sin haber fichado entrada.');
        }

        if ($fichajeHoy->descanso_inicio) {
            return back()->with('error', 'Ya estás en descanso.');
        }

        $fichajeHoy->descanso_inicio = now();
        $fichajeHoy->save();

        return redirect()->route('fichar.vista')->with('success', 'Descanso iniciado.');
    }

    public function retomarTurno(Request $request)
    {
        $idUsuario = $request->session()->get('id_usuario');
        if (!$idUsuario) {
            return redirect()->route('login.form')->with('error', 'Debes iniciar sesión.');
        }

        $alumno = DB::table('alumno')->where('usuario_id', $idUsuario)->first();
        if (!$alumno) {
            return redirect('/')->with('error', 'Este usuario no es alumno.');
        }

        $hoy = date('Y-m-d');

        $fichajeHoy = Fichaje::where('alumno_id', $alumno->id_alumno)
            ->where('fecha', $hoy)
            ->whereNull('hora_salida')
            ->first();

        if (!$fichajeHoy || !$fichajeHoy->descanso_inicio) {
            return back()->with('error', 'No hay un descanso activo.');
        }

        $inicio = strtotime($fichajeHoy->descanso_inicio);
        $fin = time();
        $minutos = (int) round(($fin - $inicio) / 60);

        $fichajeHoy->minutos_descanso = (int)$fichajeHoy->minutos_descanso + $minutos;
        $fichajeHoy->descanso_inicio = null;
        $fichajeHoy->save();

        return redirect()->route('fichar.vista')->with('success', 'Turno retomado.');
    }

    public function ficharSalida(Request $request)
    {
        $idUsuario = $request->session()->get('id_usuario');
        if (!$idUsuario) {
            return redirect()->route('login.form')->with('error', 'Debes iniciar sesión.');
        }

        $alumno = DB::table('alumno')->where('usuario_id', $idUsuario)->first();
        if (!$alumno) {
            return redirect('/')->with('error', 'Este usuario no es alumno.');
        }

        $hoy = date('Y-m-d');

        $fichajeHoy = Fichaje::where('alumno_id', $alumno->id_alumno)
            ->where('fecha', $hoy)
            ->whereNull('hora_salida')
            ->first();

        if (!$fichajeHoy || !$fichajeHoy->hora_entrada) {
            return back()->with('error', 'No hay entrada abierta.');
        }

        // Si está en descanso, obligamos a retomar primero (opcional pero recomendable)
        if ($fichajeHoy->descanso_inicio) {
            return back()->with('error', 'Antes de salir, retoma el turno para cerrar el descanso.');
        }

        $horaSalida = date('H:i:s');

        $inicio = strtotime($fichajeHoy->hora_entrada);
        $fin = strtotime($horaSalida);

        $minutosTrabajados = (int) round(($fin - $inicio) / 60);
        $minutosFinales = max(0, $minutosTrabajados - (int)$fichajeHoy->minutos_descanso);

        // Si tienes total_horas en tu tabla, lo rellenamos como horas con decimales
        if (property_exists($fichajeHoy, 'total_horas') || isset($fichajeHoy->total_horas)) {
            $fichajeHoy->total_horas = round($minutosFinales / 60, 2);
        }

        $fichajeHoy->hora_salida = $horaSalida;
        $fichajeHoy->save();

        return redirect()->route('fichar.vista')->with('success', 'Salida registrada.');
    }
}
