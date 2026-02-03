<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FichajeController extends Controller
{
    public function consumeQrPublic(Request $request, string $token)
    {
        $qr = DB::table('qr_tokens')
            ->where('token', $token)
            ->where(function ($q) {
                $q->whereNull('expires_at')->orWhere('expires_at', '>', now());
            })
            ->first();

        if (!$qr) {
            return redirect()->route('login.form')->with('error', 'QR inválido o caducado.');
        }

        $request->session()->put('pending_qr_token', $token);

        if (!$request->session()->has('id_usuario')) {
            return redirect()->route('login.form');
        }

        return redirect()->route('fichar.vista');
    }

    public function vistaFichar(Request $request)
    {
        if ($request->session()->has('pending_qr_token') && $request->session()->has('id_usuario')) {
            $token = $request->session()->get('pending_qr_token');

            $qr = DB::table('qr_tokens')
                ->where('token', $token)
                ->where(function ($q) {
                    $q->whereNull('expires_at')->orWhere('expires_at', '>', now());
                })
                ->first();

            if ($qr) {
                $this->ficharEntradaSiNoExisteHoy($request);

                DB::table('qr_tokens')->where('token', $token)->delete();

                $request->session()->forget('pending_qr_token');
                return redirect()->route('fichar.vista')->with('success', 'Entrada registrada correctamente.');
            } else {
                $request->session()->forget('pending_qr_token');
                return redirect()->route('fichar.vista')->with('error', 'QR inválido o caducado.');
            }
        }

        $alumnoId = $this->getAlumnoId($request);
        if (!$alumnoId) {
            return redirect('/')->with('error', 'No tienes perfil de alumno.');
        }

        $hoy = now()->toDateString();
        $fichaje = DB::table('fichaje')
            ->where('alumno_id', $alumnoId)
            ->where('fecha', $hoy)
            ->first();

        $estado = 'esperando_qr';

        if ($fichaje) {
            if (!empty($fichaje->hora_entrada) && empty($fichaje->hora_salida)) {
                if (empty($fichaje->hora_inicio_descanso)) {
                    $estado = 'descanso';
                } elseif (!empty($fichaje->hora_inicio_descanso) && empty($fichaje->hora_fin_descanso)) {
                    $estado = 'retomar';
                } else {
                    $estado = 'salida';
                }
            }

            if (!empty($fichaje->hora_salida)) {
                $estado = 'finalizado';
            }
        }

        return view('fichar', compact('fichaje', 'estado'));
    }

    public function vistaEscanearQR()
    {
        return view('escanear_qr');
    }

    public function validarQR(Request $request)
    {
        $request->validate([
            'token' => 'required|string'
        ]);

        $qr = DB::table('qr_tokens')
            ->where('token', $request->token)
            ->where(function ($q) {
                $q->whereNull('expires_at')->orWhere('expires_at', '>', now());
            })
            ->first();

        if (!$qr) {
            return back()->with('error', 'QR inválido o caducado.');
        }

        $this->ficharEntradaSiNoExisteHoy($request);

        DB::table('qr_tokens')->where('token', $request->token)->delete();

        return redirect()->route('fichar.vista')->with('success', 'Entrada registrada correctamente.');
    }

    public function iniciarDescanso(Request $request)
    {
        $alumnoId = $this->getAlumnoId($request);
        if (!$alumnoId) return back()->with('error', 'No tienes perfil de alumno.');

        $hoy = now()->toDateString();

        $fichaje = DB::table('fichaje')
            ->where('alumno_id', $alumnoId)
            ->where('fecha', $hoy)
            ->first();

        if (!$fichaje || empty($fichaje->hora_entrada)) {
            return back()->with('error', 'Primero debes fichar la entrada.');
        }

        if (!empty($fichaje->hora_inicio_descanso) && empty($fichaje->hora_fin_descanso)) {
            return back()->with('error', 'Ya estás en descanso.');
        }

        DB::table('fichaje')
            ->where('id_fichaje', $fichaje->id_fichaje)
            ->update([
                'descanso_inicio'      => now(),
                'hora_inicio_descanso' => now()->format('H:i:s'),
                'hora_fin_descanso'    => null,
            ]);

        DB::table('pausa')->insert([
            'fichaje_id'  => $fichaje->id_fichaje,
            'hora_inicio' => now()->format('H:i:s'),
            'hora_fin'    => null,
            'duracion'    => null,
        ]);

        return back()->with('success', 'Descanso iniciado.');
    }

    public function retomarTurno(Request $request)
    {
        $alumnoId = $this->getAlumnoId($request);
        if (!$alumnoId) return back()->with('error', 'No tienes perfil de alumno.');

        $hoy = now()->toDateString();

        $fichaje = DB::table('fichaje')
            ->where('alumno_id', $alumnoId)
            ->where('fecha', $hoy)
            ->first();

        if (!$fichaje || empty($fichaje->hora_inicio_descanso) || !empty($fichaje->hora_fin_descanso)) {
            return back()->with('error', 'No tienes un descanso activo.');
        }

        $inicio = \Carbon\Carbon::createFromFormat('H:i:s', substr($fichaje->hora_inicio_descanso, 0, 8));
        $fin = now();
        $min = $inicio->diffInMinutes($fin);

        $minActual = (int)($fichaje->minutos_descanso ?? 0);
        $minNuevo = $minActual + $min;

        DB::table('fichaje')
            ->where('id_fichaje', $fichaje->id_fichaje)
            ->update([
                'hora_fin_descanso' => $fin->format('H:i:s'),
                'minutos_descanso'  => $minNuevo,
            ]);

        $ultima = DB::table('pausa')
            ->where('fichaje_id', $fichaje->id_fichaje)
            ->whereNull('hora_fin')
            ->orderByDesc('id_pausa')
            ->first();

        if ($ultima) {
            DB::table('pausa')
                ->where('id_pausa', $ultima->id_pausa)
                ->update([
                    'hora_fin' => $fin->format('H:i:s'),
                    'duracion' => $min,
                ]);
        }

        return back()->with('success', "Descanso finalizado (+{$min} min).");
    }

    public function ficharSalida(Request $request)
    {
        $alumnoId = $this->getAlumnoId($request);
        if (!$alumnoId) return back()->with('error', 'No tienes perfil de alumno.');

        $hoy = now()->toDateString();

        $fichaje = DB::table('fichaje')
            ->where('alumno_id', $alumnoId)
            ->where('fecha', $hoy)
            ->first();

        if (!$fichaje || empty($fichaje->hora_entrada)) {
            return back()->with('error', 'Primero debes fichar la entrada.');
        }

        if (!empty($fichaje->hora_salida)) {
            return back()->with('error', 'Ya has fichado la salida.');
        }

        if (!empty($fichaje->hora_inicio_descanso) && empty($fichaje->hora_fin_descanso)) {
            return back()->with('error', 'Primero debes REANUDAR para poder fichar la salida.');
        }

        $entrada = \Carbon\Carbon::createFromFormat('H:i:s', substr($fichaje->hora_entrada, 0, 8));
        $salida = now();

        $minTrab = $entrada->diffInMinutes($salida);
        $minDesc = (int)($fichaje->minutos_descanso ?? 0);

        $minFinal = max(0, $minTrab - $minDesc);
        $horasFinal = round($minFinal / 60, 2);

        DB::table('fichaje')
            ->where('id_fichaje', $fichaje->id_fichaje)
            ->update([
                'hora_salida' => $salida->format('H:i:s'),
                'total_horas' => $horasFinal,
            ]);

        return back()->with('success', 'Salida registrada. Jornada finalizada.');
    }

    private function getAlumnoId(Request $request)
    {
        $userId = $request->session()->get('id_usuario');
        if (!$userId) return null;

        return DB::table('alumno')
            ->where('usuario_id', $userId)
            ->value('id_alumno');
    }

    private function ficharEntradaSiNoExisteHoy(Request $request)
    {
        $alumnoId = $this->getAlumnoId($request);
        if (!$alumnoId) return;

        $hoy = now()->toDateString();

        $f = DB::table('fichaje')
            ->where('alumno_id', $alumnoId)
            ->where('fecha', $hoy)
            ->first();

        if ($f) {
            if (empty($f->hora_entrada)) {
                DB::table('fichaje')
                    ->where('id_fichaje', $f->id_fichaje)
                    ->update([
                        'hora_entrada' => now()->format('H:i:s'),
                    ]);
            }
            return;
        }

        DB::table('fichaje')->insert([
            'alumno_id'            => $alumnoId,
            'pin_id'               => null,
            'fecha'                => $hoy,
            'hora_entrada'         => now()->format('H:i:s'),
            'hora_salida'          => null,
            'total_horas'          => null,
            'descanso_inicio'      => null,
            'minutos_descanso'     => 0,
            'hora_inicio_descanso' => null,
            'hora_fin_descanso'    => null,
        ]);
    }
}
