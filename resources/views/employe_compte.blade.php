@extends('employe_dashboard_base')

@section('main')

<style>
    .hide-scroll {
        scrollbar-width: none;         /* Firefox */
        -ms-overflow-style: none;      /* IE 10+ */
        overflow-y: scroll;            /* assure le scroll même s'il n'y a pas besoin */
    }

    .hide-scroll::-webkit-scrollbar {
        display: none;                 /* Chrome, Safari, Edge */
    }

    /* Animation d'apparition */
    [data-aos="fade-in"] {
        opacity: 0;
        transition: opacity 0.6s ease-out, transform 0.6s ease-out;
        transform: translateY(20px);
    }

    [data-aos="fade-in"].aos-animate {
        opacity: 1;
        transform: translateY(0);
    }

    /* Style décoratif pour les icônes */
    .fa-id-card, .fa-briefcase, .fa-building {
        -webkit-text-stroke: 1px currentColor;
        -webkit-text-fill-color: transparent;
    }
</style>

<main class="flex-1 p-6 bg-slate-900 text-white overflow-hidden relative">
    <div class="absolute inset-0 overflow-y-auto hide-scroll px-4 py-6">
        <div class="w-full max-w-3xl mx-auto my-8">
            <!-- Carte de profil -->
            <div class="bg-slate-800/50 backdrop-blur-sm rounded-xl border border-slate-700/50 shadow-xl overflow-hidden" data-aos="fade-in">
                <!-- En-tête avec badge -->
                <br><br>
                <div class="relative bg-gradient-to-r from-slate-700/50 to-slate-800/50 p-6 border-b border-slate-700/50">
                    <div class="absolute -top-8 left-1/2 transform -translate-x-1/2">
                        <div class="bg-slate-700 p-3 rounded-full shadow-lg border-2 border-slate-600">
                            <svg class="w-8 h-8 text-indigo-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                    </div>
                    <h1 class="text-center text-2xl font-bold text-white mt-4">Profil Employé</h1>
                    <p class="text-center text-slate-400 text-sm">{{ $entreprise->nom_entreprise }}</p>
                </div>

                <!-- Contenu du profil -->
                <div class="p-6 space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Colonne gauche -->
                        <div class="space-y-4">
                            <div class="bg-slate-700/30 p-4 rounded-lg border border-slate-700/50">
                                <h2 class="font-semibold text-indigo-300 mb-3 flex items-center">
                                    <i class="fas fa-id-card mr-2"></i> Informations personnelles
                                </h2>
                                <div class="space-y-3">
                                    @foreach([
                                        ['icon' => 'user', 'label' => 'Nom', 'value' => $employeDetails->nom_employe],
                                        ['icon' => 'user-tag', 'label' => 'Prénoms', 'value' => $employeDetails->prenom_employe],
                                        ['icon' => 'envelope', 'label' => 'Email', 'value' => $employeDetails->email_employe],
                                        ['icon' => 'phone', 'label' => 'Téléphone', 'value' => $employeDetails->telephone],
                                        ['icon' => 'home', 'label' => 'Adresse', 'value' => $employeDetails->adresse_employe],
                                    ] as $item)
                                        <div class="flex items-start">
                                            <div class="text-slate-400 mr-3 mt-1">
                                                <i class="fas fa-{{ $item['icon'] }}"></i>
                                            </div>
                                            <div class="flex-1">
                                                <div class="text-sm text-slate-400">{{ $item['label'] }}</div>
                                                <div class="text-white font-medium">{{ $item['value'] }}</div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <!-- Colonne droite -->
                        <div class="space-y-4">
                            <div class="bg-slate-700/30 p-4 rounded-lg border border-slate-700/50">
                                <h2 class="font-semibold text-indigo-300 mb-3 flex items-center">
                                    <i class="fas fa-briefcase mr-2"></i> Informations professionnelles
                                </h2>
                                <div class="space-y-3">
                                    @foreach([
                                        ['icon' => 'id-badge', 'label' => 'Matricule', 'value' => $employeDetails->matricule_employe],
                                        ['icon' => 'building', 'label' => 'Département', 'value' => $employeDetails->departement],
                                        ['icon' => 'user-tie', 'label' => 'Poste', 'value' => $employeDetails->poste],
                                        ['icon' => 'money-bill-wave', 'label' => 'Salaire', 'value' => number_format($employeDetails->salaire, 0, ',', ' ') . ' FCFA'],
                                        ['icon' => 'calendar-alt', 'label' => 'Date d\'embauche', 'value' => $employeDetails->date_embauche],
                                    ] as $item)
                                        <div class="flex items-start">
                                            <div class="text-slate-400 mr-3 mt-1">
                                                <i class="fas fa-{{ $item['icon'] }}"></i>
                                            </div>
                                            <div class="flex-1">
                                                <div class="text-sm text-slate-400">{{ $item['label'] }}</div>
                                                <div class="text-white font-medium">{{ $item['value'] }}</div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Section entreprise -->
                    <div class="bg-slate-700/30 p-4 rounded-lg border border-slate-700/50">
                        <h2 class="font-semibold text-indigo-300 mb-3 flex items-center">
                            <i class="fas fa-building mr-2"></i> Entreprise
                        </h2>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <div class="text-sm text-slate-400">Nom</div>
                                <div class="text-white font-medium">{{ $entreprise->nom_entreprise }}</div>
                            </div>
                            <div>
                                <div class="text-sm text-slate-400">Directeur</div>
                                <div class="text-white font-medium">{{ $entreprise->nom_directeur }} {{ $entreprise->prenom_directeur }}</div>
                            </div>
                            <div>
                                <div class="text-sm text-slate-400">Contact</div>
                                <div class="text-white font-medium">{{ $entreprise->telephone_entreprise }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pied de carte -->
                <div class="bg-slate-800/50 p-4 border-t border-slate-700/50 text-center">
                    <p class="text-xs text-slate-400">
                        Dernière mise à jour : {{ now()->format('d/m/Y H:i') }}
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Effets décoratifs -->
    <div class="fixed -bottom-32 -left-32 w-64 h-64 bg-indigo-500 rounded-full mix-blend-multiply filter blur-3xl opacity-5"></div>
    <div class="fixed -top-32 -right-32 w-64 h-64 bg-purple-500 rounded-full mix-blend-multiply filter blur-3xl opacity-5"></div>
</main>
@endsection
