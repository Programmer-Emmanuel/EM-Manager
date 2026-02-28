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
        // Vérifie si l'utilisateur est connecté
        if (Auth::check()) {

            $user = Auth::user();

            // Vérifie si le rôle est entreprise
            if ($user->role === 'entreprise') {

                // 🔴 Vérifie si l'entreprise est désactivée
                if ($user->is_active == false) {
                    Auth::logout();
                    return redirect('/entreprise/disabled');
                }

                // Vérifie si c’est un employé connecté avec le guard employe
                if (Auth::guard('employe')->check() 
                    && Auth::guard('employe')->user()->role === 'employe') {
                    
                    return redirect('/entreprise/protected');
                }

                return $next($request);
            }
        }

        // Si non autorisé
        return redirect('/entreprise/protected');
    }
}