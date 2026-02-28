<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Transactions extends Model
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
        'entreprise_id',
        'motif',
        'type',
        'montant',
        'employe_id'
    ];

    public function entreprise(){
        return $this->belongsTo(Entreprise::class, 'entreprise_id');
    }

    public function employe(){
        return $this->belongsTo(Employe::class, 'employe_id');
    }
}
