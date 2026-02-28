<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Vérifier si l'utilisateur est authentifié et a le rôle admin
        if (!auth()->check() || auth()->user()->role !== 'admin') {
            abort(403, 'Accès refusé. Vous devez être administrateur pour accéder à cette page.');
        }

        return $next($request);
    }
}
