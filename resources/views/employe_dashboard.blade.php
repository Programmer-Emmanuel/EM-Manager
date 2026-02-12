@extends('employe_dashboard_base')

@section('main')
<main class="flex-1 overflow-hidden relative bg-gradient-to-br from-slate-900 via-slate-900 to-slate-800">
    <div class="absolute inset-0 overflow-y-auto hide-scrollbar p-4 md:p-6 lg:p-8">
        <div class="max-w-7xl mx-auto space-y-6 md:space-y-8">
            
            <!-- EN-TÊTE AVEC BADGE DE BIENVENUE -->
            <div class="relative overflow-hidden">
                <!-- Background decoration -->
                <div class="absolute inset-0 bg-gradient-to-r from-blue-600/10 via-purple-600/10 to-pink-600/10 rounded-3xl blur-3xl"></div>
                
                <div class="relative bg-gradient-to-r from-slate-800/80 via-slate-800/60 to-slate-800/80 backdrop-blur-xl rounded-3xl p-6 md:p-8 border border-slate-700/50 shadow-2xl">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">
                        <div class="flex items-center gap-4">
                            <div class="">
                                <div class="w-16 h-16 bg-slate-800 rounded-2xl flex items-center justify-center ">
                                    <span class="text-2xl font-bold text-white">
                                        {{ substr($employeDetails->prenom_employe, 0, 1) }}{{ substr($employeDetails->nom_employe, 0, 1) }}
                                    </span>
                                </div>
                            </div>
                            <div>
                                <div class="flex items-center gap-2 flex-wrap">
                                    <h1 class="text-2xl md:text-3xl font-bold text-white">
                                        Bienvenue, {{ $employeDetails->prenom_employe }} {{ $employeDetails->nom_employe }} !
                                    </h1>
                                </div>
                                <p class="text-slate-400 mt-2 flex items-center gap-2">
                                    <i class="fas fa-building text-blue-400"></i>
                                    {{ $entreprise->nom_entreprise ?? 'Entreprise' }} 
                                </p>
                            </div>
                        </div>
                        
                        <!-- Date et heure -->
                        <div class="flex items-center gap-3 px-4 py-2 bg-slate-700/30 rounded-xl border border-slate-600/50">
                            <i class="fas fa-calendar-alt text-blue-400"></i>
                            <span class="text-white font-medium">{{ now()->isoFormat('dddd D MMMM YYYY') }}</span>
                            <div class="w-px h-4 bg-slate-600 mx-2"></div>
                            <i class="fas fa-clock text-purple-400"></i>
                            <span class="text-white">{{ now()->format('H:i') }}</span>
                        </div>
                    </div>
                </div>
            </div>

            

            <!-- CARTES DE STATISTIQUES PRINCIPALES -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6">
                <!-- Carte Salaire de base -->
                <div class="group relative bg-gradient-to-br from-slate-800 to-slate-900 rounded-2xl p-6 border border-slate-700 hover:border-emerald-500/50 transition-all duration-500 hover:shadow-2xl hover:shadow-emerald-500/10">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-emerald-500/5 rounded-full blur-3xl group-hover:bg-emerald-500/10 transition-all"></div>
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="text-sm font-medium text-slate-400 mb-1 flex items-center gap-2">
                                <span class="w-1.5 h-1.5 bg-emerald-400 rounded-full"></span>
                                Salaire de base
                            </p>
                            <p class="text-2xl font-bold text-white">{{ number_format($salaireBase, 0, ',', ' ') }}</p>
                            <p class="text-xs text-slate-500 mt-2">FCFA / mois</p>
                        </div>
                        <div class="w-12 h-12 bg-emerald-900/30 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform">
                            <i class="fas fa-file-invoice-dollar text-2xl text-emerald-400"></i>
                        </div>
                    </div>
                    <div class="mt-4 pt-4 border-t border-slate-700/50">
                        <div class="flex items-center justify-between text-xs">
                            <span class="text-slate-500">Total perçu</span>
                            <span class="text-white font-medium">{{ number_format($totalSalaire, 0, ',', ' ') }} FCFA</span>
                        </div>
                    </div>
                </div>

                <!-- Carte Salaire du mois -->
                <div class="group relative bg-gradient-to-br from-slate-800 to-slate-900 rounded-2xl p-6 border border-slate-700 hover:border-blue-500/50 transition-all duration-500 hover:shadow-2xl hover:shadow-blue-500/10">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-blue-500/5 rounded-full blur-3xl group-hover:bg-blue-500/10 transition-all"></div>
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="text-sm font-medium text-slate-400 mb-1 flex items-center gap-2">
                                <span class="w-1.5 h-1.5 bg-blue-400 rounded-full"></span>
                                Salaire du mois
                            </p>
                            <p class="text-2xl font-bold {{ $salaireMois > 0 ? 'text-green-400' : 'text-slate-500' }}">
                                {{ $salaireMois > 0 ? number_format($salaireMois, 0, ',', ' ') : 'Non versé' }}
                            </p>
                            @if($dernierPaiement)
                            <p class="text-xs text-slate-500 mt-2">
                                {{ $dernierPaiement->created_at->isoFormat('D MMM YYYY') }}
                            </p>
                            @endif
                        </div>
                        <div class="w-12 h-12 bg-blue-900/30 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform">
                            <i class="fas fa-credit-card text-2xl text-blue-400"></i>
                        </div>
                    </div>
                    @if($salaireMois == 0)
                    <div class="mt-4">
                        <span class="px-2 py-1 bg-yellow-900/30 text-yellow-400 rounded-lg text-xs border border-yellow-800">
                            <i class="fas fa-clock mr-1"></i> En attente de virement
                        </span>
                    </div>
                    @endif
                </div>

                <!-- Carte Congés -->
                <div class="group relative bg-gradient-to-br from-slate-800 to-slate-900 rounded-2xl p-6 border border-slate-700 hover:border-purple-500/50 transition-all duration-500 hover:shadow-2xl hover:shadow-purple-500/10">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-purple-500/5 rounded-full blur-3xl group-hover:bg-purple-500/10 transition-all"></div>
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="text-sm font-medium text-slate-400 mb-1 flex items-center gap-2">
                                <span class="w-1.5 h-1.5 bg-purple-400 rounded-full"></span>
                                Congés
                            </p>
                            <p class="text-2xl font-bold text-white">{{ $joursCongesPris }}</p>
                            <p class="text-xs text-slate-500 mt-2">jours pris cette année</p>
                        </div>
                        <div class="w-12 h-12 bg-purple-900/30 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform">
                            <i class="fas fa-umbrella-beach text-2xl text-purple-400"></i>
                        </div>
                    </div>
                    <div class="mt-4 pt-4 border-t border-slate-700/50">
                        <div class="flex items-center justify-between text-xs">
                            <span class="text-slate-500 flex items-center gap-1">
                                <i class="fas fa-clock text-yellow-400"></i> En attente
                            </span>
                            <span class="text-white font-medium">{{ $congesEnAttente }}</span>
                        </div>
                    </div>
                </div>

                <!-- Carte Ancienneté -->
                <div class="group relative bg-gradient-to-br from-slate-800 to-slate-900 rounded-2xl p-6 border border-slate-700 hover:border-amber-500/50 transition-all duration-500 hover:shadow-2xl hover:shadow-amber-500/10">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-amber-500/5 rounded-full blur-3xl group-hover:bg-amber-500/10 transition-all"></div>
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="text-sm font-medium text-slate-400 mb-1 flex items-center gap-2">
                                <span class="w-1.5 h-1.5 bg-amber-400 rounded-full"></span>
                                Ancienneté
                            </p>
                            @if($ancienneteAns > 0)
                                <p class="text-2xl font-bold text-white">{{ $ancienneteAns }} an{{ $ancienneteAns > 1 ? 's' : '' }}</p>
                            @else
                                <p class="text-2xl font-bold text-white">{{ $ancienneteMois }} mois</p>
                            @endif
                            <p class="text-xs text-slate-500 mt-2">{{ $dateEmbauche->isoFormat('D MMM YYYY') }}</p>
                        </div>
                        <div class="w-12 h-12 bg-amber-900/30 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform">
                            <i class="fas fa-calendar-check text-2xl text-amber-400"></i>
                        </div>
                    </div>
                    <div class="mt-4 pt-4 border-t border-slate-700/50">
                        <div class="flex items-center justify-between text-xs">
                            <span class="text-slate-500">Jours dans l'entreprise</span>
                            <span class="text-white font-medium">{{ number_format($ancienneteJours, 0, ',', ' ') }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- SECTION GRAPHIQUES -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 md:gap-8">
                <!-- Graphique en barres - Évolution des salaires -->
                <div class="bg-gradient-to-br from-slate-800 to-slate-900 rounded-2xl p-6 border border-slate-700 hover:border-blue-500/50 transition-all duration-500">
                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <h3 class="text-lg font-bold text-white flex items-center gap-2">
                                <span class="w-1.5 h-6 bg-gradient-to-b from-blue-400 to-blue-600 rounded-full"></span>
                                Évolution des salaires
                            </h3>
                            <p class="text-xs text-slate-400 mt-1">12 derniers mois</p>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="w-2 h-2 bg-blue-400 rounded-full"></span>
                            <span class="text-xs text-slate-400">Montant en FCFA</span>
                        </div>
                    </div>
                    <div class="h-64 relative">
                        <canvas id="salaryChart"></canvas>
                    </div>
                </div>

                <!-- Graphique circulaire - Statut des congés -->
                <div class="bg-gradient-to-br from-slate-800 to-slate-900 rounded-2xl p-6 border border-slate-700 hover:border-purple-500/50 transition-all duration-500">
                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <h3 class="text-lg font-bold text-white flex items-center gap-2">
                                <span class="w-1.5 h-6 bg-gradient-to-b from-purple-400 to-purple-600 rounded-full"></span>
                                Répartition des congés
                            </h3>
                            <p class="text-xs text-slate-400 mt-1">Statut des demandes</p>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="flex items-center gap-1">
                                <span class="w-2 h-2 bg-green-400 rounded-full"></span>
                                <span class="text-xs text-slate-400">Approuvé</span>
                            </div>
                            <div class="flex items-center gap-1">
                                <span class="w-2 h-2 bg-yellow-400 rounded-full"></span>
                                <span class="text-xs text-slate-400">En attente</span>
                            </div>
                            <div class="flex items-center gap-1">
                                <span class="w-2 h-2 bg-red-400 rounded-full"></span>
                                <span class="text-xs text-slate-400">Refusé</span>
                            </div>
                        </div>
                    </div>
                    <div class="h-64 relative flex items-center justify-center">
                        <canvas id="leaveChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- DEUXIÈME LIGNE DE GRAPHIQUES -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 md:gap-8">
                <!-- Graphique en barres - Congés par mois -->
                <div class="bg-gradient-to-br from-slate-800 to-slate-900 rounded-2xl p-6 border border-slate-700 hover:border-emerald-500/50 transition-all duration-500">
                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <h3 class="text-lg font-bold text-white flex items-center gap-2">
                                <span class="w-1.5 h-6 bg-gradient-to-b from-emerald-400 to-emerald-600 rounded-full"></span>
                                Congés par mois
                            </h3>
                            <p class="text-xs text-slate-400 mt-1">Année {{ now()->year }}</p>
                        </div>
                    </div>
                    <div class="h-64 relative">
                        <canvas id="monthlyLeaveChart"></canvas>
                    </div>
                </div>

                <!-- Graphique circulaire - Répartition par année -->
                <div class="bg-gradient-to-br from-slate-800 to-slate-900 rounded-2xl p-6 border border-slate-700 hover:border-amber-500/50 transition-all duration-500">
                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <h3 class="text-lg font-bold text-white flex items-center gap-2">
                                <span class="w-1.5 h-6 bg-gradient-to-b from-amber-400 to-amber-600 rounded-full"></span>
                                Salaires par année
                            </h3>
                            <p class="text-xs text-slate-400 mt-1">Répartition</p>
                        </div>
                    </div>
                    <div class="h-64 relative flex items-center justify-center">
                        <canvas id="yearlySalaryChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- CARTES DE NAVIGATION RAPIDE -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-6">
                <!-- Mon compte -->
                <a href="{{ route('employe_compte') }}" 
                   class="group relative bg-gradient-to-br from-slate-800 to-slate-900 rounded-xl p-6 border border-slate-700 
                          hover:border-blue-500/50 transition-all duration-300 overflow-hidden">
                    <div class="absolute inset-0 bg-gradient-to-r from-blue-600/0 to-blue-600/0 group-hover:from-blue-600/10 group-hover:to-purple-600/10 transition-all duration-500"></div>
                    <div class="relative flex items-center gap-4">
                        <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center shadow-lg shadow-blue-600/30 group-hover:scale-110 transition-transform">
                            <i class="fas fa-user-circle text-2xl text-white"></i>
                        </div>
                        <div>
                            <h4 class="text-white font-semibold group-hover:text-blue-400 transition-colors">Mon compte</h4>
                            <p class="text-sm text-slate-400 mt-1">Voir mes informations</p>
                        </div>
                        <i class="fas fa-chevron-right text-slate-600 ml-auto group-hover:text-blue-400 group-hover:translate-x-1 transition-all"></i>
                    </div>
                </a>

                <!-- Demandes de congés -->
                <a href="{{ route('employe_conge') }}" 
                   class="group relative bg-gradient-to-br from-slate-800 to-slate-900 rounded-xl p-6 border border-slate-700 
                          hover:border-purple-500/50 transition-all duration-300 overflow-hidden">
                    <div class="absolute inset-0 bg-gradient-to-r from-purple-600/0 to-purple-600/0 group-hover:from-purple-600/10 group-hover:to-pink-600/10 transition-all duration-500"></div>
                    <div class="relative flex items-center gap-4">
                        <div class="w-12 h-12 bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl flex items-center justify-center shadow-lg shadow-purple-600/30 group-hover:scale-110 transition-transform">
                            <i class="fas fa-calendar-alt text-2xl text-white"></i>
                        </div>
                        <div>
                            <h4 class="text-white font-semibold group-hover:text-purple-400 transition-colors">Congés</h4>
                            <p class="text-sm text-slate-400 mt-1">
                                @if($congesEnAttente > 0)
                                    <span class="text-yellow-400">{{ $congesEnAttente }} en attente</span>
                                @else
                                    Nouvelle demande
                                @endif
                            </p>
                        </div>
                        <i class="fas fa-chevron-right text-slate-600 ml-auto group-hover:text-purple-400 group-hover:translate-x-1 transition-all"></i>
                    </div>
                </a>

                <!-- Historique des paiements -->
                <a href="{{ route('employe_historique_paiements') }}" 
                   class="group relative bg-gradient-to-br from-slate-800 to-slate-900 rounded-xl p-6 border border-slate-700 
                          hover:border-emerald-500/50 transition-all duration-300 overflow-hidden sm:col-span-2 lg:col-span-1">
                    <div class="absolute inset-0 bg-gradient-to-r from-emerald-600/0 to-emerald-600/0 group-hover:from-emerald-600/10 group-hover:to-teal-600/10 transition-all duration-500"></div>
                    <div class="relative flex items-center gap-4">
                        <div class="w-12 h-12 bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-xl flex items-center justify-center shadow-lg shadow-emerald-600/30 group-hover:scale-110 transition-transform">
                            <i class="fas fa-history text-2xl text-white"></i>
                        </div>
                        <div>
                            <h4 class="text-white font-semibold group-hover:text-emerald-400 transition-colors">Historique des paies</h4>
                            <p class="text-sm text-slate-400 mt-1">
                                {{ $paiements->count() ?? 0 }} paiements
                            </p>
                        </div>
                        <i class="fas fa-chevron-right text-slate-600 ml-auto group-hover:text-emerald-400 group-hover:translate-x-1 transition-all"></i>
                    </div>
                </a>
            </div>

            <!-- PROGRESSION SALARIALE -->
            <div class="bg-gradient-to-br from-slate-800 to-slate-900 rounded-2xl p-6 border border-slate-700">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-4">
                    <div>
                        <h3 class="text-lg font-bold text-white flex items-center gap-2">
                            <span class="w-1.5 h-6 bg-gradient-to-b from-green-400 to-green-600 rounded-full"></span>
                            Progression salariale annuelle
                        </h3>
                        <p class="text-xs text-slate-400 mt-1">Objectif: {{ number_format($salaireAnnuelEstime, 0, ',', ' ') }} FCFA/an</p>
                    </div>
                    <div class="flex items-center gap-3">
                        <span class="text-2xl font-bold text-white">{{ $progressionSalaireAnnuel }}%</span>
                        <span class="text-sm text-slate-400">atteint</span>
                    </div>
                </div>
                <div class="w-full bg-slate-700 rounded-full h-3">
                    <div class="bg-gradient-to-r from-green-500 to-emerald-500 h-3 rounded-full transition-all duration-1000"
                         style="width: {{ $progressionSalaireAnnuel }}%"></div>
                </div>
                <div class="flex justify-between mt-3 text-xs text-slate-500">
                    <span>{{ number_format($totalSalaire, 0, ',', ' ') }} FCFA perçus</span>
                    <span>{{ number_format($salaireAnnuelEstime - $totalSalaire, 0, ',', ' ') }} FCFA restants</span>
                </div>
            </div>
        </div>
    </div>
</main>

<!-- Scripts Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // 1. Graphique en barres - Évolution des salaires
    const ctx1 = document.getElementById('salaryChart').getContext('2d');
    new Chart(ctx1, {
        type: 'bar',
        data: {
            labels: {!! json_encode($moisLabels) !!},
            datasets: [{
                label: 'Salaire perçu',
                data: {!! json_encode($salaireData) !!},
                backgroundColor: 'rgba(59, 130, 246, 0.3)',
                borderColor: '#3b82f6',
                borderWidth: 2,
                borderRadius: 6,
                barPercentage: 0.7
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return context.raw.toLocaleString() + ' FCFA';
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: { color: 'rgba(148, 163, 184, 0.1)' },
                    ticks: {
                        color: '#94a3b8',
                        callback: function(value) {
                            return value.toLocaleString() + ' FCFA';
                        }
                    }
                },
                x: {
                    grid: { display: false },
                    ticks: { color: '#94a3b8' }
                }
            }
        }
    });

    // 2. Graphique circulaire - Statut des congés
    const ctx2 = document.getElementById('leaveChart').getContext('2d');
    new Chart(ctx2, {
        type: 'doughnut',
        data: {
            labels: ['Approuvé', 'En attente', 'Refusé'],
            datasets: [{
                data: [
                    {{ $statsConges['Approuvé'] }},
                    {{ $statsConges['En attente...'] }},
                    {{ $statsConges['Refusé'] }}
                ],
                backgroundColor: ['#10b981', '#f59e0b', '#ef4444'],
                borderWidth: 0,
                hoverOffset: 10
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '65%',
            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return context.label + ': ' + context.raw + ' demande(s)';
                        }
                    }
                }
            }
        }
    });

    // 3. Graphique en barres - Congés par mois
    const ctx3 = document.getElementById('monthlyLeaveChart').getContext('2d');
    new Chart(ctx3, {
        type: 'line',
        data: {
            labels: {!! json_encode($moisNoms) !!},
            datasets: [{
                label: 'Jours de congés',
                data: {!! json_encode($congesMoisData) !!},
                borderColor: '#10b981',
                backgroundColor: 'rgba(16, 185, 129, 0.1)',
                borderWidth: 3,
                pointBackgroundColor: '#10b981',
                pointBorderColor: '#fff',
                pointRadius: 4,
                pointHoverRadius: 6,
                tension: 0.4,
                fill: true
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return context.raw + ' jour(s)';
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: { color: 'rgba(148, 163, 184, 0.1)' },
                    ticks: {
                        color: '#94a3b8',
                        stepSize: 1
                    }
                },
                x: {
                    grid: { display: false },
                    ticks: { color: '#94a3b8' }
                }
            }
        }
    });

    // 4. Graphique circulaire - Salaires par année
    const ctx4 = document.getElementById('yearlySalaryChart').getContext('2d');
    new Chart(ctx4, {
        type: 'pie',
        data: {
            labels: {!! json_encode($anneeLabels) !!},
            datasets: [{
                data: {!! json_encode($anneeData) !!},
                backgroundColor: [
                    '#3b82f6',
                    '#8b5cf6',
                    '#ec4899',
                    '#f59e0b',
                    '#10b981'
                ],
                borderWidth: 0,
                hoverOffset: 10
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: { color: '#94a3b8' }
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            const value = context.raw;
                            const total = context.dataset.data.reduce((a, b) => a + b, 0);
                            const percentage = ((value / total) * 100).toFixed(1);
                            return context.label + ': ' + value.toLocaleString() + ' FCFA (' + percentage + '%)';
                        }
                    }
                }
            }
        }
    });
});
</script>

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