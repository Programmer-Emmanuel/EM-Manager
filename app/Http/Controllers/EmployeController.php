<?php

namespace App\Http\Controllers;

use App\Models\Conge;
use App\Models\Employe;
use App\Models\Entreprise;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class EmployeController extends Controller
{
    public function employe_dashboard()
{
    // Vérifier si un employé est connecté
    $employe = Auth::guard('employe')->user();
    Auth::login($employe);

    // Récupérer les détails de l'employé
    $employeDetails = Employe::find($employe->id);


    // Afficher la vue du tableau de bord avec les détails
    return view('employe_dashboard', compact('employeDetails'));
}

public function employe_compte(){
        // Vérifier si un employé est connecté
        $employe = Auth::guard('employe')->user();
        Auth::login($employe);
    
        // Récupérer les détails de l'employé
        $employeDetails = Employe::find($employe->id);
        $entreprise = Entreprise::find($employeDetails->id_entreprise);

        // Afficher la vue du compte avec les détails
        return view('employe_compte', compact('employeDetails','entreprise'));
    
}

public function update_password(){
    // Vérifier si un employé est connecté
    $employe = Auth::guard('employe')->user();
    Auth::login($employe);

    // Récupérer les détails de l'employé
    $employeDetails = Employe::find($employe->id);

    // Afficher la vue de modification du mot de passe
    return view('employe_update_password', compact('employeDetails'));
}

public function update_put_password(Request $request)
{
    $request->validate([
        'password' => 'required|string|min:6|confirmed', // Assure que password et password_confirmation sont identiques
    ],[
        'password.required' => 'Le mot de passe est obligatoire.',
        'password.min' => 'Le mot de passe doit comporter au minimum 6 caractères.',
        'password.confirmed' => 'Les mots de passe ne sont pas identiques.'
    ]);

    $employe = Auth::guard('employe')->user();
    Auth::login($employe);

    $employeDetails = Employe::find($employe->id);
    $employeDetails->mot_de_passe = Hash::make($request->password);
    $employeDetails->save();

    return redirect()->route('employe_dashboard')->with('success', 'Votre mot de passe a été modifié avec succès.');
}

    public function employe_conge(){
            // Vérifier si un employé est connecté
            $employe = Auth::guard('employe')->user();
            Auth::login($employe);
        
            // Récupérer les détails de l'employé
            $employeDetails = Employe::find($employe->id);
            $entreprise = Entreprise::find($employeDetails->id_entreprise);

            //Liste des congés
            $conges = Conge::where('id_employe', $employe->id)->get();
    
            // Afficher la vue du compte avec les détails
            return view('page_conge', compact('employeDetails','entreprise','conges'));
    }

    public function demande_conge(){
        // Vérifier si un employé est connecté
        $employe = Auth::guard('employe')->user();
        Auth::login($employe);
    
        // Récupérer les détails de l'employé
        $employeDetails = Employe::find($employe->id);
        $entreprise = Entreprise::find($employeDetails->id_entreprise);



        // Afficher la vue du compte avec les détails
        return view('demande_conge', compact('employeDetails','entreprise'));
    }
    public function demande_conge_post(Request $request){
        $request->validate([
            'date_debut' =>'required|date',
            'date_fin' =>'required|date|after:date_debut',
            'type_conge' =>'required|string',
        ],[
            'date_debut.required' => 'Veuillez renseigner la date de début.',
            'date_fin.required' => 'Veuillez renseigner la date de fin.',
            'date_fin.after' => 'La date de fin doit être supérieure à la date de début.',
            'type_conge.required' => 'Veuillez renseigner une raison.'
        ]);

        $employe = Auth::guard('employe')->user();
        $conge = new Conge();
        $conge->id_employe = $employe->id;
        $conge->id_entreprise = $employe->id_entreprise;
        $conge->type_conge = $request->type_conge;
        $conge->date_debut = $request->date_debut;
        $conge->date_fin = $request->date_fin;
        $conge->save();

        return redirect()->route('employe_conge');
    }


    public function employe_protect(){
        return view('employe_protect');
    }
}
