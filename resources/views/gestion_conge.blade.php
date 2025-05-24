@extends('dashboard_base')

@section('main')
<main class="flex-1 bg-slate-900 text-white overflow-hidden relative">
    <div class="absolute inset-0 overflow-y-auto hide-scroll p-6">
        <!-- En-tête -->
        <div class="mb-8">
            <h1 class="text-2xl font-bold text-white mb-2">Gestion des Congés</h1>
            <p class="text-slate-400 italic">Gérez et traitez les demandes de congé de vos employés.</p>
        </div>

        <!-- Liste des demandes -->
        <section class="bg-slate-800/50 backdrop-blur-sm rounded-xl border border-slate-700/50 shadow-xl overflow-hidden">
            <div class="p-6">
                <h2 class="text-xl font-semibold text-white mb-6 flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    Demandes en attente
                </h2>

                @if($conges->isEmpty())
                    <div class="text-center py-8">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                        <p class="mt-2 text-slate-400 italic">Aucune demande de congé à traiter</p>
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-slate-700/50">
                            <thead class="bg-slate-700/30">
                                <tr>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-slate-300 uppercase tracking-wider">Employé</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-slate-300 uppercase tracking-wider">Type</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-slate-300 uppercase tracking-wider">Période</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-slate-300 uppercase tracking-wider">Durée</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-slate-300 uppercase tracking-wider">Statut</th>
                                    <th class="px-4 py-3 text-right text-xs font-medium text-slate-300 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-700/50">
                                @foreach($conges as $conge)
                                <tr class="hover:bg-slate-800/30 transition-colors duration-150">
                                    <td class="px-4 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10 bg-slate-700 rounded-full flex items-center justify-center">
                                                <span class="text-slate-300">{{ substr($conge->prenom_employe, 0, 1) }}{{ substr($conge->nom_employe, 0, 1) }}</span>
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-white">{{ $conge->prenom_employe }} {{ $conge->nom_employe }}</div>
                                                <div class="text-xs text-slate-400">{{ $conge->matricule_employe }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap">
                                        <div class="text-sm text-slate-200">{{ $conge->type_conge }}</div>
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap">
                                        <div class="text-sm text-slate-200">{{ $conge->date_debut }}</div>
                                        <div class="text-xs text-slate-400">au {{ $conge->date_fin }}</div>
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap">
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-slate-700/50 text-slate-200">
                                            {{ $conge->duree }} jour(s)
                                        </span>
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap">
                                        @if($conge->statut == 'Approuvé')
                                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-900/30 text-green-400">
                                                Approuvé
                                            </span>
                                        @elseif($conge->statut == 'Rejeté')
                                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-900/30 text-red-400">
                                                Rejeté
                                            </span>
                                        @else
                                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-900/30 text-yellow-400">
                                                En attente
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        @if($conge->statut == 'En attente...')
                                        <div class="flex justify-end space-x-2">
                                            <form action="{{ route('conge_approuver', $conge->id) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="text-green-400 hover:text-green-300 flex items-center gap-1 transition-colors">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                    </svg>
                                                    Approuver
                                                </button>
                                            </form>
                                            <span class="text-slate-600">|</span>
                                            <form action="{{ route('conge_rejeter', $conge->id) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="text-red-400 hover:text-red-300 flex items-center gap-1 transition-colors">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                    </svg>
                                                    Rejeter
                                                </button>
                                            </form>
                                        </div>
                                        @else
                                        <span class="text-slate-500 italic text-xs">Traité</span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </section>
    </div>

    <!-- Effets décoratifs -->
    <div class="fixed -bottom-32 -left-32 w-64 h-64 bg-indigo-500 rounded-full mix-blend-multiply filter blur-3xl opacity-5"></div>
    <div class="fixed -top-32 -right-32 w-64 h-64 bg-purple-500 rounded-full mix-blend-multiply filter blur-3xl opacity-5"></div>
</main>
@endsection