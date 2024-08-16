<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;


class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $role)
    {
        // Verificar si el usuario está autenticado y tiene el rol adecuado
        if (Auth::check() && Auth::user()->role->name === $role) {
            return $next($request);
        }

        // Si no tiene el rol adecuado, redirigir o lanzar un error
        abort(403, 'Acceso denegado');
    }
}
