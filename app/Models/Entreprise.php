<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Entreprise extends Authenticatable
{
    use Notifiable, HasFactory;

    /**
     * Liste des champs modifiables en masse
     */
    protected $fillable = [
        'nom_entreprise',
        'nom_directeur',
        'prenom_entreprise',
        'email_entreprise',
        'motDePasse_entreprise',
        'matricule_entreprise',
        'role',
    ];



    /**
     * Renomme le champ du mot de passe pour l'authentification.
     *
     * @return string
     */
    public function getAuthPassword()
    {
        return $this->motDePasse_entreprise;
    }

    /**
     * Événement déclenché avant la création d'une entreprise.
     */
    protected static function booted()
    {
        static::creating(function ($entreprise) {
            // Générer automatiquement le matricule
            $entreprise->matricule_entreprise = self::generateMatricule();
        });
    }

    /**
     * Génère un matricule unique dans le format ENT-000A.
     *
     * @return string
     */
    private static function generateMatricule()
    {
        // Récupérer le dernier matricule pour créer un matricule unique
        $lastMatricule = self::latest()->first();
        $lastNumber = 0;

        if ($lastMatricule) {
            // Extrait les 3 chiffres du matricule
            $lastNumber = (int) substr($lastMatricule->matricule_entreprise, 4, 3);
        }

        // Incrémenter le numéro pour le prochain matricule
        $newNumber = str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);

        // Générer la lettre du matricule (A pour 0, B pour 1, etc.)
        $letter = chr(65 + ($lastNumber % 26));

        // Retourner le matricule complet dans le format ENT-000A
        return 'ENT-' . $newNumber . $letter;
    }

    
}