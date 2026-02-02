<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class QrController extends Controller
{
    /**
     * Muestra la pantalla del generador QR (sin crear token aún)
     */
    public function generate()
    {
        return view('teacher.qr');
    }

    /**
     * Genera un nuevo token QR vía AJAX
     */
    public function apiGenerate()
    {
        // Limpiar tokens caducados (opcional pero recomendable)
        DB::table('qr_tokens')
            ->whereNotNull('expires_at')
            ->where('expires_at', '<', now())
            ->delete();

        // Crear token único
        $token = (string) Str::uuid();

        // Caduca en 20 minutos (aunque el QR visual cambie cada 20 segundos)
        $expiresAt = now()->addMinutes(20);

        // Guardar en base de datos
        DB::table('qr_tokens')->insert([
            'token'      => $token,
            'tipo'       => 'entrada',
            'expires_at' => $expiresAt,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Devolver datos en JSON para que la vista genere el QR
        return response()->json([
            'token' => $token,
            'expires_at' => $expiresAt->format('H:i:s')
        ]);
    }
}
