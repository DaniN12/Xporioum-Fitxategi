<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    public function mostrarLogin()
    {
        return view('auth.login'); // ✅ corregido
    }

    public function login(Request $request)
    {
        // Validación básica
        $request->validate([
            'email' => 'required|email',
            'contrasena' => 'required',
        ]);

        // Buscar usuario por email
        $usuario = DB::table('usuario')
            ->where('email', $request->email)
            ->first();

        // Si no existe o contraseña mal -> mismo mensaje
        if (!$usuario || !password_verify($request->contrasena, $usuario->contrasena)) {
            return back()
                ->withInput($request->only('email'))
                ->with('login_error', true)
                ->with('error', 'Correo o contraseña incorrectos');
        }

        // Guardar usuario en sesión
        $request->session()->put('id_usuario', $usuario->id_usuario);
        $request->session()->save();

        // ¿Es profesor?
        $esProfesor = DB::table('profesor')
            ->where('usuario_id', $usuario->id_usuario)
            ->exists();

        if ($esProfesor) {
            return redirect()->route('profesor.dashboard');
        }

        // Si no, alumno
        return redirect()->route('fichar.vista');
    }

    public function logout(Request $request)
    {
        $request->session()->flush();
        return redirect()->route('login.form');
    }
}

