@extends('dashboard_base')

@section('main')
<main class="flex-1 overflow-hidden relative bg-slate-900">
    <div class="absolute inset-0 overflow-y-auto hide-scroll p-2">
        <div class="min-h-screen flex items-center justify-center px-4 py-8">
            <div class="max-w-6xl w-full space-y-8 animate-fade-in">
                <!-- En-tête avec animation -->
                <div class="flex items-center justify-between" data-aos="fade-right">
                    <div class="flex items-center space-x-4">
                        <div class="p-3 bg-purple-500/20 rounded-full">
                            <div class="text-purple-400 text-3xl">
                                <i class="fas fa-history"></i>
                            </div>
                        </div>
                        <div>
                            <h1 class="text-3xl font-bold text-white">Historique des Paiements</h1>
                            <p class="text-slate-400">Suivi des paiements de salaire effectués</p>
                        </div>
                    </div>
                    <!-- Bouton retour -->
                    <a href="{{ route('paiement.employe') }}" 
                       class="flex items-center space-x-2 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white px-6 py-3 rounded-lg transition-all duration-300 shadow-lg hover:shadow-xl">
                        <span>Retour aux paiements</span>
                        <i class="fas fa-chevron-right ml-1 text-sm"></i>
                    </a>
                </div>

                <!-- Statistiques en haut -->
                <div class="max-w-6xl mx-auto" data-aos="fade-up">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- Total payé ce mois -->
                        <div class="bg-gradient-to-r from-blue-900/20 to-blue-800/20 backdrop-blur-sm rounded-2xl p-6 border border-slate-700/50
                                    hover:border-blue-500/30 transition-all duration-300">
                            <div class="flex items-center">
                                <div class="w-14 h-14 bg-blue-900/30 rounded-xl flex items-center justify-center mr-4">
                                    <i class="fas fa-money-bill-wave text-2xl text-blue-400"></i>
                                </div>
                                <div>
                                    <p class="text-slate-400 text-sm mb-1">Total payé ce mois</p>
                                    <p class="text-2xl font-bold text-white">
                                        @php
                                            $totalMois = $paiements->filter(function($paiement) {
                                                return $paiement->created_at->format('Y-m') == now()->format('Y-m');
                                            })->sum('montant');
                                        @endphp
                                        {{ number_format($totalMois, 0, ',', ' ') }} FCFA
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Employés payés ce mois -->
                        <div class="bg-gradient-to-r from-green-900/20 to-emerald-900/20 backdrop-blur-sm rounded-2xl p-6 border border-slate-700/50
                                    hover:border-green-500/30 transition-all duration-300">
                            <div class="flex items-center">
                                <div class="w-14 h-14 bg-green-900/30 rounded-xl flex items-center justify-center mr-4">
                                    <i class="fas fa-users text-2xl text-green-400"></i>
                                </div>
                                <div>
                                    <p class="text-slate-400 text-sm mb-1">Employés payés ce mois</p>
                                    <p class="text-2xl font-bold text-white">
                                        @php
                                            $countMois = $paiements->filter(function($paiement) {
                                                return $paiement->created_at->format('Y-m') == now()->format('Y-m');
                                            })->count();
                                        @endphp
                                        {{ $countMois }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Dernier paiement -->
                        <div class="bg-gradient-to-r from-purple-900/20 to-pink-900/20 backdrop-blur-sm rounded-2xl p-6 border border-slate-700/50
                                    hover:border-purple-500/30 transition-all duration-300">
                            <div class="flex items-center">
                                <div class="w-14 h-14 bg-purple-900/30 rounded-xl flex items-center justify-center mr-4">
                                    <i class="fas fa-calendar-alt text-2xl text-purple-400"></i>
                                </div>
                                <div>
                                    <p class="text-slate-400 text-sm mb-1">Dernier paiement</p>
                                    <p class="text-xl font-bold text-white">
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
                </div>

                <!-- Tableau des paiements -->
                <div class="max-w-6xl mx-auto" data-aos="fade-up" data-aos-delay="200">
                    <div class="bg-slate-800/70 backdrop-blur-sm rounded-2xl border border-slate-700/50 overflow-hidden
                                shadow-2xl">
                        <!-- En-tête du tableau -->
                        <div class="px-6 py-4 border-b border-slate-700/50 bg-slate-900/30">
                            <h2 class="text-xl font-bold text-white flex items-center">
                                <i class="fas fa-list-alt mr-3"></i>Historique détaillé
                            </h2>
                        </div>
                        
                        <!-- Conteneur du tableau avec scroll -->
                        <div class="overflow-x-auto max-h-[500px] hide-scroll">
                            <table class="w-full min-w-full">
                                <thead class="sticky top-0 bg-slate-900/95 backdrop-blur-sm z-10">
                                    <tr>
                                        <th class="py-4 px-6 text-left">
                                            <div class="flex items-center gap-2 text-slate-400 font-semibold">
                                                <i class="fas fa-calendar"></i>
                                                <span>Date</span>
                                            </div>
                                        </th>
                                        <th class="py-4 px-6 text-left">
                                            <div class="flex items-center gap-2 text-slate-400 font-semibold">
                                                <i class="fas fa-user"></i>
                                                <span>Employé</span>
                                            </div>
                                        </th>
                                        <th class="py-4 px-6 text-left">
                                            <div class="flex items-center gap-2 text-slate-400 font-semibold">
                                                <i class="fas fa-money-bill"></i>
                                                <span>Montant</span>
                                            </div>
                                        </th>
                                        <th class="py-4 px-6 text-left">
                                            <div class="flex items-center gap-2 text-slate-400 font-semibold">
                                                <i class="fas fa-hashtag"></i>
                                                <span>Référence</span>
                                            </div>
                                        </th>
                                        <th class="py-4 px-6 text-left">
                                            <div class="flex items-center gap-2 text-slate-400 font-semibold">
                                                <i class="fas fa-info-circle"></i>
                                                <span>Type</span>
                                            </div>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-700/50">
                                    @forelse($paiements as $paiement)
                                    <tr class="hover:bg-slate-700/30 transition-colors duration-200
                                               animate__animated animate__fadeInUp"
                                        style="animation-delay: {{ $loop->index * 50 }}ms">
                                        <td class="py-4 px-6">
                                            <div class="flex flex-col">
                                                <span class="text-white font-medium">
                                                    {{ $paiement->created_at->format('d/m/Y') }}
                                                </span>
                                                <span class="text-sm text-slate-500">
                                                    {{ $paiement->created_at->format('H:i') }}
                                                </span>
                                            </div>
                                        </td>
                                        <td class="py-4 px-6">
                                            <div class="flex items-center">
                                                <div class="w-10 h-10 bg-slate-700 rounded-full flex items-center justify-center mr-3">
                                                    <i class="fas fa-user text-slate-400"></i>
                                                </div>
                                                <span class="text-white font-medium">
                                                    {{ $paiement->employe_nom ?? 'N/A' }}
                                                </span>
                                            </div>
                                        </td>
                                        <td class="py-4 px-6">
                                            <div class="flex items-center gap-2">
                                                <i class="fas fa-arrow-right text-red-400"></i>
                                                <span class="text-xl font-bold text-red-400">
                                                    -{{ number_format($paiement->montant, 0, ',', ' ') }} FCFA
                                                </span>
                                            </div>
                                        </td>
                                        <td class="py-4 px-6">
                                            <div class="inline-flex items-center gap-2 px-3 py-1.5 
                                                       bg-slate-700/50 rounded-lg border border-slate-600">
                                                <i class="fas fa-hashtag text-slate-400"></i>
                                                <span class="text-sm font-mono text-slate-300">
                                                    {{ $paiement->reference ?? 'N/A' }}
                                                </span>
                                            </div>
                                        </td>
                                        <td class="py-4 px-6">
                                            <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full 
                                                       text-sm font-medium
                                                       @if($paiement->type == 'Sortie') 
                                                           bg-green-900/30 text-green-400 border border-green-800/50
                                                       @else 
                                                           bg-blue-900/30 text-blue-400 border border-blue-800/50
                                                       @endif">
                                                @if($paiement->type == 'Sortie')
                                                    <i class="fas fa-check-circle"></i>
                                                @else
                                                    <i class="fas fa-sign-in-alt"></i>
                                                @endif
                                                {{ $paiement->type }}
                                            </span>
                                        </td>
                                    </tr>
                                    @empty
                                    <!-- État vide -->
                                    <tr>
                                        <td colspan="5" class="py-16 text-center">
                                            <div class="max-w-md mx-auto">
                                                <div class="w-24 h-24 bg-slate-800/50 rounded-full 
                                                            flex items-center justify-center mx-auto mb-6">
                                                    <i class="fas fa-history text-4xl text-slate-500"></i>
                                                </div>
                                                <h3 class="text-2xl font-bold text-white mb-3">
                                                    Aucun paiement enregistré
                                                </h3>
                                                <p class="text-slate-400 mb-8">
                                                    Commencez à payer vos employés pour voir apparaître l'historique ici.
                                                </p>
                                                <a href="{{ route('paiement.employe') }}" 
                                                   class="inline-flex items-center gap-3 px-6 py-3 
                                                          bg-gradient-to-r from-blue-600 to-blue-700 
                                                          hover:from-blue-700 hover:to-blue-800 
                                                          rounded-xl font-medium transition">
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

                        <!-- Résumé en bas du tableau -->
                        @if($paiements->isNotEmpty())
                        <div class="px-6 py-4 border-t border-slate-700/50 bg-slate-900/30">
                            <div class="flex justify-between items-center">
                                <div class="text-slate-400">
                                    <i class="fas fa-chart-bar mr-2"></i>
                                    Affichage de {{ $paiements->count() }} paiements
                                </div>
                                <div class="text-slate-400">
                                    Total général: 
                                    <span class="text-white font-bold ml-2">
                                        {{ number_format($paiements->sum('montant'), 0, ',', ' ') }} FCFA
                                    </span>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Graphique de visualisation (optionnel) -->
                @if($paiements->isNotEmpty())
                <div class="max-w-6xl mx-auto" data-aos="fade-up" data-aos-delay="400">
                    <div class="bg-slate-800/70 backdrop-blur-sm rounded-2xl p-8 border border-slate-700/50">
                        <h3 class="text-xl font-bold text-white mb-6 flex items-center">
                            <i class="fas fa-chart-line mr-3"></i>Répartition des paiements
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <!-- Par mois -->
                            <div>
                                <h4 class="text-slate-400 mb-4">Par mois (derniers 6 mois)</h4>
                                <div class="space-y-4">
                                    @php
                                        $sixMonthsAgo = now()->subMonths(5)->startOfMonth();
                                        $currentMonth = now()->startOfMonth();
                                        
                                        // Grouper les paiements par mois
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
                                    @endphp
                                    
                                    @foreach($paiementsParMois as $data)
                                    <div>
                                        <div class="flex justify-between mb-1">
                                            <span class="text-slate-300">{{ $data['month'] }}</span>
                                            <span class="text-slate-400">{{ number_format($data['amount'], 0, ',', ' ') }} FCFA</span>
                                        </div>
                                        <div class="h-2 bg-slate-700 rounded-full overflow-hidden">
                                            @php
                                                $maxAmount = max(array_column($paiementsParMois, 'amount'));
                                                $width = $maxAmount > 0 ? ($data['amount'] / $maxAmount) * 100 : 0;
                                            @endphp
                                            <div class="h-full bg-gradient-to-r from-blue-500 to-blue-600 rounded-full"
                                                 style="width: {{ $width }}%"></div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            
                            <!-- Top 5 employés -->
                            <div>
                                <h4 class="text-slate-400 mb-4">Top 5 employés payés</h4>
                                <div class="space-y-4">
                                    @php
                                        // Grouper par employé
                                        $paiementsParEmploye = [];
                                        foreach($paiements as $paiement) {
                                            $employeNom = $paiement->employe_nom ?? 'Inconnu';
                                            if(!isset($paiementsParEmploye[$employeNom])) {
                                                $paiementsParEmploye[$employeNom] = 0;
                                            }
                                            $paiementsParEmploye[$employeNom] += $paiement->montant;
                                        }
                                        arsort($paiementsParEmploye);
                                        $top5 = array_slice($paiementsParEmploye, 0, 5, true);
                                    @endphp
                                    
                                    @foreach($top5 as $employe => $montant)
                                    <div class="flex items-center">
                                        <div class="w-8 h-8 bg-slate-700 rounded-full flex items-center 
                                                   justify-center mr-3">
                                            <span class="text-xs font-bold text-slate-300">
                                                {{ $loop->iteration }}
                                            </span>
                                        </div>
                                        <div class="flex-1">
                                            <div class="flex justify-between mb-1">
                                                <span class="text-slate-300 truncate max-w-[150px]">
                                                    {{ $employe }}
                                                </span>
                                                <span class="text-slate-400">
                                                    {{ number_format($montant, 0, ',', ' ') }} FCFA
                                                </span>
                                            </div>
                                            <div class="h-2 bg-slate-700 rounded-full overflow-hidden">
                                                @php
                                                    $maxMontant = max($top5);
                                                    $width = $montant / $maxMontant * 100;
                                                @endphp
                                                <div class="h-full bg-gradient-to-r from-green-500 to-green-600 rounded-full"
                                                     style="width: {{ $width }}%"></div>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Effets décoratifs -->
    <div class="absolute -bottom-32 -left-32 w-64 h-64 bg-purple-500 rounded-full mix-blend-multiply filter blur-3xl opacity-5"></div>
    <div class="absolute -top-32 -right-32 w-64 h-64 bg-pink-500 rounded-full mix-blend-multiply filter blur-3xl opacity-5"></div>
    <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-96 h-96 bg-blue-500 rounded-full mix-blend-multiply filter blur-3xl opacity-3"></div>
</main>

<style>
/* Animations */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.animate__fadeInUp {
    animation-name: fadeInUp;
    animation-duration: 0.5s;
    animation-fill-mode: both;
}

/* Hide scroll class */
.hide-scroll {
    scrollbar-width: none;
    -ms-overflow-style: none;
}

.hide-scroll::-webkit-scrollbar {
    display: none;
}

/* Effets de survol améliorés */
.hover-lift {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.hover-lift:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
}

/* Ombre portée */
.shadow-2xl {
    box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
}

/* Styles pour les rangées du tableau */
tr {
    animation-duration: 0.6s;
    animation-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
}

/* Effet de brillance sur les cartes */
.shimmer {
    position: relative;
    overflow: hidden;
}

.shimmer::after {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(
        90deg,
        transparent,
        rgba(255, 255, 255, 0.1),
        transparent
    );
    animation: shimmer 2s infinite;
}

@keyframes shimmer {
    100% {
        left: 100%;
    }
}
</style>

<script>
// Script pour améliorer l'interactivité
document.addEventListener('DOMContentLoaded', function() {
    // Animation des lignes du tableau
    const tableRows = document.querySelectorAll('tbody tr');
    tableRows.forEach((row, index) => {
        row.style.animationDelay = `${index * 50}ms`;
    });

    // Effet de survol sur les cartes
    const cards = document.querySelectorAll('.bg-gradient-to-r');
    cards.forEach(card => {
        card.addEventListener('mouseenter', () => {
            card.classList.add('shadow-lg', 'transform', '-translate-y-1');
        });
        card.addEventListener('mouseleave', () => {
            card.classList.remove('shadow-lg', 'transform', '-translate-y-1');
        });
    });

    function showNotification(message, type) {
        const notification = document.createElement('div');
        notification.className = `fixed top-6 right-6 z-50 px-6 py-4 rounded-xl shadow-2xl 
            transform translate-x-full transition-transform duration-300
            ${type === 'error' ? 'bg-red-900/90 border border-red-700' : 'bg-green-900/90 border border-green-700'}`;
        notification.innerHTML = `
            <div class="flex items-center gap-3">
                <i class="fas fa-${type === 'error' ? 'exclamation-circle' : 'check-circle'} 
                   text-${type === 'error' ? 'red' : 'green'}-400 text-xl"></i>
                <span class="text-white">${message}</span>
            </div>
        `;
        
        document.body.appendChild(notification);
        
        setTimeout(() => {
            notification.classList.remove('translate-x-full');
            notification.classList.add('translate-x-0');
        }, 10);
        
        setTimeout(() => {
            notification.classList.remove('translate-x-0');
            notification.classList.add('translate-x-full');
            setTimeout(() => notification.remove(), 300);
        }, 5000);
    }
});
</script>
@endsection