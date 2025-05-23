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
                <!-- Carte statistique - Version améliorée -->
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

                <!-- Autres cartes statistiques avec le même style -->
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

                <div class="bg-slate-800/60 backdrop-blur-sm p-5 rounded-xl border border-slate-700/50 hover:border-slate-600 transition-all duration-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-sm font-medium text-slate-300">Présences</h3>
                            <p class="text-2xl font-bold mt-1">87%</p>
                        </div>
                        <div class="p-3 rounded-lg bg-slate-700/30">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                    <p class="text-xs text-slate-400 mt-2">Taux de présence global</p>
                </div>

                <div class="bg-slate-800/60 backdrop-blur-sm p-5 rounded-xl border border-slate-700/50 hover:border-slate-600 transition-all duration-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-sm font-medium text-slate-300">Performances</h3>
                            <p class="text-2xl font-bold mt-1">8.5/10</p>
                        </div>
                        <div class="p-3 rounded-lg bg-slate-700/30">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-purple-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                            </svg>
                        </div>
                    </div>
                    <p class="text-xs text-slate-400 mt-2">Moyenne des évaluations</p>
                </div>
            </section>

            <!-- Actions rapides avec meilleure hiérarchie visuelle -->
            <section class="mb-8">
                <h2 class="text-lg font-semibold text-white mb-4 flex items-center">
                    <span class="w-1 h-5 bg-blue-500 rounded-full mr-2"></span>
                    Actions rapides
                </h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                    <a href="{{ route('liste_employe')}}" class="group flex items-center p-4 bg-slate-800/50 rounded-lg border border-slate-700/50 hover:border-blue-400/30 hover:bg-slate-800/80 transition-all duration-200">
                        <div class="p-3 rounded-lg bg-blue-500/10 group-hover:bg-blue-500/20 transition-all duration-200">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87M12 11a4 4 0 100-8 4 4 0 000 8zm0 2c4.28 0 8 2.03 8 5v1H4v-1c0-2.97 3.72-5 8-5z" />
                            </svg>
                        </div>
                        <span class="ml-3 text-sm font-medium text-slate-200 group-hover:text-white">Gérer les employés</span>
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
                        <span class="ml-3 text-sm font-medium text-slate-200 group-hover:text-white">Gérer les congés</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 ml-auto text-slate-400 group-hover:text-amber-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                </div>
            </section>

            <!-- Graphique avec style amélioré -->
            <section>
                <h2 class="text-lg font-semibold text-white mb-4 flex items-center">
                    <span class="w-1 h-5 bg-teal-500 rounded-full mr-2"></span>
                    Rapports de performance
                </h2>
                <div class="bg-slate-800/50 p-5 rounded-xl border border-slate-700/50">
                    <div class="h-80">
                        <canvas id="performanceChart"></canvas>
                    </div>
                </div>
            </section>
        </div>
    </main>

@endsection

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const ctx = document.getElementById('performanceChart').getContext('2d');
        
        // Dégradé amélioré avec transparence
        const gradient = ctx.createLinearGradient(0, 0, 0, 400);
        gradient.addColorStop(0, 'rgba(94, 234, 212, 0.3)');
        gradient.addColorStop(0.7, 'rgba(94, 234, 212, 0.1)');
        gradient.addColorStop(1, 'rgba(94, 234, 212, 0)');

        const data = {
            labels: ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Juin', 'Juil', 'Août', 'Sept', 'Oct', 'Nov', 'Déc'],
            datasets: [{
                label: 'Performance moyenne',
                data: [8, 7, 9, 8.5, 7.5, 8.2, 8, 7, 9, 8.5, 7.5, 9.2],
                fill: true,
                backgroundColor: gradient,
                borderColor: 'rgba(94, 234, 212, 0.8)',
                borderWidth: 2,
                pointBackgroundColor: 'rgba(94, 234, 212, 1)',
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                pointRadius: 5,
                pointHoverRadius: 7,
                tension: 0.3
            }]
        };

        const config = {
            type: 'line',
            data: data,
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top',
                        labels: {
                            color: 'rgba(255, 255, 255, 0.9)',
                            font: {
                                size: 13,
                                family: "'Inter', sans-serif"
                            },
                            padding: 20,
                            usePointStyle: true,
                            pointStyle: 'circle'
                        }
                    },
                    tooltip: {
                        backgroundColor: 'rgba(15, 23, 42, 0.95)',
                        titleColor: 'rgba(255, 255, 255, 0.9)',
                        bodyColor: 'rgba(255, 255, 255, 0.7)',
                        borderColor: 'rgba(255, 255, 255, 0.1)',
                        borderWidth: 1,
                        padding: 12,
                        usePointStyle: true,
                        callbacks: {
                            label: function(context) {
                                return context.parsed.y.toFixed(1) + '/10';
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        grid: {
                            color: 'rgba(255, 255, 255, 0.05)',
                            drawBorder: false
                        },
                        ticks: {
                            color: 'rgba(255, 255, 255, 0.6)'
                        }
                    },
                    y: {
                        beginAtZero: true,
                        max: 10,
                        grid: {
                            color: 'rgba(255, 255, 255, 0.05)',
                            drawBorder: false
                        },
                        ticks: {
                            color: 'rgba(255, 255, 255, 0.6)',
                            callback: function(value) {
                                return value + (value === 10 ? '' : '/10');
                            }
                        }
                    }
                },
                interaction: {
                    intersect: false,
                    mode: 'index'
                }
            }
        };

        new Chart(ctx, config);
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