<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RolMiddleware
{
    public function handle(Request $request, Closure $next, $rol): Response
    {

        $usuario = session('usuario');

        if(!$usuario){
            return redirect('/login');
        }

        if ($usuario->rol !== $rol){
            return redirect ('/login');
        }

        return $next($request);
    }
}
