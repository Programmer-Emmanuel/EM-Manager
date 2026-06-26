<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Presence extends Model
{
    use HasFactory;

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


    protected $fillable = [
        'id_employe',
        'id_entreprise',
        'date',
        'heure_arrivee',
        'heure_depart',
        'adresse_pointage',
        'latitude',
        'longitude',
        'adresse_ip',
        'navigateur',
        'statut'
    ];

    protected $casts = [
        'date' => 'date',
        'heure_arrivee' => 'datetime:H:i:s',
        'heure_depart' => 'datetime:H:i:s',
    ];

    public function employe()
    {
        return $this->belongsTo(Employe::class, 'id_employe');
    }

    public function entreprise()
    {
        return $this->belongsTo(Entreprise::class, 'id_entreprise');
    }

    public function scopeAujourdhui($query)
    {
        return $query->whereDate('date', today());
    }

    public function scopePourEmploye($query, $employeId)
    {
        return $query->where('id_employe', $employeId);
    }

    public function scopePourEntreprise($query, $entrepriseId)
    {
        return $query->where('id_entreprise', $entrepriseId);
    }

     public function estEnRetard($heureLimite = '09:00:00')
    {
        return $this->heure_arrivee > $heureLimite;
    }

    public function getDureeAttribute()
    {
        if ($this->heure_depart) {
            $arrivee = \Carbon\Carbon::parse($this->heure_arrivee);
            $depart = \Carbon\Carbon::parse($this->heure_depart);
            return $depart->diffInHours($arrivee);
        }
        return null;
    }

    public function marquerDepart()
    {
        $this->update([
            'heure_depart' => now()->format('H:i:s')
        ]);
    }


     public static function extraireNavigateur($userAgent)
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
}
