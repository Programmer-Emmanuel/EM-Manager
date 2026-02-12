<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class Employe extends Authenticatable
{
    use Notifiable, HasFactory;

    /**
     * Liste des champs modifiables en masse.
     */
    protected $fillable = [
        'nom_employe',
        'prenom_employe',
        'adresse_employe',
        'telephone',
        'email_employe',
        'matricule_employe',
        'poste',
        'departement',
        'date_embauche',
        'salaire',
        'mot_de_passe',
        'role',
    ];

    protected $casts = [
        'date_embauche' => 'datetime',
    ];


    /**
     * Renomme le champ du mot de passe pour l'authentification.
     *
     * @return string
     */
    public function getAuthPassword()
    {
        return $this->mot_de_passe;
    }

    /**
     * Événement déclenché avant la création d'un employé.
     */
    protected static function booted()
    {
        static::creating(function ($employe) {
            // Générer automatiquement le matricule
            $employe->matricule_employe = self::generateMatricule();

            // Définir le mot de passe comme un hash du matricule généré
            $employe->mot_de_passe = Hash::make($employe->matricule_employe);
        });
    }

    /**
     * Génère un matricule unique dans le format EMP-000A.
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
            $lastNumber = (int) substr($lastMatricule->matricule_employe, 4, 3);
        }

        // Incrémenter le numéro pour le prochain matricule
        $newNumber = str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);

        // Générer la lettre du matricule (A pour 0, B pour 1, etc.)
        $letter = chr(65 + (($lastNumber) % 26));

        // Retourner le matricule complet dans le format EMP-000A
        return 'EMP-' . $newNumber . $letter;
    }

    public $incrementing = false; // empêche l'auto-incrémentation
    protected $keyType = 'string'; // la clé primaire sera une string

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (!$model->getKey()) {
                $model->{$model->getKeyName()} = (string) Str::uuid();
            }
        });
    }
    
}
