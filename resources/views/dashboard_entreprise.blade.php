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

                    <a href="{{ route('paiement.employe') }}" class="group flex items-center p-4 bg-slate-800/50 rounded-lg border border-slate-700/50 hover:border-green-400/30 hover:bg-slate-800/80 transition-all duration-200">
                        <div class="p-3 rounded-lg bg-green-500/10 group-hover:bg-green-500/20 transition-all duration-200">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0 1 15.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 0 1 3 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 0 0-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 0 1-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 0 0 3 15h-.75M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm3 0h.008v.008H18V10.5Zm-12 0h.008v.008H6V10.5Z" />
                            </svg>
                        </div>
                        <span class="ml-3 text-sm font-medium text-slate-200 group-hover:text-white">Gérer les salaires</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 ml-auto text-slate-400 group-hover:text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
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
                <canvas id="performanceChart" width="400" height="200"></canvas>
            </div>
        </div>
    </section>
</div>
</main>

@php
    $labelsString = $labels->join(',');  // "2023-01,2023-02,2023-03"
    $dataString = $data->join(',');      // "1000,2500,3000"
@endphp

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    
    const labels = "{{ $labelsString }}".split(',');
    const data = "{{ $dataString }}".split(',').map(Number);

    const ctx = document.getElementById('performanceChart').getContext('2d');
    const performanceChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Montant des transactions (par mois)',
                data: data,
                backgroundColor: '#60A5FA',  // vert clair transparent
                borderColor: '#60A5FA',  // vert lime
                borderWidth: 2,
                fill: true,
                tension: 0.3
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return value.toLocaleString('fr-FR') + ' FCFA';
                        }
                    }
                }
            }
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