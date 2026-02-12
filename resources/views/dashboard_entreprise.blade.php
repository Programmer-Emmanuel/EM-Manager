@extends('dashboard_base')

@section('main')
<main class="flex-1 p-6 bg-slate-900 text-white overflow-hidden relative">
    <div class="absolute inset-0 overflow-y-auto hide-scrollbar px-4 py-6">
        <!-- En-tête amélioré avec espacement plus équilibré -->
        <header class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-white tracking-tight">Bienvenue sur le tableau de bord</h1>
                    <p class="text-slate-400 mt-1">Gérez efficacement votre entreprise avec les outils disponibles</p>
                </div>
                <span class="text-sm bg-slate-800/50 text-red-200 px-3 py-1 rounded-full">* Votre matricule est indispensable pour vous connecter</span>
            </div>
        </header>

        <!-- Statistiques avec design plus cohérent -->
        <section class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">
            <!-- Carte statistique - Employés -->
            <div class="bg-slate-800/60 backdrop-blur-sm p-5 rounded-xl border border-slate-700/50 hover:border-slate-600 transition-all duration-200">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-sm font-medium text-slate-300">Employés</h3>
                        <p class="text-2xl font-bold mt-1">{{$count_employe}}</p>
                    </div>
                    <div class="p-3 rounded-lg bg-slate-700/30">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87M12 11a4 4 0 100-8 4 4 0 000 8zm0 2c4.28 0 8 2.03 8 5v1H4v-1c0-2.97 3.72-5 8-5z" />
                        </svg>
                    </div>
                </div>
                <p class="text-xs text-slate-400 mt-2">Total employés actifs</p>
            </div>

            <!-- Carte statistique - Congés -->
            <div class="bg-slate-800/60 backdrop-blur-sm p-5 rounded-xl border border-slate-700/50 hover:border-slate-600 transition-all duration-200">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-sm font-medium text-slate-300">Congés</h3>
                        <p class="text-2xl font-bold mt-1">{{$count_conge}}</p>
                    </div>
                    <div class="p-3 rounded-lg bg-slate-700/30">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-amber-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                </div>
                <p class="text-xs text-slate-400 mt-2">Demandes en attente</p>
            </div>

            <!-- Carte statistique - PRODUITS (remplace Présences) -->
            <div class="bg-slate-800/60 backdrop-blur-sm p-5 rounded-xl border border-slate-700/50 hover:border-slate-600 transition-all duration-200">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-sm font-medium text-slate-300">Produits</h3>
                        <p class="text-2xl font-bold mt-1">{{$count_produits ?? 0}}</p>
                    </div>
                    <div class="p-3 rounded-lg bg-slate-700/30">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-purple-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20.25 6.375c0 2.278-3.694 4.125-8.25 4.125S3.75 8.653 3.75 6.375 7.444 2.25 12 2.25s8.25 1.847 8.25 4.125Zm0 4.5c0 2.278-3.694 4.125-8.25 4.125S3.75 13.153 3.75 10.875m16.5 0c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125m16.5 4.5c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125" />
                        </svg>
                    </div>
                </div>
                <p class="text-xs text-slate-400 mt-2">Total produits catalogue</p>
            </div>

            <!-- Carte statistique - COMPTE (remplace Performances) avec œil pour masquer -->
            <div class="bg-slate-800/60 backdrop-blur-sm p-5 rounded-xl border border-slate-700/50 hover:border-slate-600 transition-all duration-200">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-sm font-medium text-slate-300">Compte</h3>
                        <div class="flex items-center gap-2 mt-1">
                            <p id="soldeDisplay" class="text-2xl font-bold text-white">••••••••</p>
                            <button id="toggleSolde" class="p-1.5 rounded-lg hover:bg-slate-700/50 transition-all">
                                <i id="soldeEyeIcon" class="fas fa-eye-slash text-slate-400 hover:text-white text-sm"></i>
                            </button>
                        </div>
                    </div>
                    <div class="p-3 rounded-lg bg-slate-700/30">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.25 18.75a60.07 60.07 0 0 1 15.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 0 1 3 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 0 0-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 0 1-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 0 0 3 15h-.75" />
                        </svg>
                    </div>
                </div>
                <p class="text-xs text-slate-400 mt-2">Solde disponible</p>
            </div>
        </section>

        <!-- Actions rapides avec meilleure hiérarchie visuelle -->
        <section class="mb-8">
            <h2 class="text-lg font-semibold text-white mb-4 flex items-center">
                <span class="w-1 h-5 bg-blue-500 rounded-full mr-2"></span>
                Actions rapides
            </h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <a href="{{ route('liste_employe')}}" class="group flex items-center p-4 bg-slate-800/50 rounded-lg border border-slate-700/50 hover:border-blue-400/30 hover:bg-slate-800/80 transition-all duration-200">
                    <div class="p-3 rounded-lg bg-blue-500/10 group-hover:bg-blue-500/20 transition-all duration-200">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87M12 11a4 4 0 100-8 4 4 0 000 8zm0 2c4.28 0 8 2.03 8 5v1H4v-1c0-2.97 3.72-5 8-5z" />
                        </svg>
                    </div>
                    <span class="ml-3 text-sm font-medium text-slate-200 group-hover:text-white">Employés</span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 ml-auto text-slate-400 group-hover:text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </a>

                <a href="{{ route('gestion_conge') }}" class="group flex items-center p-4 bg-slate-800/50 rounded-lg border border-slate-700/50 hover:border-amber-400/30 hover:bg-slate-800/80 transition-all duration-200">
                    <div class="p-3 rounded-lg bg-amber-500/10 group-hover:bg-amber-500/20 transition-all duration-200">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-amber-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <span class="ml-3 text-sm font-medium text-slate-200 group-hover:text-white">Congés</span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 ml-auto text-slate-400 group-hover:text-amber-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </a>

                <a href="{{ route('liste_produits') }}" class="group flex items-center p-4 bg-slate-800/50 rounded-lg border border-slate-700/50 hover:border-purple-400/30 hover:bg-slate-800/80 transition-all duration-200">
                    <div class="p-3 rounded-lg bg-purple-500/10 group-hover:bg-purple-500/20 transition-all duration-200">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-purple-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20.25 6.375c0 2.278-3.694 4.125-8.25 4.125S3.75 8.653 3.75 6.375 7.444 2.25 12 2.25s8.25 1.847 8.25 4.125Zm0 4.5c0 2.278-3.694 4.125-8.25 4.125S3.75 13.153 3.75 10.875m16.5 0c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125m16.5 4.5c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125" />
                        </svg>
                    </div>
                    <span class="ml-3 text-sm font-medium text-slate-200 group-hover:text-white">Produits</span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 ml-auto text-slate-400 group-hover:text-purple-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </a>

                <a href="{{ route('paiement.employe') }}" class="group flex items-center p-4 bg-slate-800/50 rounded-lg border border-slate-700/50 hover:border-emerald-400/30 hover:bg-slate-800/80 transition-all duration-200">
                    <div class="p-3 rounded-lg bg-emerald-500/10 group-hover:bg-emerald-500/20 transition-all duration-200">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-emerald-400">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0 1 15.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 0 1 3 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 0 0-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 0 1-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 0 0 3 15h-.75" />
                        </svg>
                    </div>
                    <span class="ml-3 text-sm font-medium text-slate-200 group-hover:text-white">Salaires</span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 ml-auto text-slate-400 group-hover:text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </a>
            </div>
        </section>

        <!-- Section Graphiques - 2 graphiques côte à côte -->
        <section class="mb-8" id="performanceChart">
            <h2 class="text-lg font-semibold text-white mb-4 flex items-center">
                <span class="w-1 h-5 bg-teal-500 rounded-full mr-2"></span>
                Statistiques financières
            </h2>
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Graphique en barres - Transactions par mois -->
                <div class="bg-slate-800/50 p-5 rounded-xl border border-slate-700/50 hover:border-teal-500/30 transition-all duration-300">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-sm font-medium text-white flex items-center gap-2">
                            <span class="w-1.5 h-4 bg-teal-400 rounded-full"></span>
                            Évolution des transactions
                        </h3>
                        <span class="text-xs text-slate-400">Montants en FCFA</span>
                    </div>
                    <div class="h-64">
                        <canvas id="barChart"></canvas>
                    </div>
                </div>

                <!-- Graphique circulaire - Répartition des transactions -->
                <div class="bg-slate-800/50 p-5 rounded-xl border border-slate-700/50 hover:border-purple-500/30 transition-all duration-300">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-sm font-medium text-white flex items-center gap-2">
                            <span class="w-1.5 h-4 bg-purple-400 rounded-full"></span>
                            Répartition des transactions
                        </h3>
                        <span class="text-xs text-slate-400">Par type</span>
                    </div>
                    <div class="h-64 flex items-center justify-center">
                        <canvas id="pieChart"></canvas>
                    </div>
                </div>
            </div>
        </section>
    </div>
</main>

@php
    $labelsString = $labels->join(',');
    $dataString = $data->join(',');
@endphp

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // ===== 1. GRAPHIQUE EN BARRES =====
        const labels = "{{ $labelsString }}".split(',');
        const data = "{{ $dataString }}".split(',').map(Number);

        const ctxBar = document.getElementById('barChart').getContext('2d');
        new Chart(ctxBar, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Montant des transactions',
                    data: data,
                    backgroundColor: 'rgba(20, 184, 166, 0.3)',
                    borderColor: '#14b8a6',
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
                                return context.raw.toLocaleString('fr-FR') + ' FCFA';
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
                                return value.toLocaleString('fr-FR') + ' FCFA';
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

        // ===== 2. GRAPHIQUE CIRCULAIRE =====
        const ctxPie = document.getElementById('pieChart').getContext('2d');
        
        // Données pour le graphique circulaire
        const pieLabels = ['Entrées', 'Sorties', 'Autres'];
        const pieData = [
            {{ $totalEntrees ?? 0 }},
            {{ $totalSorties ?? 0 }},
            {{ $totalAutres ?? 0 }}
        ];
        
        new Chart(ctxPie, {
            type: 'doughnut',
            data: {
                labels: pieLabels,
                datasets: [{
                    data: pieData,
                    backgroundColor: ['#10b981', '#ef4444', '#94a3b8'],
                    borderWidth: 0,
                    hoverOffset: 10
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '65%',
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: { color: '#94a3b8', font: { size: 12 } }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                const value = context.raw;
                                const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                const percentage = total > 0 ? ((value / total) * 100).toFixed(1) : 0;
                                return `${context.label}: ${value.toLocaleString('fr-FR')} FCFA (${percentage}%)`;
                            }
                        }
                    }
                }
            }
        });

        // ===== 3. SYSTÈME D'OEIL POUR LE SOLDE =====
        const soldeDisplay = document.getElementById('soldeDisplay');
        const toggleSolde = document.getElementById('toggleSolde');
        const soldeEyeIcon = document.getElementById('soldeEyeIcon');
        
        // Solde réel à afficher (à passer depuis le controller)
        const soldeReel = "{{ number_format($soldeCompte ?? 0, 0, ',', ' ') }}";
        let isSoldeHidden = true;
        
        if (toggleSolde) {
            toggleSolde.addEventListener('click', function() {
                if (isSoldeHidden) {
                    // Afficher le solde
                    soldeDisplay.textContent = soldeReel;
                    soldeEyeIcon.classList.remove('fa-eye-slash');
                    soldeEyeIcon.classList.add('fa-eye');
                    soldeEyeIcon.classList.add('text-emerald-400');
                } else {
                    // Masquer le solde
                    soldeDisplay.textContent = '••••••••';
                    soldeEyeIcon.classList.remove('fa-eye');
                    soldeEyeIcon.classList.add('fa-eye-slash');
                    soldeEyeIcon.classList.remove('text-emerald-400');
                }
                isSoldeHidden = !isSoldeHidden;
            });
        }
    });
</script>

<style>
    .hide-scrollbar::-webkit-scrollbar {
        display: none;
    }
    .hide-scrollbar {
        -ms-overflow-style: none;
        scrollbar-width: none;
    }
</style>
@endsection