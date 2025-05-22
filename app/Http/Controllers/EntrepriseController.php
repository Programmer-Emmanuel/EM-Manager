<?php

namespace App\Http\Controllers;

use App\Models\Comptes;
use App\Models\Conge;
use App\Models\Employe;
use App\Models\Entreprise;
use App\Models\Transactions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;

class EntrepriseController extends Controller{
    public function login(){
        return view('login');
    }

    public function postLogin(Request $request){
        
        $request->validate([
            'matricule' => 'required|string|max:8|min:8',
            'password' => 'required|string|min:6'
        ], [
            'matricule.required' => 'Le matricule est obligatoire',
            'matricule.string' => 'Le matricule doit être une chaîne de caractères',
            'matricule.max' => 'Le matricule ne doit pas dépasser 8 caractères',
            'matricule.min' => 'Le matricule doit contenir au moins 8 caractères',
            'password.required' => 'Le mot de passe est obligatoire',
            'password.string' => 'Le mot de passe doit être une chaîne de caractères',
            'password.min' => 'Le mot de passe doit contenir au moins 6 caractères',
        ]);

        // Connexion Entreprise
        $entreprise = Entreprise::where('matricule_entreprise', '=', $request->matricule)->first();
        
        if ($entreprise && Hash::check($request->password, $entreprise->motDePasse_entreprise)) {
            Auth::login($entreprise);
            return redirect()->route('dashboard_entreprise');
        }
        

        // Connexion Employé
        $employe = Employe::where('matricule_employe', $request->matricule)->first();

        if ($employe && Hash::check($request->password, $employe->mot_de_passe)) {
            Auth::guard('employe')->login($employe);
            Auth::login($employe);

            return redirect()->route('employe_dashboard');
        } else {
            return back()->withErrors(['error' => 'Identifiants incorrects']);
        }

        // Retour avec un message d'erreur si la connexion échoue
        return back()->withErrors(['error' => 'Matricule ou mot de passe introuvable ou incorrect'])->withInput();
    }

    public function register(){
        return view('register');
    }

    public function postRegister(Request $request){
        $request->validate([
            'nom_entreprise' => 'required|max:50',
            'nom_directeur' => 'required|max:30',
            'prenom_directeur' => 'required|max:100',
            'email_entreprise' => 'email|unique:entreprises',
            'motDePasse_entreprise' => 'required|min:6',
            'confirmation_password' => 'required|min:6|same:motDePasse_entreprise',
            'telephone' => 'required|string|max:15|regex:/^\+?[0-9\s\-]+$/'
        ], [
            'nom_entreprise.required' => 'Le nom de l’entreprise est obligatoire',
            'nom_entreprise.max' => 'Le nom de l’entreprise ne doit pas dépasser 50 caractères',
            'nom_directeur.required' => 'Le nom du directeur est obligatoire',
            'nom_directeur.max' => 'Le nom du directeur ne doit pas dépasser 30 caractères',
            'prenom_directeur.required' => 'Le prénom du directeur est obligatoire',
            'prenom_directeur.max' => 'Le prénom du directeur ne doit pas dépasser 100 caractères',
            'email_entreprise.email' => 'L’adresse email est invalide',
            'email_entreprise.unique' => 'Cette adresse email est déjà utilisée',
            'motDePasse_entreprise.required' => 'Le mot de passe est obligatoire',
            'motDePasse_entreprise.min' => 'Le mot de passe doit contenir au moins 6 caractères',
            'confirmation_password.required' => 'La confirmation du mot de passe est obligatoire',
            'confirmation_password.min' => 'La confirmation du mot de passe doit contenir au moins 6 caractères',
            'confirmation_password.same' => 'Les mots de passe ne correspondent pas',
            'telephone.required' => 'Le téléphone est obligatoire',
            'telephone.string' => 'Le téléphone doit être une chaîne de caractères',
            'telephone.max' => 'Le téléphone ne doit pas dépasser 15 caractères',
            'telephone.regex' => 'Le téléphone doit être au format international (+xx xxx xxx xxx)'
        ]);

        // Créer une nouvelle entreprise
        $entreprise = new Entreprise();
        $entreprise->nom_entreprise = $request->nom_entreprise;
        $entreprise->nom_directeur = $request->nom_directeur;
        $entreprise->prenom_directeur = $request->prenom_directeur;
        $entreprise->telephone_entreprise = $request->telephone;
        $entreprise->email_entreprise = $request->email_entreprise;
        $entreprise->motDePasse_entreprise = Hash::make($request->motDePasse_entreprise);
        $entreprise->save();

        // Authentifier automatiquement l'entreprise
        Auth::login($entreprise);

        //Creer le compte de l’entreprise
        $comptes = new Comptes();
        $comptes->entreprise_id = $entreprise->id;
        $comptes->montant = 0;
        $comptes->save();

        // Rediriger vers le tableau de bord avec l'ID haché
        return redirect()->route('dashboard_entreprise');
    }

    public function logout(Request $request){
        // Déconnexion de l'utilisateur
        Auth::logout();

        // Invalider la session actuelle
        $request->session()->invalidate();

        // Régénérer le token CSRF pour éviter les attaques
        $request->session()->regenerateToken();

        // Rediriger l'utilisateur (par exemple, vers la page de connexion)
        return redirect('/login');
    }

    public function entreprise_protect(){
        return view('entreprise_protect');
    }

    public function dashboard_entreprise(){
        // Récupérer l'entreprise connectée
        $entreprise = Auth::user();

        // Récupérer les détails de l'entreprise
        $entrepriseDetails = Entreprise::find($entreprise->id);

        // Récupérer la liste des employés de l'entreprise
        $count_employe = Employe::where('id_entreprise', '=', $entreprise->id)->count();

        $count_conge = Conge::where('id_entreprise', '=', $entreprise->id)->where('statut', '=', 'En attente...')->count();

        // Afficher la vue du tableau de bord
        return view('dashboard_entreprise', compact('entrepriseDetails','count_employe','count_conge'));
    }

    public function liste_employe(){
        // Récupérer l'entreprise connectée
        $entreprise = Auth::user();

        // Récupérer les détails de l'entreprise
        $entrepriseDetails = Entreprise::find($entreprise->id);

        // Récupérer la liste des employés de l'entreprise
        $employes = Employe::where('id_entreprise', '=', $entreprise->id)->get();

        // Afficher la vue du tableau de bord
        return view('liste_employe', compact('entrepriseDetails', 'employes'));
    }

    public function ajout_employe(){
        // Récupérer l'entreprise connectée
        $entreprise = Auth::user();

        // Récupérer les détails de l'entreprise
        $entrepriseDetails = Entreprise::find($entreprise->id);

        // Afficher la vue du tableau de bord
        return view('ajout_employe', compact('entrepriseDetails'));
    }

    public function store_employe(Request $request){
        // Validation des données
        $validatedData = $request->validate([
            'nom_employe' => 'required|string|max:255',
            'prenom_employe' => 'required|string|max:255',
            'adresse_employe' => 'required|string|max:255',
            'telephone' => 'required|string|max:15|regex:/^\+?[0-9\s\-]+$/',
            'email_employe' => 'required|email|max:255|unique:employes,email_employe',
            'poste' => 'required|string|max:255',
            'departement' => 'required|string|max:255',
            'salaire' => 'required|numeric|min:0',
        ], [
            'nom_employe.required' => 'Le nom est obligatoire',
            'nom_employe.string' => 'Le nom doit être une chaîne de caractères',
            'nom_employe.max' => 'Le nom ne doit pas dépasser 255 caractères',
            'prenom_employe.required' => 'Le prénom est obligatoire',
            'prenom_employe.string' => 'Le prénom doit être une chaîne de caractères',
            'prenom_employe.max' => 'Le prénom ne doit pas dépasser 255 caractères',
            'adresse_employe.required' => 'L\'adresse est obligatoire',
            'adresse_employe.string' => 'L\'adresse doit être une chaîne de caractères',
            'adresse_employe.max' => 'L\'adresse ne doit pas dépasser 255 caractères',
            'telephone.required' => 'Le téléphone est obligatoire',
            'telephone.string' => 'Le téléphone doit être une chaîne de caractères',
            'telephone.max' => 'Le téléphone ne doit pas dépasser 15 caractères',
            'telephone.regex' => 'Le téléphone doit être au format international (+xx xxx xxx xxx)',
            'email_employe.required' => 'L\'email est obligatoire',
            'email_employe.email' => 'L\'email est invalide',
            'email_employe.max' => 'L\'email ne doit pas dépasser 255 caractères',
            'email_employe.unique' => 'Cet email est déjà utilisé',
            'poste.required' => 'Le poste est obligatoire',
            'poste.string' => 'Le poste doit être une chaîne de caractères',
            'poste.max' => 'Le poste ne doit pas dépasser 255 caractères',
            'departement.required' => 'Le département est obligatoire',
            'departement.string' => 'Le département doit être une chaîne de caractères',
            'departement.max' => 'Le département ne doit pas dépasser 255 caractères',
            'salaire.required' => 'Le salaire est obligatoire',
            'salaire.numeric' => 'Le salaire doit être un nombre',
            'salaire.min' => 'Le salaire doit être supérieur ou égal à 0'
        ]);

        // Création d'un employé
        $entreprise = Auth::user();
        $entrepriseDetails = Entreprise::find($entreprise->id);

        $employe = new Employe();
        $employe->id_entreprise = $entrepriseDetails->id;
        $employe->nom_employe = $request->nom_employe;
        $employe->prenom_employe = $request->prenom_employe;
        $employe->adresse_employe = $request->adresse_employe;
        $employe->telephone = $request->telephone;
        $employe->email_employe = $request->email_employe;
        $employe->poste = $request->poste;
        $employe->departement = $request->departement;
        $employe->date_embauche = now()->toDateString();
        $employe->salaire = $request->salaire;
        $employe->save();

        // Redirection avec succès
        return redirect()->route('liste_employe');
    }

    public function edit_employe($encryptedId){
    try {
        // Décrypter l'ID
        $id = Crypt::decrypt($encryptedId);

        // Récupérer l'entreprise connectée
        $entreprise = Auth::user();
        $entrepriseDetails = Entreprise::find($entreprise->id);

        // Récupérer l'employé
        $employe = Employe::findOrFail($id);

        return view('edit_employe', compact('entrepriseDetails', 'employe'));
    } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
        abort(404, 'ID invalide ou employé introuvable');
    }
}

public function update_employe(Request $request, $encryptedId){
    try {
        Log::info('ID crypté reçu : ' . $encryptedId);
        $id = Crypt::decrypt($encryptedId);

        // Validation et mise à jour
        $validatedData = $request->validate([
            'nom_employe' => 'required|string|max:255',
            'prenom_employe' => 'required|string|max:255',
            'adresse_employe' => 'required|string|max:255',
            'telephone' => 'required|string|max:15|regex:/^\+?[0-9\s\-]+$/',
            'email_employe' => 'required|email|max:255|unique:employes,email_employe,' . $id,
            'poste' => 'required|string|max:255',
            'departement' => 'required|string|max:255',
            'salaire' => 'required|numeric|min:0',
        ]);

        $employe = Employe::findOrFail($id);
        $employe->update($validatedData);

        return redirect()->route('liste_employe')->with('success', 'Employé modifié avec succès');
    } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
        Log::error('Erreur de déchiffrement pour : ' . $encryptedId);
        abort(404, 'ID invalide ou employé introuvable');
    }
}


public function destroy_employe($hashedId){
    try {
        // Décoder l'ID hashé
        $id = Crypt::decryptString($hashedId);

        // Récupérer l'employé à supprimer
        $employe = Employe::findOrFail($id);

        // Supprimer l'employé
        $employe->delete();

        // Rediriger vers la liste des employés avec un message de succès
        return redirect()->route('liste_employe')->with('success', 'Employé supprimé avec succès');
    } catch (\Exception $e) {
        // Gérer les erreurs de décryptage ou de suppression
        return redirect()->route('liste_employe')->with('error', 'Erreur lors de la suppression. L\'ID est invalide ou corrompu.');
    }
}



public function export_employe(){
    // Création du fichier Excel
    $filename = 'liste_employes_' . date('Ymd_His') . '.xlsx';
    return \Maatwebsite\Excel\Facades\Excel::download(new \App\Exports\EmployesExport, $filename);
}

public function gestion_conge()
{
    $entreprise = Auth::user();
    $entrepriseDetails = Entreprise::find($entreprise->id);

    $conges = Conge::where('id_entreprise', $entrepriseDetails->id)
        ->get()
        ->map(function ($conge) {
            $conge->nom_employe = Employe::where('id', $conge->id_employe)->value('nom_employe');
            $conge->prenom_employe = Employe::where('id', $conge->id_employe)->value('prenom_employe');

            // Calcul de la durée en jours
            $debut = \Carbon\Carbon::parse($conge->date_debut);
            $fin = \Carbon\Carbon::parse($conge->date_fin);
            $difference = $debut->diff($fin);

            // Formater la durée
            if ($difference->y > 0) {
                $conge->duree = $difference->y . ' an' . ($difference->y > 1 ? 's' : '');
            } elseif ($difference->m > 0) {
                $conge->duree = $difference->m . ' mois';
            } else {
                $conge->duree = $difference->d . ' jour' . ($difference->d > 1 ? 's' : '');
            }

            return $conge;
        });

    return view('gestion_conge', compact('entrepriseDetails', 'conges'));
}


public function approuver($id)
    {
        // Trouver la demande de congé par son ID
        $conge = Conge::findOrFail($id);

        // Modifier le statut
        $conge->statut = 'Approuvé';
        $conge->save();

        // Rediriger avec un message de succès
        return redirect()->back()->with('success', 'La demande de congé a été approuvée.');
    }

    public function rejeter($id)
    {
        // Trouver la demande de congé par son ID
        $conge = Conge::findOrFail($id);

        // Modifier le statut
        $conge->statut = 'Rejeté';
        $conge->save();

        // Rediriger avec un message de succès
        return redirect()->back()->with('success', 'La demande de congé a été rejetée.');
    }

    public function comptes(){
        // Récupérer l'entreprise connectée
        $entreprise = Auth::user();

        // Récupérer les détails de l'entreprise
        $entrepriseDetails = Entreprise::find($entreprise->id);

        //Récupérer le compte de l’entreprise
        $comptes = Comptes::where('entreprise_id', $entreprise->id)->first();

        //Récupérer les transactions
        $transactions = Transactions::where('entreprise_id', $entreprise->id)->orderBy('created_at', 'desc')->get();

        return view('comptes', compact('entrepriseDetails', 'comptes', 'transactions'));
    }

    public function transactions(){
        // Récupérer l'entreprise connectée
        $entreprise = Auth::user();

        // Récupérer les détails de l'entreprise
        $entrepriseDetails = Entreprise::find($entreprise->id);

        return view('ajout_transaction', compact('entrepriseDetails'));
    }

    public function transactionsPost(Request $request){

        //entreprise connecté
        $entreprise = Auth::user();

        $request->validate([
            'motif' => 'required|string|max:255',
            'type' => 'required|in:Achat,Vente',
            'montant' => 'required|numeric|min:1',
        ], [
            'motif.required' => 'Le champ motif est obligatoire.',
            'motif.string' => 'Le motif doit être une chaîne de caractères.',
            'motif.max' => 'Le motif ne doit pas dépasser 255 caractères.',

            'type.required' => 'Le type de transaction est obligatoire.',
            'type.in' => 'Le type doit être soit Achat, soit Vente.',

            'montant.required' => 'Le montant est obligatoire.',
            'montant.numeric' => 'Le montant doit être un nombre.',
            'montant.min' => 'Le montant doit être supérieur à 0.',
        ]);

        $transaction = new Transactions();
        $transaction->motif = $request->motif;
        $transaction->type = $request->type;
        $transaction->montant = $request->montant;
        $transaction->entreprise_id = $entreprise->id;
        $transaction->save();


        //Mise à jour du compte
        $comptes = Comptes::where('entreprise_id', $entreprise->id)->first();
        if($request->type == 'Achat'){
            $comptes->montant -= $transaction->montant;
        }
        else{
            $comptes->montant += $transaction->montant;
        }
        $comptes->save();

        return redirect()->route('comptes');
    }    


    public function afficherConseils()
{
    // Récupérer l'entreprise connectée
    $entreprise = Auth::user();

    // Récupérer les détails de l'entreprise
    $entrepriseDetails = Entreprise::find($entreprise->id);

    // Récupération des transactions
    $transactions = Transactions::orderByDesc('created_at')->take(10)->get();

    // Construction du prompt
    $prompt = "Voici l’historique des transactions d’une entreprise (type: Achat ou Vente, montant, date):\n";

    foreach ($transactions as $t) {
        $prompt .= "- {$t->type} de " . number_format($t->montant, 0, ',', ' ') . " FCFA le " . $t->created_at->format('d/m/Y') . "\n";
    }

    $prompt .= "\nDonne 3 conseils financiers simples en français uniquement à cette entreprise. Réponds directement avec les conseils uniquement, sans introduction ni explication.";

    // Appel de l'API OpenRouter
    $response = Http::withHeaders([
        'Authorization' => 'Bearer ' . env('OPENROUTER_API_KEY'),
        'Content-Type' => 'application/json',
    ])->post('https://openrouter.ai/api/v1/chat/completions', [
        'model' => 'microsoft/phi-4-reasoning-plus:free',
        'messages' => [
            ['role' => 'user', 'content' => $prompt]
        ],
        'temperature' => 0.7
    ]);

    if ($response->successful()) {
        $contenu = $response->json('choices.0.message.content');

        // Extraire toutes les lignes commençant par un nombre suivi d'un point (ex: 1. xxx)
        preg_match_all('/^\d+\.\s*(.+)$/m', $contenu, $matches);

        if (!empty($matches[1])) {
            // Renumérotation des conseils avec saut de ligne entre chaque
            $conseilsRenumerotes = [];
            foreach ($matches[1] as $index => $texte) {
                $numero = $index + 1;
                $conseilsRenumerotes[] = $numero . '. ' . trim($texte);
            }
            // On ajoute un saut de ligne entre chaque conseil
            $conseils = implode("\n\n", $conseilsRenumerotes);
        } else {
            $conseils = 'Aucun conseil exploitable n’a été trouvé.';
        }
    } else {
        $conseils = 'Aucun conseil généré. Veuillez vérifier votre connexion ou votre clé API.';
    }

    return view('conseils', [
        'conseils' => $conseils,
        'entrepriseDetails' => $entrepriseDetails
    ]);
}





}