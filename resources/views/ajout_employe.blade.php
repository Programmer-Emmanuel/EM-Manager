@extends('dashboard_base')

@section('main')
<main class="flex-1 bg-slate-900 text-white overflow-hidden relative">
    <div class="absolute inset-0 overflow-y-auto hide-scroll p-6">
        <!-- En-tête -->
        <div class="mb-8">
            <h1 class="text-2xl font-bold text-white mb-2 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                </svg>
                Ajouter un Employé
            </h1>
            <p class="text-slate-400">Remplissez le formulaire pour ajouter un nouvel employé à votre équipe.</p>
        </div>

        <!-- Messages d'erreur -->
        @if ($errors->any())
        <div class="mb-6 p-4 bg-red-900/30 border border-red-800/50 rounded-lg">
            <div class="flex items-start gap-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-400 mt-0.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <div>
                    <h3 class="font-medium text-red-300">Veuillez corriger les erreurs suivantes :</h3>
                    <ul class="mt-1 text-sm text-red-200 space-y-1">
                        @foreach ($errors->all() as $error)
                            <li class="flex items-start gap-2">
                                <span class="text-red-400">•</span>
                                <span>{{ $error }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        @endif

        <!-- Formulaire -->
        <div class="bg-slate-800/50 backdrop-blur-sm rounded-xl border border-slate-700/50 shadow-xl overflow-hidden">
            <form action="{{ route('store_employe') }}" method="POST" class="p-6 space-y-6">
                @csrf

                <!-- Nom et prénom -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="nom_employe" class="block text-sm font-medium text-slate-300 mb-2">Nom</label>
                        <input type="text" name="nom_employe" id="nom_employe" value="{{ old('nom_employe') }}" required
                            class="w-full p-3 bg-slate-700/30 text-white rounded-lg border border-slate-700/50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                    </div>
                    <div>
                        <label for="prenom_employe" class="block text-sm font-medium text-slate-300 mb-2">Prénom</label>
                        <input type="text" name="prenom_employe" id="prenom_employe" value="{{ old('prenom_employe') }}" required
                            class="w-full p-3 bg-slate-700/30 text-white rounded-lg border border-slate-700/50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                    </div>
                </div>

                <!-- Adresse et téléphone -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="adresse_employe" class="block text-sm font-medium text-slate-300 mb-2">Adresse</label>
                        <input type="text" name="adresse_employe" id="adresse_employe" value="{{ old('adresse_employe') }}" required
                            class="w-full p-3 bg-slate-700/30 text-white rounded-lg border border-slate-700/50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                    </div>
                    <div>
                        <label for="telephone" class="block text-sm font-medium text-slate-300 mb-2">Téléphone</label>
                        <input type="tel" name="telephone" id="telephone" value="{{ old('telephone') }}" required
                            class="w-full p-3 bg-slate-700/30 text-white rounded-lg border border-slate-700/50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                    </div>
                </div>

                <!-- Email -->
                <div>
                    <label for="email_employe" class="block text-sm font-medium text-slate-300 mb-2">Email</label>
                    <input type="email" name="email_employe" id="email_employe" value="{{ old('email_employe') }}" required
                        class="w-full p-3 bg-slate-700/30 text-white rounded-lg border border-slate-700/50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                </div>

                <!-- Poste et département -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="poste" class="block text-sm font-medium text-slate-300 mb-2">Poste</label>
                        <input type="text" name="poste" id="poste" value="{{ old('poste') }}" required
                            class="w-full p-3 bg-slate-700/30 text-white rounded-lg border border-slate-700/50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                    </div>
                    <div>
                        <label for="departement" class="block text-sm font-medium text-slate-300 mb-2">Département</label>
                        <input type="text" name="departement" id="departement" value="{{ old('departement') }}" required
                            class="w-full p-3 bg-slate-700/30 text-white rounded-lg border border-slate-700/50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                    </div>
                </div>

                <!-- Salaire -->
                <div>
                    <label for="salaire" class="block text-sm font-medium text-slate-300 mb-2">Salaire (FCFA)</label>
                    <input type="number" name="salaire" id="salaire" value="{{ old('salaire') }}" required
                        class="w-full p-3 bg-slate-700/30 text-white rounded-lg border border-slate-700/50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none">
                </div>

                <!-- Bouton de soumission -->
                <div class="pt-4">
                    <button type="submit"
                        class="w-full py-3 px-4 bg-gradient-to-r from-slate-600 to-slate-700 text-white font-medium rounded-lg border border-slate-700 hover:from-slate-700 hover:to-slate-800 focus:outline-none focus:ring-2 focus:ring-slate-500 focus:ring-offset-2 focus:ring-offset-slate-800 transition-all duration-200 flex items-center justify-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        Ajouter l'employé
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Effets décoratifs -->
    <div class="fixed -bottom-32 -left-32 w-64 h-64 bg-indigo-500 rounded-full mix-blend-multiply filter blur-3xl opacity-5"></div>
    <div class="fixed -top-32 -right-32 w-64 h-64 bg-purple-500 rounded-full mix-blend-multiply filter blur-3xl opacity-5"></div>
</main>
@endsection