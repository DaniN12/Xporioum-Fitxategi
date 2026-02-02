<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class CuentaController extends Controller
{
    private function userId(): int
    {
        return (int) session('id_usuario'); // <- si tu sesión se llama diferente, cámbialo aquí
    }

    private function usuario()
    {
        return DB::table('usuario')->where('id_usuario', $this->userId())->first();
    }

    public function index()
    {
        return view('alumno.cuenta.index', ['u' => $this->usuario()]);
    }

    public function datos()
    {
        return view('alumno.cuenta.datos', ['u' => $this->usuario()]);
    }

    public function datosUpdate(Request $request)
    {
        $u = $this->usuario();
        if (!$u) abort(403);

        $data = $request->validate([
            'nombre' => 'nullable|string|max:100',
            'email' => 'nullable|email|max:100',
            'dni' => 'nullable|string|max:15',
            'idioma_id' => 'nullable|integer',
            'telefono' => 'nullable|string|max:30',
            'foto' => 'nullable|image|max:2048',
        ]);

        $update = $data;

        if ($request->hasFile('foto')) {
            $path = $request->file('foto')->store('perfil', 'public');
            $update['foto_path'] = $path;
            unset($update['foto']);
        }

        DB::table('usuario')->where('id_usuario', $this->userId())->update($update);

        return back()->with('success', 'Datos actualizados ✅');
    }

    public function documentos()
    {
        return view('alumno.cuenta.documentos', ['u' => $this->usuario()]);
    }

    public function documentosUpload(Request $request)
    {
        $u = $this->usuario();
        if (!$u) abort(403);

        $request->validate([
            'documento' => 'required|file|mimes:pdf,jpg,jpeg,png|max:8192',
            'tipo' => 'required|in:personal,otros',
        ]);

        $path = $request->file('documento')->store('documentos', 'public');

        $col = $request->tipo === 'personal' ? 'doc_personal_path' : 'doc_otros_path';

        DB::table('usuario')->where('id_usuario', $this->userId())->update([$col => $path]);

        return back()->with('success', 'Documento subido ✅');
    }

    public function documentoDownload(string $tipo)
    {
        $u = $this->usuario();
        if (!$u) abort(403);

        $col = $tipo === 'personal' ? 'doc_personal_path' : ($tipo === 'otros' ? 'doc_otros_path' : null);
        if (!$col || empty($u->$col)) abort(404);

        return Storage::disk('public')->download($u->$col);
    }

    public function notificaciones()
    {
        return view('alumno.cuenta.notificaciones', ['u' => $this->usuario(), 'items' => []]);
    }

    public function passwordForm()
    {
        return view('alumno.cuenta.password', ['u' => $this->usuario()]);
    }

    public function passwordUpdate(Request $request)
    {
        $u = $this->usuario();
        if (!$u) abort(403);

        $data = $request->validate([
            'password_actual' => 'required|string',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if (!Hash::check($data['password_actual'], $u->contrasena)) {
            return back()->with('error', 'Contraseña actual incorrecta.');
        }

        DB::table('usuario')->where('id_usuario', $this->userId())->update([
            'contrasena' => Hash::make($data['password']),
        ]);

        return back()->with('success', 'Contraseña cambiada ✅');
    }
}
