<?php

namespace App\Exports;

use App\Models\Employe;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class EmployesExport implements FromCollection, WithHeadings, WithMapping
{
    /**
     * Retourne la collection des employés à exporter pour l'entreprise de l'utilisateur connecté.
     *
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $entreprise = Auth::user();

        return Employe::where('id_entreprise', '=', $entreprise->id)
            ->select(
                'nom_employe',
                'prenom_employe',
                'matricule_employe',
                'email_employe',
                'telephone',
                'poste',
                'departement',
                'date_embauche',
                'salaire'
            )->get();
    }

    /**
     * Définit les en-têtes des colonnes pour le fichier Excel.
     *
     * @return array
     */
    public function headings(): array
    {
        return [
            'Nom complet',
            'Matricule',
            'Email',
            'Téléphone',
            'Poste',
            'Département',
            'Date d\'embauche',
            'Salaire(FCFA)',
        ];
    }

    /**
     * Mappe les données pour chaque ligne du fichier Excel.
     *
     * @param mixed $employe
     * @return array
     */
    public function map($employe): array
    {
        return [
            "{$employe->nom_employe} {$employe->prenom_employe}",
            $employe->matricule_employe,
            $employe->email_employe,
            $employe->telephone,
            $employe->poste,
            $employe->departement,
            $employe->date_embauche,
            number_format($employe->salaire, 0, ',', ' ') . ' F',
        ];
    }
}
