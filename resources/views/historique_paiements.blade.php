@extends('dashboard_base')

@section('main')
<main class="flex-1 overflow-hidden relative bg-slate-900">
    <div class="absolute inset-0 overflow-y-auto hide-scroll p-2">
        <div class="min-h-screen flex items-center justify-center px-4 py-8">
            <div class="max-w-6xl w-full space-y-8">
                <!-- En-tête -->
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-4">
                        <div class="p-3 bg-purple-500/20 rounded-full">
                            <i class="fas fa-history text-purple-400 text-2xl"></i>
                        </div>
                        <div>
                            <h1 class="text-2xl font-bold text-white">Historique des Paiements</h1>
                            <p class="text-slate-400">Suivi des paiements de salaire effectués</p>
                        </div>
                    </div>
                    <a href="{{ route('paiement.employe') }}" 
                       class="flex items-center space-x-2 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition">
                        <i class="fas fa-arrow-left"></i>
                        <span>Retour</span>
                    </a>
                </div>

                <!-- Statistiques -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="bg-slate-800 rounded-xl p-4 border border-slate-700">
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-blue-900/30 rounded-lg flex items-center justify-center mr-3">
                                <i class="fas fa-money-bill-wave text-blue-400"></i>
                            </div>
                            <div>
                                <p class="text-slate-400 text-sm">Total ce mois</p>
                                @php
                                    $totalMois = $paiements->filter(function($paiement) {
                                        return $paiement->created_at->format('Y-m') == now()->format('Y-m');
                                    })->sum('montant');
                                @endphp
                                <p class="text-xl font-bold text-white">{{ number_format($totalMois, 0, ',', ' ') }} FCFA</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-slate-800 rounded-xl p-4 border border-slate-700">
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-green-900/30 rounded-lg flex items-center justify-center mr-3">
                                <i class="fas fa-users text-green-400"></i>
                            </div>
                            <div>
                                <p class="text-slate-400 text-sm">Employés payés</p>
                                @php
                                    $countMois = $paiements->filter(function($paiement) {
                                        return $paiement->created_at->format('Y-m') == now()->format('Y-m');
                                    })->count();
                                @endphp
                                <p class="text-xl font-bold text-white">{{ $countMois }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-slate-800 rounded-xl p-4 border border-slate-700">
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-purple-900/30 rounded-lg flex items-center justify-center mr-3">
                                <i class="fas fa-calendar-alt text-purple-400"></i>
                            </div>
                            <div>
                                <p class="text-slate-400 text-sm">Dernier paiement</p>
                                <p class="text-lg font-bold text-white">
                                    @if($paiements->isNotEmpty())
                                        {{ $paiements->first()->created_at->format('d/m/Y') }}
                                    @else
                                        Aucun
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tableau des paiements -->
                <div class="bg-slate-800 rounded-xl border border-slate-700 overflow-hidden">
                    <div class="px-6 py-4 border-b border-slate-700">
                        <h2 class="text-lg font-bold text-white">
                            <i class="fas fa-list-alt mr-2"></i>Historique détaillé
                        </h2>
                    </div>
                    
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-slate-900/50">
                                <tr>
                                    <th class="py-3 px-4 text-left text-slate-400 font-semibold">Date</th>
                                    <th class="py-3 px-4 text-left text-slate-400 font-semibold">Employé</th>
                                    <th class="py-3 px-4 text-left text-slate-400 font-semibold">Montant</th>
                                    <th class="py-3 px-4 text-left text-slate-400 font-semibold">Référence</th>
                                    <th class="py-3 px-4 text-left text-slate-400 font-semibold">Type</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($paiements as $paiement)
                                <tr class="border-t border-slate-700 hover:bg-slate-700/30">
                                    <td class="py-3 px-4">
                                        <div class="flex flex-col">
                                            <span class="text-white">{{ $paiement->created_at->format('d/m/Y') }}</span>
                                            <span class="text-sm text-slate-500">{{ $paiement->created_at->format('H:i') }}</span>
                                        </div>
                                    </td>
                                    <td class="py-3 px-4">
                                        <div class="flex items-center">
                                            <div class="w-8 h-8 bg-slate-700 rounded-full flex items-center justify-center mr-2">
                                                <i class="fas fa-user text-sm text-slate-400"></i>
                                            </div>
                                            <span class="text-white">{{ $paiement->employe_nom ?? 'N/A' }}</span>
                                        </div>
                                    </td>
                                    <td class="py-3 px-4">
                                        <div class="flex items-center gap-2">
                                            <i class="fas fa-arrow-right text-red-400"></i>
                                            <span class="font-bold text-red-400">
                                                -{{ number_format($paiement->montant, 0, ',', ' ') }} FCFA
                                            </span>
                                        </div>
                                    </td>
                                    <td class="py-3 px-4">
                                        <div class="inline-flex items-center gap-1 px-2 py-1 bg-slate-700/50 rounded border border-slate-600">
                                            <i class="fas fa-hashtag text-slate-400 text-xs"></i>
                                            <span class="text-sm font-mono text-slate-300">{{ $paiement->reference ?? 'N/A' }}</span>
                                        </div>
                                    </td>
                                    <td class="py-3 px-4">
                                        <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-sm
                                            @if($paiement->type == 'Sortie') 
                                                bg-green-900/30 text-green-400 border border-green-800
                                            @else 
                                                bg-blue-900/30 text-blue-400 border border-blue-800
                                            @endif">
                                            @if($paiement->type == 'Sortie')
                                                <i class="fas fa-check-circle text-xs"></i>
                                            @else
                                                <i class="fas fa-sign-in-alt text-xs"></i>
                                            @endif
                                            {{ $paiement->type }}
                                        </span>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="py-12 text-center">
                                        <div class="max-w-md mx-auto">
                                            <div class="w-16 h-16 bg-slate-700 rounded-full flex items-center justify-center mx-auto mb-4">
                                                <i class="fas fa-history text-2xl text-slate-500"></i>
                                            </div>
                                            <h3 class="text-xl font-bold text-white mb-2">Aucun paiement</h3>
                                            <p class="text-slate-400 mb-6">Commencez à payer vos employés</p>
                                            <a href="{{ route('paiement.employe') }}" 
                                               class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 rounded-lg transition">
                                                <i class="fas fa-credit-card"></i>
                                                Effectuer un paiement
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if($paiements->isNotEmpty())
                    <div class="px-6 py-4 border-t border-slate-700">
                        <div class="flex justify-between items-center">
                            <div class="text-slate-400">
                                Affichage de {{ $paiements->count() }} paiements
                            </div>
                            <div class="text-slate-400">
                                Total: 
                                <span class="text-white font-bold ml-2">
                                    {{ number_format($paiements->sum('montant'), 0, ',', ' ') }} FCFA
                                </span>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>

                <!-- Graphique simple -->
                @if($paiements->isNotEmpty())
                <div class="bg-slate-800 rounded-xl p-6 border border-slate-700">
                    <h3 class="text-lg font-bold text-white mb-4">
                        <i class="fas fa-chart-line mr-2"></i>Répartition des paiements
                    </h3>
                    <div class="space-y-4">
                        @php
                            $sixMonthsAgo = now()->subMonths(5)->startOfMonth();
                            $paiementsParMois = [];
                            for($i = 0; $i < 6; $i++) {
                                $month = $sixMonthsAgo->copy()->addMonths($i);
                                $paiementsParMois[$month->format('Y-m')] = [
                                    'month' => $month->format('M Y'),
                                    'amount' => 0
                                ];
                            }
                            
                            foreach($paiements as $paiement) {
                                $month = $paiement->created_at->format('Y-m');
                                if(isset($paiementsParMois[$month])) {
                                    $paiementsParMois[$month]['amount'] += $paiement->montant;
                                }
                            }
                            $maxAmount = max(array_column($paiementsParMois, 'amount'));
                        @endphp
                        
                        @foreach($paiementsParMois as $data)
                        <div>
                            <div class="flex justify-between mb-1">
                                <span class="text-slate-300">{{ $data['month'] }}</span>
                                <span class="text-slate-400">{{ number_format($data['amount'], 0, ',', ' ') }} FCFA</span>
                            </div>
                            <div class="h-2 bg-slate-700 rounded-full overflow-hidden">
                                @php $width = $maxAmount > 0 ? ($data['amount'] / $maxAmount) * 100 : 0; @endphp
                                <div class="h-full bg-gradient-to-r from-blue-500 to-blue-600 rounded-full"
                                     style="width: {{ $width }}%"></div>
                            </div>
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
.hide-scroll {
    scrollbar-width: none;
    -ms-overflow-style: none;
}

.hide-scroll::-webkit-scrollbar {
    display: none;
}
</style>
@endsection