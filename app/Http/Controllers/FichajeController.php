<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class FichajeController extends Controller
{
    /**
     * Si alguien abre /qr/{token} (por ejemplo escaneo “normal” desde móvil),
     * intentamos consumir el token.
     * - Si NO está logueado: lo mandamos a login con error/aviso.
     * - Si está logueado: registramos entrada y borramos el token.
     */
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

        // Si no hay sesión, obligamos login (tu app requiere usuario)
        if (!$request->session()->has('id_usuario')) {
            // opcional: guardamos token por si luego quieres consumirlo tras login
            $request->session()->put('pending_qr_token', $token);
            return redirect()->route('login.form')->with('error', 'Inicia sesión para fichar con QR.');
        }

        // Está logueado: fichamos entrada si procede y consumimos token
        $this->ficharEntradaSiNoExisteHoy($request);

        DB::table('qr_tokens')->where('token', $token)->delete();
        $request->session()->forget('pending_qr_token');

        return redirect()->route('fichar.vista')->with('success', 'Entrada registrada correctamente.');
    }

    /**
     * Vista principal: decide qué botón mostrar (QR / descanso / retomar / salida / finalizado).
     */
    public function vistaFichar(Request $request)
    {
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
            // Finalizado SOLO si hay salida real (evita 00:00:00)
            if ($fichaje->hora_salida !== null && $fichaje->hora_salida !== '00:00:00') {
                $estado = 'finalizado';
            }
            // Entrada hecha y sin salida -> fase intermedia
            elseif (!empty($fichaje->hora_entrada) && (empty($fichaje->hora_salida) || $fichaje->hora_salida === '00:00:00')) {
                if (empty($fichaje->hora_inicio_descanso)) {
                    $estado = 'descanso';
                } elseif (!empty($fichaje->hora_inicio_descanso) && empty($fichaje->hora_fin_descanso)) {
                    $estado = 'retomar';
                } else {
                    $estado = 'salida';
                }
            }
        }

        return view('fichar', compact('fichaje', 'estado'));
    }

    public function vistaEscanearQR()
    {
        return view('escanear_qr');
    }

    /**
     * Validación del QR (POST desde el escáner).
     * Este es el flujo principal recomendado.
     */
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

        // token de un solo uso
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

        $inicio = Carbon::createFromFormat('H:i:s', substr($fichaje->hora_inicio_descanso, 0, 8));
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

        if (!empty($fichaje->hora_salida) && $fichaje->hora_salida !== '00:00:00') {
            return back()->with('error', 'Ya has fichado la salida.');
        }

        if (!empty($fichaje->hora_inicio_descanso) && empty($fichaje->hora_fin_descanso)) {
            return back()->with('error', 'Primero debes REANUDAR para poder fichar la salida.');
        }

        $entrada = Carbon::createFromFormat('H:i:s', substr($fichaje->hora_entrada, 0, 8));
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

        return back()->with('success', 'Salida registrada.');
    }

    /**
     * Obtiene alumnoId desde sesión (más fiable/rápido). Si no existe, cae a BD.
     */
    private function getAlumnoId(Request $request)
    {
        $alumnoId = $request->session()->get('alumno_id');
        if ($alumnoId) return $alumnoId;

        $userId = $request->session()->get('id_usuario');
        if (!$userId) return null;

        return DB::table('alumno')
            ->where('usuario_id', $userId)
            ->value('id_alumno');
    }

    /**
     * Crea fichaje de hoy si no existe, o pone hora_entrada si estaba vacía.
     */
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
