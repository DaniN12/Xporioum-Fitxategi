<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class QrController extends Controller
{

    public function generate()
    {
        return view('teacher.qr');
    }


    public function apiGenerate()
    {

        DB::table('qr_tokens')
            ->whereNotNull('expires_at')
            ->where('expires_at', '<', now())
            ->delete();

        $token = (string) Str::uuid();
        $expiresAt = now()->addMinutes(20);

        DB::table('qr_tokens')->insert([
            'token'      => $token,
            'tipo'       => 'entrada',
            'expires_at' => $expiresAt,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return response()->json([
            'token'      => $token,
            'url'        => route('qr.consume', ['token' => $token]),
            'expires_at' => $expiresAt->format('H:i:s')
        ]);
    }
}
