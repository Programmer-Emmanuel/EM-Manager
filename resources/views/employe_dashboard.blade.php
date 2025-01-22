@extends('employe_dashboard_base')

@section('main')
<main class="flex-1 p-8 bg-slate-900 text-white shadow-md overflow-hidden relative">
<div class="absolute inset-0 overflow-y-auto hide-scroll p-5 ">
    <!-- Titre principal -->
    <header class="mb-10">
        <h1 class="text-2xl font-bold text-white">Bienvenue, {{ $employeDetails->prenom_employe }} {{ $employeDetails->nom_employe }} !<br><span class="text-red-200 text-lg">(Votre Matricule est indispensable pour vous connectez plus tard)*</span></h1>
        <p class="text-gray-400 mt-2 italic">Ici, vous pouvez accéder à toutes les informations et outils liés à votre travail.</p>
    </header>

    <!-- Cartes récapitulatives -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        <!-- Carte : Mes informations -->
        <a href="{{route('employe_compte')}}" class="flex items-center p-4 bg-slate-800 rounded-lg shadow hover:bg-slate-700">
            <div class="text-slate-400">
                <i class="fas fa-user-circle text-3xl"></i>
            </div>
            <div class="ml-4">
                <h2 class="text-lg font-semibold text-white">Mon compte</h2>
                <p class="text-gray-300 text-sm">Voir vos informations personnelles.</p>
            </div>
        </a>

        <!-- Carte : Congés -->
        <a href="{{ route('employe_conge') }}" class="flex items-center p-4 bg-slate-800 rounded-lg shadow hover:bg-slate-700">
            <div class="text-slate-400">
                <i class="fas fa-calendar-alt text-3xl"></i>
            </div>
            <div class="ml-4">
                <h2 class="text-lg font-semibold text-white">Demande de congés</h2>
                <p class="text-gray-300 text-sm">Faire une nouvelle demande.</p>
            </div>
        </a>

        <!-- Historique des paies -->
        <a href="#" class="flex items-center p-4 bg-slate-800 rounded-lg shadow hover:bg-slate-700">
            <div class="text-slate-400">
                <i class="fas fa-credit-card text-3xl"></i>
            </div>
            <div class="ml-4">
                <h2 class="text-lg font-semibold text-white">Historique des paies</h2>
                <p class="text-gray-300 text-sm">Voir les informations sur mon salaire</p>
            </div>
        </a>
    </div>

    <!-- Section supplémentaire : Messages et notifications -->
    <section class="mt-8">
        <h2 class="text-2xl font-bold text-white mb-4">Nouveauté</h2>
        <div class="p-4 bg-slate-800 rounded-lg shadow">
            <p class="text-gray-400">Aucune nouveauté dans l’entreprise pour le moment.</p>
        </div>
    </section>
</div>
</main>
@endsection
