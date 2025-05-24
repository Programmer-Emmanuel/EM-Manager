@extends('employe_dashboard_base')

@section('main')
<main class="flex-1 bg-slate-900 text-white overflow-hidden relative">
    <div class="absolute inset-0 overflow-y-auto hide-scroll p-6">
        <!-- En-tête -->
        <div class="mb-8">
            <h1 class="text-2xl font-bold text-white mb-2 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                Mes Demandes de Congé
            </h1>
            <p class="text-slate-400 italic">Consultez l'état de vos demandes et soumettez-en de nouvelles.</p>
        </div>

        <!-- Bouton d'action -->
        <div class="mb-8">
            <a href="{{route('demande_conge')}}" 
                class="inline-flex items-center gap-2 bg-gradient-to-r from-indigo-600 to-indigo-700 hover:from-indigo-700 hover:to-indigo-800 text-white px-6 py-3 rounded-lg shadow transition-all duration-200">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Nouvelle demande
            </a>
        </div>

        <!-- Liste des demandes -->
        <div class="bg-slate-800/50 backdrop-blur-sm rounded-xl border border-slate-700/50 shadow-xl overflow-hidden">
            <div class="p-6">
                <h2 class="text-xl font-semibold text-white mb-6">Historique des demandes</h2>
                
                @if($conges->isEmpty())
                    <div class="text-center py-8">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                        <p class="mt-2 text-slate-400 italic">Aucune demande de congé trouvée</p>
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-slate-700/50">
                            <thead class="bg-slate-700/30">
                                <tr>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-slate-300 uppercase tracking-wider">Type</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-slate-300 uppercase tracking-wider">Date début</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-slate-300 uppercase tracking-wider">Date fin</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-slate-300 uppercase tracking-wider">Statut</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-700/50">
                                @foreach($conges as $conge)
                                <tr class="hover:bg-slate-800/30 transition-colors duration-150">
                                    <td class="px-4 py-4 whitespace-nowrap text-sm text-slate-200">
                                        {{ $conge->type_conge }}
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap text-sm text-slate-200">
                                        {{ $conge->date_debut }}
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap text-sm text-slate-200">
                                        {{ $conge->date_fin }}
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
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Effets décoratifs -->
    <div class="fixed -bottom-32 -left-32 w-64 h-64 bg-indigo-500 rounded-full mix-blend-multiply filter blur-3xl opacity-5"></div>
    <div class="fixed -top-32 -right-32 w-64 h-64 bg-purple-500 rounded-full mix-blend-multiply filter blur-3xl opacity-5"></div>
</main>
@endsection