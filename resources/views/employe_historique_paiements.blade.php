@extends('employe_dashboard_base')

@section('main')
<main class="flex-1 overflow-hidden relative bg-slate-900">
    <div class="absolute inset-0 overflow-y-auto hide-scrollbar p-4">
        <div class="min-h-screen flex items-start justify-center px-4 py-8">
            <div class="max-w-7xl w-full space-y-8">
                
                <!-- En-tête avec titre et bouton retour -->
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div class="flex items-center gap-4">
                        <div class="p-3  rounded-2xl shadow-lg">
                            <i class="fas fa-history text-white text-2xl"></i>
                        </div>
                        <div>
                            <h1 class="text-2xl md:text-3xl font-bold text-white">
                                Historique des paiements
                            </h1>
                            <p class="text-slate-400 mt-1">
                                Consultez tous vos paiements de salaire
                            </p>
                        </div>
                    </div>
                    <a href="{{ route('employe_dashboard') }}" 
                       class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-slate-800 hover:bg-slate-700 
                              text-white rounded-xl border border-slate-700 transition-all duration-200
                              hover:shadow-lg hover:shadow-blue-900/20 group">
                        <i class="fas fa-arrow-left text-slate-400 group-hover:text-white transition-colors"></i>
                        <span>Retour au tableau de bord</span>
                    </a>
                </div>

                <!-- Cartes de statistiques -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6">
                    <!-- Total des paiements -->
                    <div class="bg-gradient-to-br from-slate-800 to-slate-900 rounded-2xl p-6 border border-slate-700 
                                hover:border-blue-500/50 transition-all duration-300 hover:shadow-xl hover:shadow-blue-900/20">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-slate-400 mb-1">Total perçu</p>
                                <p class="text-2xl font-bold text-white">{{ number_format($totalPaiements, 0, ',', ' ') }}</p>
                                <p class="text-xs text-slate-500 mt-2">FCFA</p>
                            </div>
                            <div class="w-12 h-12 bg-green-900/30 rounded-xl flex items-center justify-center">
                                <i class="fas fa-wallet text-2xl text-green-400"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Paiements ce mois -->
                    <div class="bg-gradient-to-br from-slate-800 to-slate-900 rounded-2xl p-6 border border-slate-700 
                                hover:border-blue-500/50 transition-all duration-300 hover:shadow-xl hover:shadow-blue-900/20">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-slate-400 mb-1">Ce mois-ci</p>
                                <p class="text-2xl font-bold text-white">{{ number_format($montantCeMois, 0, ',', ' ') }}</p>
                                <p class="text-xs text-slate-500 mt-2">{{ $paiementsCeMois }} paiement(s)</p>
                            </div>
                            <div class="w-12 h-12 bg-blue-900/30 rounded-xl flex items-center justify-center">
                                <i class="fas fa-calendar-alt text-2xl text-blue-400"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Dernier paiement -->
                    <div class="bg-gradient-to-br from-slate-800 to-slate-900 rounded-2xl p-6 border border-slate-700 
                                hover:border-blue-500/50 transition-all duration-300 hover:shadow-xl hover:shadow-blue-900/20">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-slate-400 mb-1">Dernier paiement</p>
                                @if($dernierPaiement)
                                    <p class="text-xl font-bold text-white">{{ $dernierPaiement->created_at->format('d/m/Y') }}</p>
                                    <p class="text-xs text-slate-500 mt-2">{{ number_format($dernierPaiement->montant, 0, ',', ' ') }} FCFA</p>
                                @else
                                    <p class="text-xl font-bold text-slate-500">Aucun</p>
                                @endif
                            </div>
                            <div class="w-12 h-12 bg-purple-900/30 rounded-xl flex items-center justify-center">
                                <i class="fas fa-clock text-2xl text-purple-400"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Nombre total de paiements -->
                    <div class="bg-gradient-to-br from-slate-800 to-slate-900 rounded-2xl p-6 border border-slate-700 
                                hover:border-blue-500/50 transition-all duration-300 hover:shadow-xl hover:shadow-blue-900/20">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-slate-400 mb-1">Nombre de paiements</p>
                                <p class="text-2xl font-bold text-white">{{ $paiements->total() }}</p>
                                <p class="text-xs text-slate-500 mt-2">depuis votre inscription</p>
                            </div>
                            <div class="w-12 h-12 bg-yellow-900/30 rounded-xl flex items-center justify-center">
                                <i class="fas fa-credit-card text-2xl text-yellow-400"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tableau des paiements -->
                <div class="bg-gradient-to-br from-slate-800 to-slate-900 rounded-2xl border border-slate-700 overflow-hidden
                            hover:border-blue-500/50 transition-all duration-300">
                    <!-- En-tête du tableau -->
                    <div class="px-6 py-5 border-b border-slate-700 bg-slate-800/50">
                        <div class="flex items-center justify-between">
                            <h2 class="text-lg font-semibold text-white flex items-center gap-3">
                                <span class="w-1.5 h-6 bg-gradient-to-b from-blue-400 to-blue-600 rounded-full"></span>
                                Détail des paiements reçus
                            </h2>
                            <span class="px-3 py-1 bg-blue-900/30 text-blue-400 rounded-full text-sm border border-blue-800">
                                {{ $paiements->total() }} au total
                            </span>
                        </div>
                    </div>

                    <!-- Corps du tableau -->
                    <div class="overflow-x-auto">
                        @if($paiements->isNotEmpty())
                            <table class="w-full">
                                <thead class="bg-slate-900/70">
                                    <tr>
                                        <th class="py-4 px-6 text-left">
                                            <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Date</span>
                                        </th>
                                        <th class="py-4 px-6 text-left">
                                            <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Montant</span>
                                        </th>
                                        <th class="py-4 px-6 text-left">
                                            <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Statut</span>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-700">
                                    @foreach($paiements as $paiement)
                                    <tr class="hover:bg-slate-700/30 transition-colors duration-150">
                                        <td class="py-4 px-6">
                                            <div class="flex flex-col">
                                                <span class="text-white font-medium">{{ $paiement->created_at->format('d/m/Y') }}</span>
                                                <span class="text-xs text-slate-500">{{ $paiement->created_at->format('H:i') }}</span>
                                            </div>
                                        </td>
                                        <td class="py-4 px-6">
                                            <div class="flex items-center gap-2">
                                                <i class="fas fa-arrow-up text-green-500 text-sm"></i>
                                                <span class="text-lg font-bold text-green-400">
                                                    {{ number_format($paiement->montant, 0, ',', ' ') }}
                                                </span>
                                                <span class="text-xs text-slate-500">FCFA</span>
                                            </div>
                                        </td>
                                        <td class="py-4 px-6">
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-green-900/20 text-green-400 
                                                         rounded-full text-xs font-medium border border-green-800/50">
                                                <i class="fas fa-check-circle text-xs"></i>
                                                Effectué
                                            </span>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <div class="text-center py-16 px-6">
                                <div class="w-20 h-20 bg-slate-700/50 rounded-full flex items-center justify-center mx-auto mb-5">
                                    <i class="fas fa-coins text-3xl text-slate-500"></i>
                                </div>
                                <h3 class="text-xl font-bold text-white mb-3">Aucun paiement reçu</h3>
                                <p class="text-slate-400 mb-6 max-w-md mx-auto">
                                    Vous n'avez pas encore reçu de paiement de salaire.
                                </p>
                                <a href="{{ route('employe_dashboard') }}" 
                                   class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 
                                          hover:from-blue-700 hover:to-blue-800 text-white rounded-xl transition-all 
                                          duration-200 shadow-lg shadow-blue-900/30">
                                    <i class="fas fa-home"></i>
                                    <span>Retour à l'accueil</span>
                                </a>
                            </div>
                        @endif
                    </div>

                    <!-- Pagination -->
                    @if($paiements->hasPages())
                    <div class="px-6 py-5 border-t border-slate-700 bg-slate-800/50">
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                            <div class="text-sm text-slate-400">
                                Affichage de <span class="font-medium text-white">{{ $paiements->firstItem() }}</span>
                                à <span class="font-medium text-white">{{ $paiements->lastItem() }}</span>
                                sur <span class="font-medium text-white">{{ $paiements->total() }}</span> paiements
                            </div>
                            <div class="flex items-center gap-2">
                                {{ $paiements->onEachSide(1)->links('pagination::tailwind') }}
                            </div>
                        </div>
                    </div>
                    @endif
                </div>

                <!-- Graphique annuel (optionnel) -->
                @if($paiementsParAnnee->isNotEmpty())
                <div class="bg-gradient-to-br from-slate-800 to-slate-900 rounded-2xl p-6 border border-slate-700
                            hover:border-blue-500/50 transition-all duration-300">
                    <h3 class="text-lg font-semibold text-white mb-5 flex items-center gap-3">
                        <span class="w-1.5 h-6 bg-gradient-to-b from-purple-400 to-purple-600 rounded-full"></span>
                        Résumé par année
                    </h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                        @foreach($paiementsParAnnee as $annee)
                        <div class="bg-slate-800/80 rounded-xl p-4 border border-slate-700">
                            <p class="text-sm font-medium text-slate-400 mb-2">{{ $annee->annee }}</p>
                            <p class="text-lg font-bold text-white">{{ number_format($annee->total_montant, 0, ',', ' ') }} FCFA</p>
                            <p class="text-xs text-slate-500 mt-1">{{ $annee->total_paiements }} paiement(s)</p>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

            </div>
        </div>
    </div>
</main>

<style>
.hide-scrollbar {
    scrollbar-width: none;
    -ms-overflow-style: none;
}
.hide-scrollbar::-webkit-scrollbar {
    display: none;
}
</style>
@endsection