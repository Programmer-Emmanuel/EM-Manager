@extends('dashboard_base')

@section('main')

    <main class="flex-1 p-8 bg-slate-900 text-white shadow-md overflow-hidden relative">
        <div class="absolute inset-0 overflow-y-auto hide-scroll p-5 ">
        <!-- Titre principal -->
        <header class="mb-8">
            <h1 class="text-2xl font-bold text-white">Bienvenue sur le tableau de bord <br><span class="text-red-200 text-lg">(Votre Matricule est indispensable pour vous connectez plus tard)*</span></h1>
            <p class="text-slate-400">Gérez efficacement votre entreprise avec les outils disponibles ci-dessous.</p>
        </header>

        <!-- Statistiques rapides -->
        <section class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="bg-slate-800 text-white p-6 rounded-lg shadow hover:bg-slate-700 transition">
                <h2 class="text-xl font-semibold">Employés</h2>
                <p class="text-3xl font-bold mt-2">{{$count_employe}}</p>
                <p class="text-sm text-slate-400">Total employés actifs</p>
            </div>

            <div class="bg-slate-800 text-white p-6 rounded-lg shadow hover:bg-slate-700 transition">
                <h2 class="text-xl font-semibold">Congés</h2>
                <p class="text-3xl font-bold mt-2">{{$count_conge}}</p>
                <p class="text-sm text-slate-400">Demandes en attente</p>
            </div>

            <div class="bg-slate-800 text-white p-6 rounded-lg shadow hover:bg-slate-700 transition">
                <h2 class="text-xl font-semibold">Présences</h2>
                <p class="text-3xl font-bold mt-2">87%</p>
                <p class="text-sm text-slate-400">Taux de présence global</p>
            </div>

            <div class="bg-slate-800 text-white p-6 rounded-lg shadow hover:bg-slate-700 transition">
                <h2 class="text-xl font-semibold">Performances</h2>
                <p class="text-3xl font-bold mt-2">8.5/10</p>
                <p class="text-sm text-slate-400">Moyenne des évaluations</p>
            </div>
        </section>

        <!-- Actions rapides -->
        <section class="mb-8">
            <h2 class="text-xl font-bold text-white mb-4">Actions rapides</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                <a href="{{ route('liste_employe')}}" class="flex items-center p-4 bg-slate-800 rounded-lg shadow hover:bg-slate-700 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87M12 11a4 4 0 100-8 4 4 0 000 8zm0 2c4.28 0 8 2.03 8 5v1H4v-1c0-2.97 3.72-5 8-5z" />
                    </svg>
                    <span class="ml-3 text-white">Gérer les employés</span>
                </a>

                <a href="{{ route('gestion_conge') }}" class="flex items-center p-4 bg-slate-800 rounded-lg shadow hover:bg-slate-700 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    <span class="ml-3 text-white">Gérer les congés</span>
                </a>
            </div>
        </section>


        <!-- Graphiques ou rapports -->
        <section>
            <h2 class="text-xl font-bold text-white mb-4">Rapports récents</h2>
            <div class="bg-slate-800 p-6 rounded-lg shadow">
                <canvas id="performanceChart"></canvas> <!-- Zone pour afficher le graphique -->
            </div>
        </section>
        </div>
    </main>

@endsection
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Attendre que la page soit prête
    document.addEventListener('DOMContentLoaded', function () {
    const ctx = document.getElementById('performanceChart').getContext('2d');

    // Dégradé de couleur pour un effet plus moderne
    const gradient = ctx.createLinearGradient(0, 0, 0, 400);
    gradient.addColorStop(0, 'rgba(75, 192, 192, 0.8)');
    gradient.addColorStop(1, 'rgba(75, 192, 192, 0.2)');

    const data = {
        labels: ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Juin', 'Juil', 'Août', 'Sept', 'Oct', 'Nov', 'Déc'],
        datasets: [{
            label: 'Performances des employés',
            data: [8, 7, 9, 8.5, 7.5, 8.2, 8, 7, 9, 8.5, 7.5, 9.2],
            backgroundColor: gradient, // Dégradé pour effet visuel
            borderColor: 'rgba(75, 192, 192, 1)',
            borderWidth: 2,
            pointBackgroundColor: 'white',
            pointBorderColor: 'rgba(75, 192, 192, 1)',
            pointBorderWidth: 2,
            pointRadius: 5, // Points visibles pour chaque valeur
            tension: 0.3 // Courbes plus fluides
        }]
    };

    const config = {
        type: 'line', // Utilisation d’un graphique en ligne pour un rendu plus fluide
        data: data,
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: true,
                    labels: {
                        color: 'white', // Texte blanc pour s’adapter au design sombre
                        font: {
                            size: 14
                        }
                    }
                },
                tooltip: {
                    backgroundColor: 'rgba(0, 0, 0, 0.7)',
                    titleColor: 'white',
                    bodyColor: 'white',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }
            },
            scales: {
                x: {
                    ticks: {
                        color: 'white'
                    },
                    grid: {
                        color: 'rgba(255, 255, 255, 0.2)'
                    }
                },
                y: {
                    beginAtZero: true,
                    max: 10,
                    ticks: {
                        color: 'white'
                    },
                    grid: {
                        color: 'rgba(255, 255, 255, 0.2)'
                    }
                }
            }
        }
    };

    new Chart(ctx, config);
});
</script>