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
        $request->validate(
            [
                'email' => ['required', 'email'],
                'contrasena' => ['required', 'string'],
            ],
            [
                'email.required' => __('message.validation_email_required'),
                'email.email' => __('message.validation_email_email'),
                'contrasena.required' => __('message.validation_password_required'),
            ]
        );

        $email = trim(mb_strtolower($request->email));
        $password = (string) $request->contrasena;

        $usuario = DB::table('usuario')
            ->whereRaw('LOWER(email) = ?', [$email])
            ->first();

        if (!$usuario) {
            return back()
                ->withInput($request->only('email'))
                ->with('error', __('message.login_invalid'));
        }

        $hashEnBD = (string) ($usuario->contrasena ?? '');

        $passwordOk = false;

        if ($hashEnBD !== '') {
            if (str_starts_with($hashEnBD, '$2y$') || str_starts_with($hashEnBD, '$argon2')) {
                $passwordOk = Hash::check($password, $hashEnBD);
            } else {
                $passwordOk = hash_equals($hashEnBD, $password);
            }
        }

        if (!$passwordOk) {
            return back()
                ->withInput($request->only('email'))
                ->with('error', __('message.login_invalid'));
        }

        $prof = DB::table('profesor')
            ->where('usuario_id', $usuario->id_usuario)
            ->first();

        $alumno = DB::table('alumno')
            ->where('usuario_id', $usuario->id_usuario)
            ->first();

        $request->session()->put([
            'id_usuario'  => $usuario->id_usuario,
            'is_teacher'  => $prof ? true : false,
            'profesor_id' => $prof->id_profesor ?? null,
            'alumno_id'   => $alumno->id_alumno ?? null,
        ]);

        $request->session()->regenerate();

        if ($prof) {
            return redirect()->route('teacher.dashboard');
        }

        return redirect()->route('fichar.vista');
    }

    public function logout(Request $request)
    {
        $request->session()->flush();
        $request->session()->regenerateToken();

        return redirect()->route('login.form');
    }
}
