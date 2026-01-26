<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProfesorController extends Controller
{
    private function requireProfesor(Request $request)
    {
        $idUsuario = $request->session()->get('id_usuario');
        if (!$idUsuario) return redirect()->route('login.form');

        $prof = DB::table('profesor')->where('usuario_id', $idUsuario)->first();
        if (!$prof) return redirect('/')->with('error', 'No eres profesor.');

        return $prof; // devuelve registro profesor
    }

    public function dashboard(Request $request)
    {
        $prof = $this->requireProfesor($request);
        if ($prof instanceof \Illuminate\Http\RedirectResponse) return $prof;

        return view('profesor.dashboard');
    }

    // Vista donde se muestra el QR (se actualiza cada 5s)
    public function vistaQR(Request $request)
    {
        $prof = $this->requireProfesor($request);
        if ($prof instanceof \Illuminate\Http\RedirectResponse) return $prof;

        return view('profesor.qr');
    }

    // Genera un token nuevo con caducidad corta (p.ej. 8s) y lo devuelve en JSON
    public function generarQR(Request $request)
    {
        $prof = $this->requireProfesor($request);
        if ($prof instanceof \Illuminate\Http\RedirectResponse) return response()->json(['error' => 'No autorizado'], 403);

        $token = Str::random(32);
        $expiresAt = now()->addSeconds(8);

        DB::table('qr_tokens')->insert([
            'token' => $token,
            'tipo' => 'entrada',
            'expires_at' => $expiresAt,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return response()->json([
            'token' => $token,
            'expires_at' => $expiresAt->toDateTimeString(),
        ]);
    }

    // Listado alumnos (simple)
    public function alumnos(Request $request)
    {
        $prof = $this->requireProfesor($request);
        if ($prof instanceof \Illuminate\Http\RedirectResponse) return $prof;

        $alumnos = DB::table('alumno')
            ->join('usuario', 'alumno.usuario_id', '=', 'usuario.id_usuario')
            ->select('alumno.id_alumno', 'usuario.email', 'usuario.nombre', 'usuario.dni')
            ->orderBy('alumno.id_alumno', 'desc')
            ->get();

        return view('profesor.alumnos', compact('alumnos'));
    }

    // Crear alumno (usuario + alumno)
    public function crearAlumno(Request $request)
    {
        $prof = $this->requireProfesor($request);
        if ($prof instanceof \Illuminate\Http\RedirectResponse) return $prof;

        $request->validate([
            'nombre' => 'required|string|max:255',
            'dni' => 'required|string|max:50',
            'email' => 'required|email',
            'contrasena' => 'required|min:4',
        ]);

        // evitar email duplicado
        $existe = DB::table('usuario')->where('email', $request->email)->exists();
        if ($existe) {
            return back()->with('error', 'Ese email ya existe.');
        }

        DB::beginTransaction();
        try {
            $idUsuario = DB::table('usuario')->insertGetId([
                'email' => $request->email,
                'contrasena' => password_hash($request->contrasena, PASSWORD_BCRYPT),
                'nombre' => $request->nombre,
                'dni' => $request->dni,
                'idioma_id' => 1,
                'fecha_creacion' => now(),
                'activo' => 1
            ]);

            DB::table('alumno')->insert([
                'usuario_id' => $idUsuario,
                'profesor_id' => $prof->id_profesor,
                // empresa_id si lo necesitas: ponlo fijo o añade campo al form
                'empresa_id' => 1,
                'fecha_alta' => now()
            ]);

            DB::commit();
            return redirect()->route('profesor.alumnos')->with('success', 'Alumno creado.');
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->with('error', 'Error al crear alumno: '.$e->getMessage());
        }
    }

    // Ver fichajes de hoy
    public function fichajesHoy(Request $request)
    {
        $prof = $this->requireProfesor($request);
        if ($prof instanceof \Illuminate\Http\RedirectResponse) return $prof;

        $hoy = date('Y-m-d');

        $fichajes = DB::table('fichaje')
            ->join('alumno', 'fichaje.alumno_id', '=', 'alumno.id_alumno')
            ->join('usuario', 'alumno.usuario_id', '=', 'usuario.id_usuario')
            ->select('usuario.nombre', 'usuario.email', 'fichaje.fecha', 'fichaje.hora_entrada', 'fichaje.hora_salida', 'fichaje.minutos_descanso')
            ->where('fichaje.fecha', $hoy)
            ->orderBy('fichaje.hora_entrada', 'desc')
            ->get();

        return view('profesor.fichajes_hoy', compact('fichajes', 'hoy'));
    }
}
