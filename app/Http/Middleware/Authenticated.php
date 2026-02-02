<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Authenticated
{

    public function handle(Request $request, Closure $next): Response
    {

        if (!session()-> has('usuario')){
            return redirect('/login');
        }
        
        return $next($request);
    }
}
