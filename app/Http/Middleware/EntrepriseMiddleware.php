<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EntrepriseMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        // Vérifie si l'utilisateur est authentifié et si son rôle est 'entreprise'
        if (Auth::check() && Auth::user()->role === 'entreprise') {
            if (Auth::guard('employe')->check() && Auth::guard('employe')->user()->role === 'employe') {
                return redirect('/entreprise/protected');
            }
            return $next($request);
        }
        

        // Redirige l'utilisateur vers une page de protection ou d'erreur si non autorisé
        return redirect('/entreprise/protected');
    }
}
