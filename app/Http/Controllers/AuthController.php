<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function mostrarLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'contrasena' => 'required|string',
        ]);

        // Buscar usuario
        $usuario = DB::table('usuario')->where('email', $request->email)->first();

        if (!$usuario || !Hash::check($request->contrasena, $usuario->contrasena)) {
            return back()
                ->withInput($request->only('email'))
                ->with('login_error', true)
                ->with('error', 'Correo o contraseña incorrectos');
        }

        // Detectar profesor
        $prof = DB::table('profesor')
            ->where('usuario_id', $usuario->id_usuario)
            ->first();

        // Detectar alumno
        $alumno = DB::table('alumno')
            ->where('usuario_id', $usuario->id_usuario)
            ->first();

        // Guardar sesión
        $request->session()->put([
            'id_usuario'  => $usuario->id_usuario,
            'is_teacher'  => $prof ? true : false,
            'profesor_id' => $prof->id_profesor ?? null,
            'alumno_id'   => $alumno->id_alumno ?? null,
        ]);
        $request->session()->save();

        // Redirección por rol
        if ($prof) {
            return redirect()->route('teacher.dashboard');
        }

        return redirect()->route('fichar.vista');
    }

    public function logout(Request $request)
    {
        $request->session()->flush();
        return redirect()->route('login.form');
    }
}
