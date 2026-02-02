<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class IsTeacher
{
    public function handle(Request $request, Closure $next)
    {
        if (!session()->has('id_usuario') || session('is_teacher') !== true) {
            abort(403, 'No autorizado (no eres profesor)');
        }

        return $next($request);
    }
}
