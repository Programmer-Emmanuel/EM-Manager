<?php

namespace App\Http\Controllers;

use App\Models\Entreprise;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class AccueilController extends Controller
{
    public function index(){
        return view('accueil');

        // if (Auth::attempt($request->only('email', 'password'))) {
        //     $request->session()->regenerate();
    
        //     // Créer un cookie sécurisé
        //     $cookie = cookie('user_id', Auth::user()->id, 60*60*30); // Durée : 30jours
    
        //     // Rediriger avec le cookie attaché
        //     return redirect()->intended('/auth')->withCookie($cookie);
        // }
    }
    public function service()
    {
        // Vérifier si l'utilisateur est connecté
        $entreprise = auth()->user();
    
        // Si connecté, hacher l'ID de l'entreprise
        $hashedId = $entreprise ? Crypt::encrypt($entreprise->id) : null;
    
        // Passer les données (y compris l'ID haché ou `null`) à la vue
        return view('service', ['hashedId' => $hashedId]);
    }

    public function apropos(){
        return view('apropos');
    }
    public function contact(){
        return view('contact');
    }
}
