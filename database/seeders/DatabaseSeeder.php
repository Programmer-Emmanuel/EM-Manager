<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\Admin;
use App\Models\Entreprise;
use App\Models\Employe;
use App\Models\Comptes;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        /**
         * ================================
         * SUPER ADMIN
         * ================================
         */
        $admin = new Admin();
        $admin->id = Str::uuid();
        $admin->nom = "Administrateur EM-Manager";
        $admin->email = "emmanuelbamidele183@gmail.com";
        $admin->telephone = "0140022693";
        $admin->password = Hash::make("admin123-123");
        $admin->role = 1;
        $admin->save();

        $this->command->info("✔ Super Admin créé");


        /**
         * ================================
         * ENTREPRISE (comme postRegister)
         * ================================
         */
        $entreprise = new Entreprise();
        $entreprise->id = Str::uuid();
        $entreprise->nom_entreprise = "EM-TECH CI";
        $entreprise->nom_directeur = "Bamidele";
        $entreprise->prenom_directeur = "Emmanuel";
        $entreprise->telephone_entreprise = "+2250700000001";
        $entreprise->email_entreprise = "contact@emtech.ci";
        $entreprise->motDePasse_entreprise = Hash::make("entreprise123");
        $entreprise->save();

        $this->command->info("✔ Entreprise créée");


        /**
         * ================================
         * COMPTE ENTREPRISE (comme postRegister)
         * ================================
         */
        $compte = new Comptes();
        $compte->id = Str::uuid();
        $compte->entreprise_id = $entreprise->id;
        $compte->montant = 0;
        $compte->save();

        $this->command->info("✔ Compte entreprise créé");


        /**
         * ================================
         * 10 EMPLOYÉS (comme store_employe)
         * ================================
         */
        $postes = [
            "Développeur Backend",
            "Développeur Frontend",
            "Comptable",
            "RH",
            "Commercial",
            "Designer UI/UX",
            "Manager",
            "Technicien Réseau",
            "Assistant Admin",
            "Responsable Marketing"
        ];

        $salaires = [
            250000,
            300000,
            220000,
            200000,
            180000,
            270000,
            500000,
            230000,
            150000,
            350000
        ];

        for ($i = 0; $i < 10; $i++) {

            $employe = new Employe();
            $employe->id = Str::uuid();
            $employe->id_entreprise = $entreprise->id;
            $employe->nom_employe = "Nom".$i+1;
            $employe->prenom_employe = "Prenom".$i+1;
            $employe->adresse_employe = "Abidjan Cocody Riviera ".($i+1);
            $employe->telephone = "+225070000000".($i+1);
            $employe->email_employe = "employe".($i+1)."@emtech.ci";
            $employe->poste = $postes[$i];
            $employe->departement = "Département ".rand(1,3);
            $employe->date_embauche = now()->toDateString();
            $employe->salaire = $salaires[$i];
            $employe->mot_de_passe = Hash::make("employe123");
            $employe->save();
        }

        $this->command->info("✔ 10 employés créés avec salaires différents");
    }
}