<?php

namespace App\Http\Controllers;

use App\Mail\ResetPasswordMail;
use App\Models\Admin;
use App\Models\Comptes;
use App\Models\Employe;
use App\Models\Entreprise;
use App\Models\Produit;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Throwable;

class AdminController extends Controller
{
    public function login(Request $request){
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ]);
        if($validator->fails()){
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first()
            ],422);
        }

        try{
            $admin = Admin::where('email', $request->email)->first();
            if($admin && Hash::check($request->password, $admin->password)){
                $token = $admin->createToken('adminToken')->plainTextToken;
                return response()->json([
                    'success' => true,
                    'data' => [
                        'id' => $admin->id,
                        'nom' => $admin->nom,
                        'email' => $admin->email,
                        'telephone' => $admin->telephone,
                        'image' => $admin->image,
                        'role' => $admin->role,
                        'created_at' => $admin->created_at,
                        'updated_at' => $admin->updated_at,
                        'token' => $token
                    ],
                    'message' => 'Administrateur connecté avec succès'
                ],200);
            }
            return response()->json([
                'success' => false,
                'message' => 'Identifiants incorrect'
            ],400);
        }
        catch(QueryException $e){
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la connexion de l’admin',
                'erreur' => $e->getMessage()
            ],500);
        }
    }

    public function info_admin(Request $request){
        try{
            $user = $request->user();
            $admin = Admin::find($user->id);

            if(!$admin){
                return response()->json([
                    'success' => false,
                    'message' => 'Admin introuvable' 
                ],404);
            }

            return response()->json([
                'success' => true,
                'data' => [
                    'id' => $admin->id,
                    'nom' => $admin->nom,
                    'email' => $admin->email,
                    'telephone' => $admin->telephone,
                    'image' => $admin->image,
                    'role' => $admin->role,
                    'solde' => $admin->solde,
                    'created_at' => $admin->created_at,
                    'updated_at' => $admin->updated_at,
                ],
                'message' => 'Info de l’admin affichée avec succes'
            ],200);
        }
        catch(QueryException $e){
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de l’affichage des infos de l’admin',
                'erreur' => $e->getMessage()
            ],500);
        }
    }

    public function update_profil_admin(Request $request){
         $validator = Validator::make($request->all(), [
            'nom' => 'nullable',
            'email' => 'nullable|email',
            'telephone' => 'nullable|digits:10',
            'image' => 'nullable|image|mimes:jpg,jpeg,png'
        ]);

        if($validator->fails()){
            return response()->json([
               'success' => false,
               'message' => $validator->errors()->first() 
            ],422);
        }

        try{
            $user = $request->user();
            $admin = Admin::find($user->id);

            if(!$admin){
                return response()->json([
                    'success' => false,
                    'message' => 'Administrateur introuvable'
                ],404);
            }

            $image = $this->uploadImageToHosting($request->image);

            $admin->nom = $request->nom ?? $admin->nom;
            $admin->email = $request->email ?? $admin->email;
            $admin->telephone = $request->telephone ?? $admin->telephone;
            $admin->image = $image ?? $admin->image;
            $admin->save();

            return response()->json([
                'success' => true,
                'data' => $admin,
                'message' => 'Mise à jour du profil de l’admin réussi'
            ],200);
        }
        catch(Throwable $e){
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la mise à jour du profil admin',
                'erreur' => $e->getMessage()
            ],500);
        }
    }

    public function ajout_admin(Request $request){
        $validator = Validator::make($request->all(), [
            'nom' => 'required',
            'email' => 'required|email|unique:admins',
            'telephone' => 'required|digits:10'
        ]);

        if($validator->fails()){
            return response()->json([
               'success' => false,
               'message' => $validator->errors()->first() 
            ],422);
        }

        $user = $request->user();
        $admin = Admin::find($user->id);

        if(!$admin){
            return response()->json([
                'success' => false,
                'message' => 'Admin introuvable' 
            ],404);
        }

        if($admin->role != 1){
            return response()->json([
                'success' => false,
                'message' => 'Seul le super admin a la possibilité d’ajouter un sous admin.'
            ],403);
        }

        try{
            $admin = new Admin();
            $admin->nom = $request->nom;
            $admin->email = $request->email;
            $admin->telephone = $request->telephone;
            $admin->role = 2;
            $admin->password = Hash::make(substr($request->telephone, -4));
            $admin->save();

            return response()->json([
                'success' => true,
                'data' => [
                    'id' => $admin->id,
                    'nom' => $admin->nom,
                    'email' => $admin->email,
                    'telephone' => $admin->telephone,
                    'image' => $admin->image,
                    'role' => $admin->role,
                    'created_at' => $admin->created_at,
                    'updated_at' => $admin->updated_at,
                ],
                'message' => 'Admin ajouté avec succès'
            ],200);
        }
        catch(QueryException $e){
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de l’ajout du sous admin',
                'erreur' => $e->getMessage()
            ],500);
        }
    }

    public function admins(Request $request){
        try{
            $user = $request->user();
            $admin = Admin::find($user->id);
            if(!$admin){
                return response()->json([
                    'success' => false,
                    'message' => 'Administrateur introuvable',
                ],404);
            }

            if($admin->role != 1){
                return response()->json([
                    'success' => false,
                    'message' => 'Vous n’avez pas les accès requis pour lister les administrateurs'
                ],403);
            }

            $admins = Admin::where('role', 2)->get();
            $data = $admins->map(function($admin){
                return $admin;
            });

            return response()->json([
                'success' => true,
                'data' => $data,
                'message' => 'Administrateur affiché avec succès'
            ],200);

        }
        catch(Throwable $e){
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de l’affichage de la liste de sous admin',
                'erreur' => $e->getMessage()
            ],500);
        }
    }


    public function admin(Request $request, $id){
        try{
            $user = $request->user();
            $admin = Admin::find($user->id);
            if(!$admin){
                return response()->json([
                    'success' => false,
                    'message' => 'Administrateur introuvable',
                ],404);
            }

            if($admin->role != 1){
                return response()->json([
                    'success' => false,
                    'message' => 'Vous n’avez pas les accès requis pour lister les administrateurs'
                ],403);
            }

            $admins = Admin::find($id);
            if(!$admins){
                return response()->json([
                    'success' => false,
                    'message' => 'Sous administrateur introuvable',
                ],404);
            }

            return response()->json([
                'success' => true,
                'data' => $admins,
                'message' => 'Administrateur affiché avec succès'
            ],200);

        }
        catch(Throwable $e){
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de l’affichage du sous admin',
                'erreur' => $e->getMessage()
            ],500);
        }
    }

    public function delete_admin(Request $request, $id){
        try{
            $user = $request->user();
            $admin = Admin::find($user->id);
            if(!$admin){
                return response()->json([
                    'success' => false,
                    'message' => 'Administrateur introuvable',
                ],404);
            }

            if($admin->role != 1){
                return response()->json([
                    'success' => false,
                    'message' => 'Vous n’avez pas les accès requis pour lister les administrateurs'
                ],403);
            }

            $sous = Admin::find($id);
            if(!$sous){
                return response()->json([
                    'success' => false,
                    'message' => 'Sous admin introuvable'
                ],404);
            }

            $sous->delete();

            return response()->json([
                'success' => true,
                'message' => 'Sous admin supprimé avec succès'
            ],200);
        }
        catch(Throwable $e){
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la suppression de l’admin',
                'erreur' => $e->getMessage()
            ],500);
        }
    }

    public function change_password(Request $request){
        $validator = Validator::make($request->all(), [
            'ancien' => 'required',
            'nouveau' => 'required|confirmed',
        ]);

        if($validator->fails()){
            return response()->json([
               'success' => false,
               'message' => $validator->errors()->first() 
            ],422);
        }

        try{
            $user = $request->user();
            $admin = Admin::find($user->id);
            if(!$admin){
                return response()->json([
                    'success' => false,
                    'message' => 'Administrateur introuvable'
                ],404);
            }

            if(Hash::check($request->ancien, $admin->password)){
                $admin->password = Hash::make($request->nouveau);
                $admin->save();

                return response()->json([
                    'success' => true,
                    'message' => 'Mot de passe mis à jour avec succès'
                ],200);
            }

            return response()->json([
                'success' => false,
                'message' => 'Ancien mot de passe incorrect'
            ],400);
        }
        catch(Throwable $e){
            return response()->json([
                'success' => true,
                'message' => 'Erreur lors de la mise à jour du mot de passe',
                'erreur' => $e->getMessage()
            ],500);
        }
    }

    public function entreprises(Request $request){
        try{
            $entreprises = Entreprise::orderBy('created_at', 'asc')->get();
            if($entreprises->isEmpty()){
                return response()->json([
                    'success' => true,
                    'data' => [],
                    'message' => 'Aucune entreprise trouvée'
                ],200);
            }

            $data = $entreprises->map(function($entreprise){
                return $entreprise;
            });

            return response()->json([
                'success' => true,
                'data' => $data,
                'message' => 'Liste des entreprises affichées avec succès' 
            ]);
        }
        catch(Throwable $e){
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de l’affichage de la liste des entreprises',
                'erreur' => $e->getMessage()
            ],500);
        }
    }

    public function entreprise(Request $request, $id){
        try{
            $entreprise = Entreprise::find($id);
            if(!$entreprise){
                return response()->json([
                    'success' => false,
                    'message' => 'Entreprise introuvable' 
                ],404);
            }

            $employees = Employe::orderBy('created_at', 'desc')
                ->where('id_entreprise', $entreprise->id)
                ->get();
            $employes = $employees->map(function($employe){
                return $employe;
            });

            $produits = Produit::orderBy('created_at', 'desc')
                ->where('id_entreprise', $entreprise->id)
                ->get();
            $data = $produits->map(function($produit){
                return $produit;
            });

            return response()->json([
                'success' => true,
                'data' => [
                    "id" => $entreprise->id,
                    "nom_entreprise" => $entreprise->nom_entreprise,
                    "nom_directeur" => $entreprise->nom_directeur,
                    "prenom_directeur" => $entreprise->prenom_directeur,
                    "telephone_entreprise" => $entreprise->telephone_entreprise,
                    "email_entreprise" => $entreprise->email_entreprise,
                    "matricule_entreprise" => $entreprise->matricule_entreprise,
                    "role" => $entreprise->role,
                    "created_at" => $entreprise->created_at,
                    "updated_at" => $entreprise->updated_at,
                    'employes' => $employes ?? null,
                    'produits' => $data ?? null
                ],
                'message' => 'Affichage de l’entreprise'
            ],200);
        }
        catch(Throwable $e){
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de l’affichage de l’entreprise',
                'erreur' => $e->getMessage()
            ],500);
        }
    }

    public function solde_entreprise(Request $request){
        try{
            $solde = Comptes::sum('montant');
            return response()->json([
                'success' => true,
                'data' => $solde,
                'message' => 'Solde total des entreprises affiché avec succès'
            ],200);
        }
        catch(Throwable $e){
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de l’affichage du solde des entreprises',
                'erreur' => $e->getMessage()
            ],500);
        }
    }

    public function solde_admin(Request $request){
        try{
            $user = $request->user();
            $admin = Admin::find($user->id);
            if(!$admin){
                return response()->json([
                    'success' => false,
                    'message' => 'Administrateur introuvable'
                ],404);
            }
            if($admin->role != 1){
                return response()->json([
                    'success' => false,
                    'message' => 'Accès interdit pour les sous admin'
                ],403);
            }

            return response()->json([
                'success' => true,
                'data' => $admin->solde,
                'message' => 'Solde affiché avec succès'
            ],200);
        }
        catch(Throwable $e){
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de l’affichage du solde du super admin',
                'erreur' => $e->getMessage()
            ],500);
        }
    }

    public function delete_entreprise(Request $request, $id){
        try{
            $entreprise = Entreprise::find($id);

            if(!$entreprise){
                return response()->json([
                    'success' => false,
                    'message' => 'Entreprise introuvable'
                ],404);
            }

            $entreprise->delete();

            return response()->json([
                'success' => true,
                'message' => 'Entreprise supprimé avec succès'
            ],200);
        }
        catch(Throwable $e){
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la suppression de l’entreprise',
                'erreur' => $e->getMessage()
            ],500);
        }
    }

    public function renitialiser_mot_passe(Request $request, $id)
    {
        // 1️⃣ Vérifier que l'admin a fourni son mot de passe
        $validator = Validator::make($request->all(), [
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first()
            ], 422);
        }

        $admin = $request->user(); // L'admin connecté

        // 2️⃣ Vérifier le mot de passe de l'admin
        if (!Hash::check($request->password, $admin->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Mot de passe admin incorrect.'
            ], 403);
        }

        // 3️⃣ Chercher l'entreprise ou l'employé
        $user = Entreprise::find($id);
        $type = 'entreprise';

        if (!$user) {
            $user = Employe::find($id);
            $type = 'employe';
        }

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Utilisateur non trouvé.'
            ], 404);
        }

        // 4️⃣ Générer un mot de passe aléatoire
        $newPassword = Str::random(10);

        // 5️⃣ Mettre à jour le mot de passe selon le type
        if ($type === 'entreprise') {
            $user->motDePasse_entreprise = Hash::make($newPassword);
        } else {
            $user->mot_de_passe = Hash::make($newPassword);
        }
        $user->save();

        // 6️⃣ Préparer le nom pour le mail
        $name = $type === 'entreprise' ? $user->nom_entreprise : $user->nom_employe;

        // 7️⃣ Envoyer le mail
        $email = $type === 'entreprise' ? $user->email_entreprise : $user->email_employe;

        // Vérifier que l'email existe
        if (empty($email)) {
            return response()->json([
                'success' => false,
                'message' => 'Cet utilisateur n’a pas d’adresse e-mail.'
            ], 422);
        }

        // Envoyer le mail
        try {
            Mail::to($email)
                ->send(new ResetPasswordMail($name ?? 'Utilisateur', $newPassword));
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de l’envoi du mail : ' . $e->getMessage(),
            ], 500);
        }

        // 8️⃣ Retourner la réponse
        return response()->json([
            'success' => true,
            'message' => 'Mot de passe réinitialisé et envoyé par mail.'
        ]);
    }


    private function uploadImageToHosting($image){
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
