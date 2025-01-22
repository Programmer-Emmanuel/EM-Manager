@extends('employe_dashboard_base')

@section('main')
<main class="flex-1 p-8 bg-slate-900 text-white shadow-md overflow-hidden relative">
<div class="absolute inset-0 overflow-y-auto hide-scroll px-5 py-16 mt-4 ">
        <!-- Badge décoratif -->
        <div class="absolute -top-6 left-1/2 transform -translate-x-1/2 mt-7">
            <div class="bg-slate-500 p-2 rounded-full shadow-md">
                <svg class="w-8 h-8 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87M12 11a4 4 0 100-8 4 4 0 000 8zm0 2c4.28 0 8 2.03 8 5v1H4v-1c0-2.97 3.72-5 8-5z" />
                </svg>
            </div>
        </div>

        <!-- Titre -->
        <div class="text-center text-xl font-extrabold text-white mb-4">
            <u>COMPTE EMPLOYÉ</u>
        </div>

        <!-- Contenu -->
        <div class="space-y-3">
            <!-- Section dynamique -->
            @foreach([
                ['label' => 'Nom', 'value' => $employeDetails->nom_employe],
                ['label' => 'Prénoms', 'value' => $employeDetails->prenom_employe],
                ['label' => 'Email', 'value' => $employeDetails->email_employe],
                ['label' => 'Téléphone', 'value' => $employeDetails->telephone],
                ['label' => 'Matricule', 'value' => $employeDetails->matricule_employe],
                ['label' => 'Département', 'value' => $employeDetails->departement],
                ['label' => 'Poste', 'value' => $employeDetails->poste],
                ['label' => 'Salaire', 'value' => number_format($employeDetails->salaire, 0, ',', ' ') . ' FCFA'],
                ['label' => 'Adresse', 'value' => $employeDetails->adresse_employe],
                ['label' => 'Date d\'embauche', 'value' => $employeDetails->date_embauche],
                ['label' => 'Entreprise', 'value' => $entreprise->nom_entreprise],
                ['label' => 'Directeur', 'value' => $entreprise->nom_directeur . ' ' . $entreprise->prenom_directeur],
                ['label' => 'Numero entreprise', 'value' => $entreprise->telephone_entreprise],
            ] as $item)
                <div class="flex justify-between items-center border-b border-slate-700 pb-2">
                    <div class="font-bold text-sm font-large text-white">{{ $item['label'] }} :</div>
                    <div class="text-sm text-gray-200 font-semibold italic">{{ $item['value'] }}</div>
                </div>
            @endforeach
        </div>
    </div>
</main>
@endsection
