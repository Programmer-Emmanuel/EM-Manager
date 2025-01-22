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
        // Vérifiez si l'utilisateur est authentifié avec le guard employe
        if (Auth::guard('employe')->check() && Auth::guard('employe')->user()->role === 'employe') {
            return $next($request);
        }
        


        // Redirigez en cas d'accès non autorisé
        return redirect('/employe/protected');
    }

}




