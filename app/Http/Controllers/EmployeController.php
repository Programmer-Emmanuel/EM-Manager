<?php

namespace App\Http\Controllers;

use App\Models\Conge;
use App\Models\Employe;
use App\Models\Entreprise;
use App\Models\Presence;
use App\Models\Produit;
use App\Models\Transactions;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class EmployeController extends Controller
{
public function employe_dashboard()
    {
        // Vérifier si un employé est connecté
        $employe = Auth::guard('employe')->user();
        Auth::login($employe);

        // Récupérer les détails de l'employé
        $employeDetails = Employe::find($employe->id);
        $entreprise = Entreprise::find($employeDetails->id_entreprise);

        // ---------- STATISTIQUES FINANCIÈRES ----------
        // Total des salaires perçus
        $totalSalaire = Transactions::where('employe_id', $employe->id)
            ->where('type', 'Sortie')
            ->where('statut', 'success')
            ->sum('montant');

        // Salaire du mois en cours
        $salaireMois = Transactions::where('employe_id', $employe->id)
            ->where('type', 'Sortie')
            ->where('statut', 'success')
            ->whereBetween('created_at', [now()->startOfMonth(), now()->endOfMonth()])
            ->sum('montant');

        // Dernier paiement
        $dernierPaiement = Transactions::where('employe_id', $employe->id)
            ->where('type', 'Sortie')
            ->where('statut', 'success')
            ->orderBy('created_at', 'desc')
            ->first();

        // Salaire de base
        $salaireBase = $employeDetails->salaire;

        // ---------- STATISTIQUES DE CONGÉS ----------
        // Total des congés pris
        $totalCongesPris = Conge::where('id_employe', $employe->id)
            ->where('statut', 'Approuvé')
            ->count();

        // Congés en attente
        $congesEnAttente = Conge::where('id_employe', $employe->id)
            ->where('statut', 'En attente...')
            ->count();

        // Congés approuvés cette année
        $congesApprouvesAnnee = Conge::where('id_employe', $employe->id)
            ->where('statut', 'Approuvé')
            ->whereYear('created_at', now()->year)
            ->count();

        // Jours de congés pris cette année
        $joursCongesPris = Conge::where('id_employe', $employe->id)
            ->where('statut', 'Approuvé')
            ->whereYear('date_debut', now()->year)
            ->get()
            ->sum(function($conge) {
                return $conge->date_debut->diffInDays($conge->date_fin) + 1;
            });

        // ---------- STATISTIQUES D'ANCIENNETÉ ----------
        // Date d'embauche
        $dateEmbauche = $employeDetails->date_embauche;
        $ancienneteJours = now()->diffInDays($dateEmbauche);
        $ancienneteMois = now()->diffInMonths($dateEmbauche);
        $ancienneteAns = now()->diffInYears($dateEmbauche);

        // ---------- DONNÉES POUR LES GRAPHIQUES ----------
        
        // 1. GRAPHIQUE CIRCULAIRE - Répartition des salaires (12 derniers mois)
        $salaireParMois = Transactions::where('employe_id', $employe->id)
            ->where('type', 'Sortie')
            ->where('statut', 'success')
            ->where('created_at', '>=', now()->subMonths(11)->startOfMonth())
            ->selectRaw('YEAR(created_at) as annee, MONTH(created_at) as mois, SUM(montant) as total')
            ->groupBy('annee', 'mois')
            ->orderBy('annee', 'asc')
            ->orderBy('mois', 'asc')
            ->get()
            ->keyBy(function($item) {
                return $item->annee . '-' . str_pad($item->mois, 2, '0', STR_PAD_LEFT);
            });

        // Générer les 12 derniers mois avec leurs noms
        $moisLabels = [];
        $salaireData = [];
        for ($i = 11; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $key = $date->format('Y-m');
            $moisLabels[] = $date->isoFormat('MMM YYYY');
            $salaireData[] = isset($salaireParMois[$key]) ? (int)$salaireParMois[$key]->total : 0;
        }

        // 2. GRAPHIQUE EN BARRES - Répartition des salaires par année
        $salaireParAnnee = Transactions::where('employe_id', $employe->id)
            ->where('type', 'Sortie')
            ->where('statut', 'success')
            ->selectRaw('YEAR(created_at) as annee, SUM(montant) as total')
            ->groupBy('annee')
            ->orderBy('annee', 'desc')
            ->limit(5)
            ->get();

        $anneeLabels = $salaireParAnnee->pluck('annee')->toArray();
        $anneeData = $salaireParAnnee->pluck('total')->toArray();

        // 3. STATISTIQUES DES CONGÉS POUR GRAPHIQUE CIRCULAIRE
        $statsConges = [
            'Approuvé' => Conge::where('id_employe', $employe->id)->where('statut', 'Approuvé')->count(),
            'En attente...' => Conge::where('id_employe', $employe->id)->where('statut', 'En attente...')->count(),
            'Refusé' => Conge::where('id_employe', $employe->id)->where('statut', 'Refusé')->count(),
        ];
        // Dans employe_dashboard(), après les autres requêtes :

        // Récupérer le nombre total de paiements pour le lien
        $paiements = Transactions::where('employe_id', $employe->id)
            ->where('type', 'Sortie')
            ->where('statut', 'success')
            ->select('id')
            ->get();


        // 4. ÉVOLUTION DES CONGÉS PAR MOIS
        $congesParMois = Conge::where('id_employe', $employe->id)
            ->where('statut', 'Approuvé')
            ->whereYear('date_debut', now()->year)
            ->selectRaw('MONTH(date_debut) as mois, COUNT(*) as total')
            ->groupBy('mois')
            ->orderBy('mois')
            ->get()
            ->keyBy('mois');

        $moisNoms = ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Jun', 'Jul', 'Aoû', 'Sep', 'Oct', 'Nov', 'Déc'];
        $congesMoisData = [];
        for ($i = 1; $i <= 12; $i++) {
            $congesMoisData[] = isset($congesParMois[$i]) ? $congesParMois[$i]->total : 0;
        }

        // ---------- NOTIFICATIONS ----------
        $notifications = [];

        // Vérifier si le salaire du mois a été payé
        if ($salaireMois > 0) {
            $notifications[] = [
                'type' => 'success',
                'icon' => 'fa-check-circle',
                'message' => 'Votre salaire du mois ' . now()->isoFormat('MMMM YYYY') . ' a été versé.',
                'time' => 'Maintenant'
            ];
        }

        // Vérifier les congés en attente
        if ($congesEnAttente > 0) {
            $notifications[] = [
                'type' => 'warning',
                'icon' => 'fa-clock',
                'message' => "Vous avez {$congesEnAttente} demande(s) de congé en attente.",
                'time' => 'En cours'
            ];
        }

        // Vérifier l'ancienneté (anniversaire d'embauche)
        if ($ancienneteAns > 0 && $dateEmbauche->format('m-d') == now()->format('m-d')) {
            $notifications[] = [
                'type' => 'info',
                'icon' => 'fa-birthday-cake',
                'message' => "Félicitations ! Vous fêtez vos {$ancienneteAns} an(s) dans l'entreprise aujourd'hui.",
                'time' => 'Aujourd\'hui'
            ];
        }

        // ---------- PROGRESSIONS ----------
        // Progression vers le salaire annuel (basé sur salaire de base * 12)
        $salaireAnnuelEstime = $salaireBase * 12;
        $progressionSalaireAnnuel = $salaireAnnuelEstime > 0 ? round(($totalSalaire / $salaireAnnuelEstime) * 100) : 0;

        return view('employe_dashboard', compact(
            'employeDetails',
            'entreprise',
            'totalSalaire',
            'salaireMois',
            'dernierPaiement',
            'salaireBase',
            'totalCongesPris',
            'congesEnAttente',
            'congesApprouvesAnnee',
            'joursCongesPris',
            'dateEmbauche',
            'ancienneteJours',
            'ancienneteMois',
            'ancienneteAns',
            'moisLabels',
            'salaireData',
            'anneeLabels',
            'anneeData',
            'statsConges',
            'moisNoms',
            'congesMoisData',
            'notifications',
            'progressionSalaireAnnuel',
            'paiements',
            'salaireAnnuelEstime'

        ));
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

    return redirect()->route('employe_compte')->with('success', 'Votre mot de passe a été modifié avec succès.');
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
            'type_conge.required' => 'Veuillez renseigner la raison.'
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

    public function employe_disabled(){
        return view('employe_disabled');
    }

    public function employe_historique_paiements()
    {
        // Vérifier si un employé est connecté
        $employe = Auth::guard('employe')->user();
        Auth::login($employe);

        // Récupérer les détails de l'employé
        $employeDetails = Employe::find($employe->id);
        $entreprise = Entreprise::find($employeDetails->id_entreprise);

        // Récupérer tous les paiements de cet employé
        $paiements = Transactions::where('employe_id', $employe->id)
            ->where('type', 'Sortie')
            ->orderBy('created_at', 'desc')
            ->paginate(15); // Pagination de 15 résultats par page

        // Calculer les statistiques
        $totalPaiements = Transactions::where('employe_id', $employe->id)
            ->where('type', 'Sortie')
            ->sum('montant');

        $dernierPaiement = Transactions::where('employe_id', $employe->id)
            ->where('type', 'Sortie')
            ->orderBy('created_at', 'desc')
            ->first();

        $paiementsCeMois = Transactions::where('employe_id', $employe->id)
            ->where('type', 'Sortie')
            ->whereBetween('created_at', [now()->startOfMonth(), now()->endOfMonth()])
            ->count();

        $montantCeMois = Transactions::where('employe_id', $employe->id)
            ->where('type', 'Sortie')
            ->whereBetween('created_at', [now()->startOfMonth(), now()->endOfMonth()])
            ->sum('montant');

        // Statistiques par année
        $paiementsParAnnee = Transactions::where('employe_id', $employe->id)
            ->where('type', 'Sortie')
            ->selectRaw('YEAR(created_at) as annee, COUNT(*) as total_paiements, SUM(montant) as total_montant')
            ->groupBy('annee')
            ->orderBy('annee', 'desc')
            ->get();

        return view('employe_historique_paiements', compact(
            'employeDetails',
            'entreprise',
            'paiements',
            'totalPaiements',
            'dernierPaiement',
            'paiementsCeMois',
            'montantCeMois',
            'paiementsParAnnee'
        ));
    }


    public function employe_produits()
    {
        // Vérifier si un employé est connecté
        $employe = Auth::guard('employe')->user();
        Auth::login($employe);

        // Récupérer les détails de l'employé
        $employeDetails = Employe::find($employe->id);
        $entreprise = Entreprise::find($employeDetails->id_entreprise);

        // Récupérer tous les produits de l'entreprise
        $produits = Produit::where('id_entreprise', $employeDetails->id_entreprise)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('employe_produits', compact(
            'employeDetails',
            'entreprise',
            'produits'
        ));
    }


    //Pointer sa presence par employé
    public function pointage()
    {
        $employe = Auth::guard('employe')->user();
        Auth::login($employe);

        $employeDetails = Employe::find($employe->id);
        $entreprise = Entreprise::find($employeDetails->id_entreprise);

        // Vérifier si l'employé a déjà pointé aujourd'hui
        $presenceAujourdhui = Presence::where('id_employe', $employe->id)
            ->whereDate('date', today())
            ->first();

        // Récupérer les 5 dernières présences
        $dernieresPresences = Presence::where('id_employe', $employe->id)
            ->orderBy('date', 'desc')
            ->orderBy('heure_arrivee', 'desc')
            ->limit(5)
            ->get();

        // Statistiques du mois
        $statistiques = $this->getStatistiques($employe->id);

        return view('employe_pointage', compact(
            'employeDetails',
            'entreprise',
            'presenceAujourdhui',
            'dernieresPresences',
            'statistiques'
        ));
    }


    public function arriver(Request $request)
    {
        $employe = Auth::guard('employe')->user();
        
        // Vérifier si déjà pointé aujourd'hui
        $existing = Presence::where('id_employe', $employe->id)
            ->whereDate('date', today())
            ->first();
            
        if ($existing) {
            return redirect()->back()->with('error', 'Vous avez déjà pointé votre arrivée aujourd\'hui à ' . $existing->heure_arrivee);
        }

        // Récupérer les informations
        $userAgent = $request->userAgent();
        $ip = $request->ip();
        
        // Obtenir l'adresse à partir des coordonnées GPS (si fournies)
        $adresse = null;
        if ($request->latitude && $request->longitude) {
            $adresse = $this->getAdresseFromCoordinates($request->latitude, $request->longitude);
        }

        $heure = now()->format('H:i:s');
        $heureLimite = '08:00:00';
        
        Presence::create([
            'id_employe' => $employe->id,
            'id_entreprise' => $employe->id_entreprise,
            'date' => today(),
            'heure_arrivee' => $heure,
            'statut' => $heure > $heureLimite ? 'retard' : 'present',
            'adresse_pointage' => $adresse,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'adresse_ip' => $ip,
            'navigateur' => $this->extraireNavigateur($userAgent),
        ]);

        return redirect()->back()->with('success', 'Arrivée enregistrée avec succès à ' . $heure);
    }

    public function depart(Request $request)
    {
        $employe = Auth::guard('employe')->user();
        
        $presence = Presence::where('id_employe', $employe->id)
            ->whereDate('date', today())
            ->first();

        if (!$presence) {
            return redirect()->back()->with('error', 'Vous n\'avez pas encore pointé votre arrivée aujourd\'hui');
        }

        if ($presence->heure_depart) {
            return redirect()->back()->with('error', 'Vous avez déjà pointé votre départ à ' . $presence->heure_depart);
        }

        $heureDepart = now()->format('H:i:s');
        $presence->update([
            'heure_depart' => $heureDepart
        ]);

        return redirect()->back()->with('success', 'Départ enregistré avec succès à ' . $heureDepart);
    }

    public function listePresences()
    {
        $employe = Auth::guard('employe')->user();
        Auth::login($employe);

        $employeDetails = Employe::find($employe->id);
        $entreprise = Entreprise::find($employeDetails->id_entreprise);

        // Récupérer toutes les présences avec pagination
        $presences = Presence::where('id_employe', $employe->id)
            ->orderBy('date', 'desc')
            ->orderBy('heure_arrivee', 'desc')
            ->paginate(15);

        // Statistiques globales
        $statistiques = $this->getStatistiques($employe->id);

        // Statistiques par mois
        $statsParMois = Presence::where('id_employe', $employe->id)
            ->selectRaw('YEAR(date) as annee, MONTH(date) as mois, 
                         COUNT(*) as total, 
                         SUM(CASE WHEN statut = "present" THEN 1 ELSE 0 END) as presents,
                         SUM(CASE WHEN statut = "retard" THEN 1 ELSE 0 END) as retards')
            ->groupBy('annee', 'mois')
            ->orderBy('annee', 'desc')
            ->orderBy('mois', 'desc')
            ->get();

        return view('employe_liste_presences', compact(
            'employeDetails',
            'entreprise',
            'presences',
            'statistiques',
            'statsParMois'
        ));
    }

    private function getStatistiques($employeId)
    {
        $total = Presence::where('id_employe', $employeId)->count();
        $present = Presence::where('id_employe', $employeId)
            ->where('statut', 'present')
            ->count();
        $retard = Presence::where('id_employe', $employeId)
            ->where('statut', 'retard')
            ->count();
        $absent = Presence::where('id_employe', $employeId)
            ->where('statut', 'absent')
            ->count();

        // Présences du mois
        $moisActuel = Presence::where('id_employe', $employeId)
            ->whereMonth('date', now()->month)
            ->whereYear('date', now()->year)
            ->count();

        // Présences de la semaine
        $semaineActuelle = Presence::where('id_employe', $employeId)
            ->whereBetween('date', [now()->startOfWeek(), now()->endOfWeek()])
            ->count();

        // Taux de présence
        $tauxPresence = $total > 0 ? round(($present / $total) * 100, 2) : 0;

        // Moyenne d'heures par jour
        $heuresTotal = Presence::where('id_employe', $employeId)
            ->whereNotNull('heure_depart')
            ->get()
            ->sum(function($presence) {
                $arrivee = Carbon::parse($presence->heure_arrivee);
                $depart = Carbon::parse($presence->heure_depart);
                return $depart->diffInHours($arrivee);
            });

        $moyenneHeures = $total > 0 ? round($heuresTotal / $total, 1) : 0;

        return [
            'total' => $total,
            'present' => $present,
            'retard' => $retard,
            'absent' => $absent,
            'mois_actuel' => $moisActuel,
            'semaine_actuelle' => $semaineActuelle,
            'taux_presence' => $tauxPresence,
            'moyenne_heures' => $moyenneHeures,
        ];
    }

    private function extraireNavigateur($userAgent)
    {
        $browsers = [
            'Firefox' => 'Firefox',
            'Chrome' => 'Chrome',
            'Safari' => 'Safari',
            'Edge' => 'Edge',
            'Opera' => 'Opera',
            'MSIE' => 'Internet Explorer',
            'Trident' => 'Internet Explorer'
        ];

        foreach ($browsers as $key => $value) {
            if (str_contains($userAgent, $key)) {
                return $value;
            }
        }

        return 'Inconnu';
    }

    private function getAdresseFromCoordinates($latitude, $longitude)
    {
        if (!$latitude || !$longitude) {
            return null;
        }

        try {
            $response = Http::get('https://nominatim.openstreetmap.org/reverse', [
                'lat' => $latitude,
                'lon' => $longitude,
                'format' => 'json',
                'accept-language' => 'fr'
            ]);

            if ($response->successful()) {
                $data = $response->json();
                return $data['display_name'] ?? null;
            }
        } catch (\Exception $e) {
            Log::error('Erreur géocodage: ' . $e->getMessage());
        }

        return null;
    }


   public function calendrier(Request $request)
{
    $employe = Auth::guard('employe')->user();
    Auth::login($employe);

    $employeDetails = Employe::find($employe->id);
    $entreprise = Entreprise::find($employeDetails->id_entreprise);

    // Mois et année
    $mois = $request->mois ?? now()->month;
    $annee = $request->annee ?? now()->year;

    // Mois précédent et suivant
    $moisPrecedent = $mois == 1 ? 12 : $mois - 1;
    $anneePrecedent = $mois == 1 ? $annee - 1 : $annee;
    $moisSuivant = $mois == 12 ? 1 : $mois + 1;
    $anneeSuivant = $mois == 12 ? $annee + 1 : $annee;

    // Vérifier si l'employé a déjà pointé aujourd'hui
    $presenceAujourdhui = Presence::where('id_employe', $employe->id)
        ->whereDate('date', today())
        ->first();

    // Récupérer toutes les présences du mois
    $presences = Presence::where('id_employe', $employe->id)
        ->whereMonth('date', $mois)
        ->whereYear('date', $annee)
        ->get();

    // Indexer par date
    $presencesParJour = [];
    foreach ($presences as $presence) {
        $presencesParJour[$presence->date->format('Y-m-d')] = $presence;
    }

    // Statistiques du mois
    $statsMois = [
        'total' => $presences->count(),
        'present' => $presences->where('statut', 'present')->count(),
        'retard' => $presences->where('statut', 'retard')->count(),
        'absent' => $presences->where('statut', 'absent')->count(),
    ];

    return view('employe_pointage', compact(
        'employeDetails',
        'entreprise',
        'presencesParJour',
        'statsMois',
        'mois',
        'annee',
        'moisPrecedent',
        'anneePrecedent',
        'moisSuivant',
        'anneeSuivant',
        'presenceAujourdhui'
    ));
}
}
