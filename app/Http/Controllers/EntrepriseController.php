<?php

namespace App\Http\Controllers;

use App\Models\Comptes;
use App\Models\Conge;
use App\Models\Employe;
use App\Models\Entreprise;
use App\Models\Produit;
use App\Models\Transactions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
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
        
        $transactions = Transactions::where('entreprise_id', $entreprise->id)->get();


        $driver = DB::getDriverName();

        $moisExpression = $driver === 'pgsql'
            ? DB::raw("to_char(created_at, 'YYYY-MM') as mois")
            : DB::raw("DATE_FORMAT(created_at, '%Y-%m') as mois");

        $transactionsParMois = Transactions::select(
                $moisExpression,
                DB::raw("SUM(montant) as total")
            )
            ->groupBy('mois')
            ->orderBy('mois')
            ->get();

        // On sépare mois et montants pour le graphique
        $labels = $transactionsParMois->pluck('mois');
        $data = $transactionsParMois->pluck('total');

        return view('dashboard_entreprise', compact(
            'entrepriseDetails',
            'count_employe',
            'count_conge',
            'transactions',
            'labels',
            'data'
        ));
    }

    public function liste_employe(){
        // Récupérer l'entreprise connectée
        $entreprise = Auth::user();

        // Récupérer les détails de l'entreprise
        $entrepriseDetails = Entreprise::find($entreprise->id);

        // Récupérer la liste des employés de l'entreprise
        $employes = Employe::where('id_entreprise', '=', $entreprise->id)->get();

        $count_conge = Conge::where('id_entreprise', '=', $entreprise->id)->where('statut', '=', 'En attente...')->count();

        // Afficher la vue du tableau de bord
        return view('liste_employe', compact('entrepriseDetails', 'employes', 'count_conge'));
    }

    public function ajout_employe(){
        // Récupérer l'entreprise connectée
        $entreprise = Auth::user();

        // Récupérer les détails de l'entreprise
        $entrepriseDetails = Entreprise::find($entreprise->id);

        $count_conge = Conge::where('id_entreprise', '=', $entreprise->id)->where('statut', '=', 'En attente...')->count();

        // Afficher la vue du tableau de bord
        return view('ajout_employe', compact('entrepriseDetails', 'count_conge'));
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

    public function edit_employe($id){
    try {
        // Récupérer l'entreprise connectée
        $entreprise = Auth::user();
        $entrepriseDetails = Entreprise::find($entreprise->id);

        // Récupérer l'employé
        $employe = Employe::find($id);

        $count_conge = Conge::where('id_entreprise', '=', $entreprise->id)->where('statut', '=', 'En attente...')->count();

        return view('edit_employe', compact('entrepriseDetails', 'employe', 'count_conge'));
    } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
        abort(404, 'ID invalide ou employé introuvable');
    }
}

public function update_employe(Request $request, $id){


        // Validation et mise à jour
        $validatedData = $request->validate([
            'nom_employe' => 'required|string|max:255',
            'prenom_employe' => 'required|string|max:255',
            'adresse_employe' => 'required|string|max:255',
            'telephone' => 'required|string|max:15|regex:/^\+?[0-9\s\-]+$/',
            'email_employe' => 'required|email|max:255',
            'poste' => 'required|string|max:255',
            'departement' => 'required|string|max:255',
            'salaire' => 'required|numeric|min:0',
        ]);

        $employe = Employe::find($id);
        $employe->update($validatedData);

        return redirect()->route('liste_employe')->with('success', 'Employé modifié avec succès');

}


public function destroy_employe($id){
    try {

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
        
    $count_conge = Conge::where('id_entreprise', '=', $entreprise->id)->where('statut', '=', 'En attente...')->count();

    return view('gestion_conge', compact('entrepriseDetails', 'conges', 'count_conge'));
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

        $count_conge = Conge::where('id_entreprise', '=', $entreprise->id)->where('statut', '=', 'En attente...')->count();

        return view('comptes', compact('entrepriseDetails', 'comptes', 'transactions', 'count_conge'));
    }

    public function transactions(){
        // Récupérer l'entreprise connectée
        $entreprise = Auth::user();

        // Récupérer les détails de l'entreprise
        $entrepriseDetails = Entreprise::find($entreprise->id);
        
        $count_conge = Conge::where('id_entreprise', '=', $entreprise->id)->where('statut', '=', 'En attente...')->count();


        return view('ajout_transaction', compact('entrepriseDetails', 'count_conge'));
    }

    public function transactionsPost(Request $request){

        //entreprise connecté
        $entreprise = Auth::user();

        $request->validate([
            'motif' => 'required|string|max:255',
            'type' => 'required|in:Entrée,Sortie',
            'montant' => 'required|numeric|min:1',
        ], [
            'motif.required' => 'Le champ motif est obligatoire.',
            'motif.string' => 'Le motif doit être une chaîne de caractères.',
            'motif.max' => 'Le motif ne doit pas dépasser 255 caractères.',

            'type.required' => 'Le type de transaction est obligatoire.',
            'type.in' => 'Le type doit être soit Entrée, soit Sortie.',

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
        if($request->type == 'Sortie'){
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
    $entreprise = Auth::user();
    $entrepriseDetails = Entreprise::find($entreprise->id);

    // Transactions récentes
    $transactions = Transactions::orderByDesc('created_at')->take(10)->get();

    // Construction du prompt
    $prompt = "Voici l’historique des transactions d’une entreprise (type: Entrée ou Sortie, montant, date):\n";
    foreach ($transactions as $t) {
        $prompt .= "- {$t->type} de " . number_format($t->montant, 0, ',', ' ') . " FCFA le " . $t->created_at->format('d/m/Y') . "\n";
    }
    $prompt .= "\nDonne 10 conseils financiers simples en français uniquement. 
    Réponds directement avec les conseils uniquement, sans introduction ni explication, sous forme de liste numérotée.";


    // Liste de modèles gratuits stables
    $models = [
        "deepseek/deepseek-chat",           // Très stable
        "google/gemma-2-2b-it",            // Léger et rapide
        "qwen/qwen2.5-3b-instruct",        // Version plus petite
        "microsoft/phi-3.5-mini-instruct", // Excellent pour les conseils
    ];

    $contenu = null;

    foreach ($models as $model) {

        try {
            $response = Http::timeout(45)
                ->withOptions(['verify' => false])
                ->withHeaders([
                    'Authorization' => 'Bearer ' . env('OPENROUTER_API_KEY'),
                    'Content-Type' => 'application/json',
                ])
                ->post('https://openrouter.ai/api/v1/chat/completions', [
                    'model'    => $model,
                    'messages' => [
                        ['role' => 'user', 'content' => $prompt]
                    ],
                    'temperature' => 0.7,
                ]);

            if ($response->successful()) {

                $contenu = $response->json('choices.0.message.content');
                break; // on quitte la boucle → on garde ce modèle
            }

            // Log en cas d'échec pour ce modèle
            Log::warning("Model failed: $model → " . $response->body());

        } catch (\Throwable $e) {
            Log::error("Erreur modèle $model : " . $e->getMessage());
        }
    }


    // Si aucun modèle n’a répondu
    if (!$contenu) {
        $conseils = "Aucun conseil généré. OpenRouter est temporairement indisponible.";
    } else {

        // Extraction des lignes numérotées
        preg_match_all('/^\d+\.\s*(.+)$/m', $contenu, $matches);

        if (!empty($matches[1])) {

            // Renumérotation propre
            $conseilsRenumerotes = [];
            foreach ($matches[1] as $i => $texte) {
                $conseilsRenumerotes[] = ($i + 1) . ". " . trim($texte);
            }

            // Formatage final
            $conseils = implode("\n\n", $conseilsRenumerotes);

        } else {
            $conseils = "Contenu reçu mais non exploitable.";
        }
    }

    $count_conge = Conge::where('id_entreprise', $entreprise->id)
        ->where('statut', 'En attente...')
        ->count();

    return view('conseils', [
        'conseils' => $conseils,
        'entrepriseDetails' => $entrepriseDetails,
        'count_conge' => $count_conge,
    ]);
}




public function chat(Request $request)
    {
        try {
            $user = Auth::user();
            $entreprise = Entreprise::find($user->id);
            
            // Récupérer les données contextuelles de l'entreprise
            $contextData = $this->getContextData($entreprise->id);
            
            // Construire le prompt avec le contexte
            $prompt = $this->buildPrompt($request->message, $contextData);
            
            // Liste de modèles gratuits
            $models = [
                "deepseek/deepseek-chat",           // Très stable
                "google/gemma-2-2b-it",            // Léger et rapide
                "qwen/qwen2.5-3b-instruct",        // Version plus petite
                "microsoft/phi-3.5-mini-instruct", // Excellent pour les conseils
            ];
            
            $responseContent = null;
            
            foreach ($models as $model) {
                try {
                    $response = Http::timeout(60)
                        ->withOptions(['verify' => false])
                        ->withHeaders([
                            'Authorization' => 'Bearer ' . env('OPENROUTER_API_KEY'),
                            'Content-Type' => 'application/json',
                        ])
                        ->post('https://openrouter.ai/api/v1/chat/completions', [
                            'model' => $model,
                            'messages' => [
                                [
                                    'role' => 'system',
                                    'content' => "Tu es ManagerAI, un assistant expert en gestion d'entreprise. Tu as accès aux données de l'entreprise et tu réponds en français de manière professionnelle et concise."
                                ],
                                ['role' => 'user', 'content' => $prompt]
                            ],
                            'temperature' => 0.7,
                            'max_tokens' => 1000,
                        ]);
                    
                    if ($response->successful()) {
                        $responseContent = $response->json('choices.0.message.content');
                        break;
                    }
                    
                    Log::warning("Modèle échoué: $model → " . $response->body());
                    
                } catch (\Throwable $e) {
                    Log::error("Erreur modèle $model : " . $e->getMessage());
                }
            }
            
            if (!$responseContent) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Impossible de contacter le service IA. Veuillez réessayer.'
                ]);
            }
            
            return response()->json([
                'status' => 'success',
                'response' => $responseContent
            ]);
            
        } catch (\Exception $e) {
            Log::error('Erreur Chat AI: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Une erreur est survenue. Veuillez réessayer.'
            ]);
        }
    }
    
    private function getContextData($entrepriseId)
    {
        // Transactions récentes
        $transactions = Transactions::where('entreprise_id', $entrepriseId)
            ->orderByDesc('created_at')
            ->take(10)
            ->get();
        
        // Détails de l'entreprise
        $entreprise = Entreprise::find($entrepriseId);
        
        // Employés
        $employes = Employe::where('id_entreprise', $entrepriseId)
            ->count();
        
        // Congés en attente
        $congesEnAttente = Conge::where('id_entreprise', $entrepriseId)
            ->where('statut', 'En attente...')
            ->count();
        
        // Compte (si disponible)
        $compte = Comptes::where('entreprise_id', $entrepriseId)->first();
        $solde = $compte ? $compte->montant : 0;
        
        return [
            'transactions' => $transactions,
            'entreprise' => $entreprise,
            'nombre_employes' => $employes,
            'conges_en_attente' => $congesEnAttente,
            'solde' => $solde
        ];
    }
    
    private function buildPrompt($question, $contextData)
    {
        $prompt = "Contexte de l'entreprise:\n\n";
        
        // Informations de l'entreprise
        $prompt .= "Nom de l'entreprise: " . $contextData['entreprise']->nom_entreprise . "\n";
        $prompt .= "Dirigeant: " . $contextData['entreprise']->prenom_directeur . " " . $contextData['entreprise']->nom_directeur . "\n";
        $prompt .= "Nombre d'employés: " . $contextData['nombre_employes'] . "\n";
        $prompt .= "Congés en attente: " . $contextData['conges_en_attente'] . "\n";
        $prompt .= "Solde disponible: " . number_format($contextData['solde'], 0, ',', ' ') . " FCFA\n\n";
        
        // Transactions récentes
        $prompt .= "Transactions récentes (10 dernières):\n";
        foreach ($contextData['transactions'] as $t) {
            $prompt .= "- " . $t->type . " de " . number_format($t->montant, 0, ',', ' ') . 
                      " FCFA pour '" . $t->motif . "' le " . $t->created_at->format('d/m/Y') . "\n";
        }
        
        // Question de l'utilisateur
        $prompt .= "\n\nQuestion de l'utilisateur: " . $question . "\n\n";
        
        $prompt .= "Instructions importantes:
        1. Réponds uniquement en français
        2. Sois professionnel et concis
        3. Utilise les données contextuelles pour personnaliser ta réponse
        4. Fais des recommandations pratiques et actionnables
        5. Si la question nécessite des données que tu n'as pas, le préciser
        6. Formatte ta réponse avec des paragraphes clairs";
        
        return $prompt;
    }



    // Ajoutez ces méthodes à la fin de votre EntrepriseController

public function paiement_employe()
    {
        $entreprise = Auth::user();
        $entrepriseDetails = Entreprise::find($entreprise->id);

        $employes = Employe::where('id_entreprise', '=', $entreprise->id)->get();

        foreach ($employes as $employe) {
            $employe->deja_paye_ce_mois = Transactions::where('entreprise_id', $entreprise->id)
                ->where('motif', 'like', '%Paiement salaire - ' . $employe->prenom_employe . ' ' . $employe->nom_employe . '%')
                ->whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->exists();
            
            $dernierPaiement = Transactions::where('entreprise_id', $entreprise->id)
                ->where('motif', 'like', '%Paiement salaire - ' . $employe->prenom_employe . ' ' . $employe->nom_employe . '%')
                ->latest()
                ->first();
            
            $employe->date_dernier_paiement = $dernierPaiement ? $dernierPaiement->created_at : null;
        }

        $compte = Comptes::where('entreprise_id', $entreprise->id)->first();
        $count_conge = Conge::where('id_entreprise', '=', $entreprise->id)
            ->where('statut', '=', 'En attente...')
            ->count();

        return view('paiement_employe', compact('entrepriseDetails', 'employes', 'compte', 'count_conge'));
    }

    public function process_paiement(Request $request)
{
    $request->validate([
        'employe_id' => 'required|exists:employes,id',
        'montant' => 'required|numeric|min:100',
    ]);

    try {
        $entreprise = Auth::user();
        $employe = Employe::findOrFail($request->employe_id);
        
        // Vérifier que l'employé appartient à l'entreprise
        if ($employe->id_entreprise != $entreprise->id) {
            return response()->json([
                'status' => 'error',
                'message' => 'Employé non autorisé'
            ], 403);
        }

        // Utiliser directement le salaire de l'employé
        $montantAPayer = $employe->salaire;
        
        // Vérifier que le montant envoyé correspond bien au salaire (sécurité)
        if (abs($request->montant - $montantAPayer) > 0.01) {
            return response()->json([
                'status' => 'error',
                'message' => 'Le montant doit correspondre au salaire de l\'employé'
            ]);
        }

        // Vérifier le solde
        $compte = Comptes::where('entreprise_id', $entreprise->id)->first();
        if (!$compte || $compte->montant < $montantAPayer) {
            return response()->json([
                'status' => 'error',
                'message' => 'Solde insuffisant'
            ]);
        }

        // Vérifier si déjà payé ce mois
        $dejaPaye = Transactions::where('entreprise_id', $entreprise->id)
            ->where('motif', 'like', '%Paiement salaire - ' . $employe->prenom_employe . ' ' . $employe->nom_employe . '%')
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->exists();
        
        if ($dejaPaye) {
            return response()->json([
                'status' => 'error',
                'message' => 'Cet employé a déjà été payé ce mois-ci'
            ]);
        }

        // Générer une référence unique pour le paiement
        $reference = 'PAY_' . time() . '_' . strtoupper(uniqid());

        // S'assurer que la clé KkiaPay existe
        $publicKey = config('services.kkiapay.public_key');
        if (!$publicKey) {
            Log::error('Clé publique KkiaPay non configurée');
            return response()->json([
                'status' => 'error',
                'message' => 'Configuration de paiement incomplète'
            ]);
        }

        // URL de callback ABSOLUE (très important pour KkiaPay)
        $callbackUrl = route('paiement.callback');
        
        // Vérifier que l'URL est bien formée
        if (!filter_var($callbackUrl, FILTER_VALIDATE_URL)) {
            Log::error('URL de callback invalide', ['url' => $callbackUrl]);
            return response()->json([
                'status' => 'error',
                'message' => 'Erreur de configuration du callback'
            ]);
        }

        Log::info('Préparation paiement', [
            'employe' => $employe->prenom_employe . ' ' . $employe->nom_employe,
            'montant' => $montantAPayer,
            'reference' => $reference,
            'callback_url' => $callbackUrl
        ]);

        return response()->json([
            'status' => 'success',
            'data' => [
                'employe' => [
                    'id' => $employe->id,
                    'nom' => $employe->nom_employe,
                    'prenom' => $employe->prenom_employe,
                    'email' => $employe->email ?? '',
                    'telephone' => $employe->telephone ?? ''
                ],
                'montant' => $montantAPayer,
                'reference' => $reference,
                'public_key' => $publicKey,
                'callback' => $callbackUrl, // URL absolue pour KkiaPay
            ]
        ]);

    } catch (\Exception $e) {
        Log::error('Erreur process_paiement: ' . $e->getMessage(), [
            'trace' => $e->getTraceAsString(),
            'request' => $request->all()
        ]);
        return response()->json([
            'status' => 'error',
            'message' => 'Une erreur est survenue lors de la préparation du paiement'
        ], 500);
    }
}

    public function callback(Request $request)
{
    try {
        Log::info('Callback KkiaPay reçu', $request->all());

        // Vérifier le statut du paiement
        if ($request->input('status') !== 'SUCCESS') {
            Log::info('Paiement non réussi', ['status' => $request->input('status')]);
            return response()->json(['status' => 'ignored']);
        }

        // Décoder les données envoyées avec le paiement
        $data = json_decode($request->input('data'), true);

        if (!$data) {
            Log::error('Data vide ou invalide dans callback');
            return response()->json(['status' => 'error']);
        }

        $reference = $data['reference'] ?? null;
        $employeId = $data['employe_id'] ?? null;
        $type = $data['type'] ?? 'salaire';

        if (!$reference || !$employeId) {
            Log::error('Données manquantes dans callback', $data);
            return response()->json(['status' => 'error']);
        }

        // 🔒 Vérifier l'anti-doublon
        if (Transactions::where('reference', $reference)->exists()) {
            Log::info('Transaction déjà enregistrée', ['reference' => $reference]);
            return response()->json(['status' => 'already_saved']);
        }

        // Récupérer l'employé
        $employe = Employe::find($employeId);
        if (!$employe) {
            Log::error('Employé non trouvé', ['employe_id' => $employeId]);
            return response()->json(['status' => 'error']);
        }

        // Récupérer l'entreprise de l'employé
        $entrepriseId = $employe->id_entreprise;

        // ✅ Enregistrement de la transaction
        $transaction = new Transactions();
        $transaction->entreprise_id = $entrepriseId;
        $transaction->type = 'Sortie';
        $transaction->montant = $employe->salaire;
        $transaction->motif = 'Paiement salaire - ' . $employe->prenom_employe . ' ' . $employe->nom_employe;
        $transaction->reference = $reference;
        $transaction->statut = 'success';
        $transaction->save();

        // ✅ Mise à jour du solde du compte
        $compte = Comptes::where('entreprise_id', $entrepriseId)->first();
        if ($compte) {
            $compte->montant -= $employe->salaire;
            $compte->save();
            Log::info('Solde mis à jour', [
                'entreprise_id' => $entrepriseId,
                'nouveau_solde' => $compte->montant,
                'montant_déduit' => $employe->salaire
            ]);
        }

        Log::info('Transaction enregistrée avec succès', [
            'reference' => $reference,
            'employe' => $employe->prenom_employe . ' ' . $employe->nom_employe,
            'montant' => $employe->salaire
        ]);

        return response()->json(['status' => 'success']);

    } catch (\Exception $e) {
        Log::error('Erreur dans callback paiement : ' . $e->getMessage(), [
            'trace' => $e->getTraceAsString()
        ]);
        return response()->json(['status' => 'error'], 500);
    }
}


    public function historique_paiements()
    {
        $entreprise = Auth::user();
        $entrepriseDetails = Entreprise::find($entreprise->id);

        $paiements = Transactions::where('entreprise_id', $entreprise->id)
            ->where('motif', 'like', 'Paiement salaire%')
            ->orderBy('created_at', 'desc')
            ->get();

        $paiements->transform(function ($paiement) {
            preg_match('/Paiement salaire - (.*)/', $paiement->motif, $matches);
            $paiement->employe_nom = $matches[1] ?? 'N/A';
            return $paiement;
        });

        $count_conge = Conge::where('id_entreprise', '=', $entreprise->id)
            ->where('statut', '=', 'En attente...')
            ->count();

        return view('historique_paiements', compact('entrepriseDetails', 'paiements', 'count_conge'));
    }

    // Route pour webhook KkiaPay (optionnel)
    public function webhook(Request $request)
    {
        // Logique pour vérifier les paiements via webhook
        $signature = $request->header('x-kkiapay-signature');
        $payload = $request->getContent();
        
        // Vérifier la signature (à implémenter selon la doc KkiaPay)
        
        $data = $request->all();
        Log::info('Webhook KkiaPay:', $data);
        
        return response()->json(['status' => 'received']);
    }


    /**
     * Callback pour le frontend (appelé après paiement)
     */
    public function paiement_callback(Request $request)
    {
        try {
            $transactionId = $request->transaction_id;
            
            if (!$transactionId) {
                Log::error('Callback sans transaction_id');
                return response()->json(['status' => 'error', 'message' => 'Transaction ID manquant'], 400);
            }

            // NE PAS FAIRE la vérification ici, attendre le webhook
            // Juste indiquer au front que le paiement est en attente de vérification
            
            return response()->json([
                'status' => 'pending',
                'message' => 'Paiement en cours de vérification',
                'transaction_id' => $transactionId
            ]);

        } catch (\Exception $e) {
            Log::error('Erreur callback paiement: ' . $e->getMessage());
            return response()->json(['status' => 'error', 'message' => 'Erreur serveur'], 500);
        }
    }

    /**
     * Webhook KkiaPay (VERIFICATION SECURISEE)
     * IMPORTANT: Configurer cette URL dans le dashboard KkiaPay
     */
    public function webhookKkiaPay(Request $request)
    {
        try {
            $signature = $request->header('X-Kkiapay-Signature');
            $payload = $request->getContent();
            
            // Vérifier la signature
            $expectedSignature = hash_hmac('sha256', $payload, config('services.kkiapay.secret'));
            
            if (!hash_equals($expectedSignature, $signature)) {
                Log::error('Signature webhook invalide');
                return response()->json(['error' => 'Signature invalide'], 400);
            }
            
            $data = $request->json()->all();
            Log::info('Webhook KkiaPay reçu:', $data);
            
            if ($data['status'] == 'SUCCESS') {
                $transactionId = $data['transaction_id'];
                $metadata = $data['metadata'] ?? [];
                $employeId = $metadata['employe_id'] ?? null;
                $montant = $data['amount'];
                
                if (!$employeId) {
                    Log::error('Webhook sans employe_id dans metadata');
                    return response()->json(['error' => 'Metadata manquante'], 400);
                }
                
                $employe = Employe::find($employeId);
                if (!$employe) {
                    Log::error('Employé non trouvé pour ID: ' . $employeId);
                    return response()->json(['error' => 'Employé non trouvé'], 404);
                }
                
                $entreprise = Entreprise::find($employe->id_entreprise);
                if (!$entreprise) {
                    Log::error('Entreprise non trouvée');
                    return response()->json(['error' => 'Entreprise non trouvée'], 404);
                }
                
                // Vérifier si la transaction existe déjà
                $transactionExistante = Transactions::where('reference', $transactionId)->first();
                if ($transactionExistante) {
                    Log::info('Transaction déjà traitée: ' . $transactionId);
                    return response()->json(['status' => 'already_processed']);
                }
                
                // Créer la transaction
                $transaction = new Transactions();
                $transaction->motif = 'Paiement salaire - ' . $employe->prenom_employe . ' ' . $employe->nom_employe;
                $transaction->type = 'Sortie';
                $transaction->montant = $montant;
                $transaction->entreprise_id = $entreprise->id;
                $transaction->reference = $transactionId;
                $transaction->save();

                // Mettre à jour le compte
                $compte = Comptes::where('entreprise_id', $entreprise->id)->first();
                if ($compte) {
                    $compte->montant -= $montant;
                    $compte->save();
                }

                Log::info('Transaction enregistrée avec succès: ' . $transactionId);
                return response()->json(['status' => 'success']);
            }
            
            // Gérer les autres statuts
            Log::info('Transaction non réussie', ['status' => $data['status']]);
            return response()->json(['status' => 'not_successful']);

        } catch (\Exception $e) {
            Log::error('Erreur webhook KkiaPay: ' . $e->getMessage() . "\n" . $e->getTraceAsString());
            return response()->json(['error' => 'Erreur serveur'], 500);
        }
    }

    /**
     * Vérifier manuellement une transaction (fallback)
     */
    public function verifierTransaction(Request $request)
    {
        try {
            $transactionId = $request->transaction_id;
            
            if (!$transactionId) {
                return response()->json(['status' => 'error', 'message' => 'Transaction ID manquant'], 400);
            }
            
            // Appel API KkiaPay pour vérifier
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . config('services.kkiapay.private_key'),
                'Accept' => 'application/json',
            ])->get(config('services.kkiapay.api_url') . '/api/v1/transactions/' . $transactionId);
            
            if ($response->successful()) {
                $data = $response->json();
                
                if ($data['status'] === 'SUCCESS') {
                    // Traiter comme le webhook
                    $metadata = $data['metadata'] ?? [];
                    $employeId = $metadata['employe_id'] ?? null;
                    
                    if ($employeId) {
                        // ... même traitement que le webhook ...
                        return response()->json(['status' => 'success', 'data' => $data]);
                    }
                }
                
                return response()->json(['status' => $data['status'], 'data' => $data]);
            }
            
            return response()->json(['status' => 'error', 'message' => 'Impossible de vérifier'], 500);

        } catch (\Exception $e) {
            Log::error('Erreur vérification transaction: ' . $e->getMessage());
            return response()->json(['status' => 'error', 'message' => 'Erreur serveur'], 500);
        }
    }


public function liste_produits()
{
    $entreprise = Auth::user();
    $entrepriseDetails = Entreprise::find($entreprise->id);

    $produits = Produit::where('id_entreprise', $entreprise->id)
        ->orderBy('created_at', 'desc')
        ->get();

    $count_conge = Conge::where('id_entreprise', '=', $entreprise->id)
        ->where('statut', '=', 'En attente...')
        ->count();

    return view('liste_produit', compact('entrepriseDetails', 'produits', 'count_conge'));
}

public function ajout_produit()
{
    $entreprise = Auth::user();
    $entrepriseDetails = Entreprise::find($entreprise->id);

    $count_conge = Conge::where('id_entreprise', '=', $entreprise->id)
        ->where('statut', '=', 'En attente...')
        ->count();

    return view('ajout_produit', compact('entrepriseDetails', 'count_conge'));
}

public function store_produit(Request $request)
{
    $request->validate([
        'nom' => 'required|string|max:255',
        'description' => 'required|string',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ], [
        'nom.required' => 'Le nom du produit est obligatoire',
        'nom.max' => 'Le nom ne doit pas dépasser 255 caractères',
        'description.required' => 'La description est obligatoire',
        'image.image' => 'Le fichier doit être une image',
        'image.mimes' => 'L\'image doit être au format: jpeg, png, jpg, gif',
        'image.max' => 'L\'image ne doit pas dépasser 2Mo',
    ]);

    try {
        $entreprise = Auth::user();

        $produit = new Produit();
        $produit->nom = $request->nom;
        $produit->description = $request->description;
        $produit->id_entreprise = $entreprise->id;

        // Upload de l'image si elle existe
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $produit->image = $this->uploadImageToHosting($request->file('image'));
        }

        $produit->save();

        return redirect()->route('liste_produits')
            ->with('success', 'Produit créé avec succès!');

    } catch (\Exception $e) {
        return redirect()->back()
            ->with('error', 'Erreur lors de la création: ' . $e->getMessage())
            ->withInput();
    }
}

public function edit_produit($id)
{
    try {
        $entreprise = Auth::user();
        $entrepriseDetails = Entreprise::find($entreprise->id);

        $produit = Produit::where('id', $id)
            ->where('id_entreprise', $entreprise->id)
            ->firstOrFail();

        $count_conge = Conge::where('id_entreprise', '=', $entreprise->id)
            ->where('statut', '=', 'En attente...')
            ->count();

        return view('edit_produit', compact('entrepriseDetails', 'produit', 'count_conge'));

    } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
        abort(404, 'Produit non trouvé');
    }
}

public function update_produit(Request $request, $id)
{
    $request->validate([
        'nom' => 'required|string|max:255',
        'description' => 'required|string',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ], [
        'nom.required' => 'Le nom du produit est obligatoire',
        'nom.max' => 'Le nom ne doit pas dépasser 255 caractères',
        'description.required' => 'La description est obligatoire',
        'image.image' => 'Le fichier doit être une image',
        'image.mimes' => 'L\'image doit être au format: jpeg, png, jpg, gif',
        'image.max' => 'L\'image ne doit pas dépasser 2Mo',
    ]);

    try {
        $entreprise = Auth::user();

        $produit = Produit::where('id', $id)
            ->where('id_entreprise', $entreprise->id)
            ->firstOrFail();

        $produit->nom = $request->nom;
        $produit->description = $request->description;

        // Upload de la nouvelle image si elle existe
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $produit->image = $this->uploadImageToHosting($request->file('image'));
        }

        $produit->save();

        return redirect()->route('liste_produits')
            ->with('success', 'Produit mis à jour avec succès!');

    } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
        abort(404, 'Produit non trouvé');
    } catch (\Exception $e) {
        return redirect()->back()
            ->with('error', 'Erreur lors de la mise à jour: ' . $e->getMessage())
            ->withInput();
    }
}

public function destroy_produit($id)
{
    try {
        $entreprise = Auth::user();

        $produit = Produit::where('id', $id)
            ->where('id_entreprise', $entreprise->id)
            ->firstOrFail();

        $produit->delete();

        return response()->json([
            'success' => true,
            'message' => 'Produit supprimé avec succès'
        ]);

    } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
        return response()->json([
            'success' => false,
            'message' => 'Produit non trouvé'
        ], 404);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Erreur lors de la suppression'
        ], 500);
    }
}

private function uploadImageToHosting($image)
{
    $apiKey = 'e983b56d6b5aa7ac66a62db04de45396'; // ⚠️ Mets ta vraie clé ici

    // Vérifier que le fichier est valide
    if (!$image || !$image->isValid()) {
        throw new \Exception("Fichier image non valide.");
    }

    // Encoder l'image en base64
    $imageContent = base64_encode(file_get_contents($image->getRealPath()));

    // Envoi vers ImgBB
    $response = Http::asForm()->post('https://api.imgbb.com/1/upload', [
        'key'   => $apiKey,
        'image' => $imageContent,
    ]);

    // Debug si erreur
    if (!$response->successful()) {
        throw new \Exception(
            "Erreur ImgBB : " . $response->status() . " - " . $response->body()
        );
    }

    // Retourner l'URL de l'image hébergée
    return $response->json()['data']['url'];
}

}