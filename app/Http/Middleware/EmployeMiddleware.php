<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EmployeMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Vérifie si l'employé est authentifié
        if (Auth::guard('employe')->check()) {

            $employe = Auth::guard('employe')->user();

            // Vérifie le rôle
            if ($employe->role === 'employe') {

                // 🔴 Vérifie si son entreprise est désactivée
                if ($employe->entreprise && !$employe->entreprise->is_active) {
                    Auth::guard('employe')->logout();
                    return redirect('/employe/disabled');
                }

                return $next($request);
            }
        }

        // Accès non autorisé
        return redirect('/employe/protected');
    }
}