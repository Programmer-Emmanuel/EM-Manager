<!DOCTYPE html>
<html lang="fr" class="scroll-smooth overflow-x-hidden">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nos Services - EM-Manager</title>
    <link rel="shortcut icon" href="images/management.png" type="image/x-icon">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Aniation AOS.js -->
    @include('aos')
</head>
<body class="bg-white-900 text-white overflow-x-hidden overflow-x-clip">
    <!-- Barre de navigation : nav.blade.php -->
    @include('nav')


    <header class="text-center bg-gradient-to-r from-slate-800 via-slate-600 to-slate-800 py-16 border-t-[1px] shadow-lg" data-aos="fade-up" data-aos-duration="2000">
    <h1 class="text-5xl font-extrabold text-white mb-4 tracking-tight">Nos Services</h1>
    <p class="text-lg text-white-200 mb-6">Des outils performants pour une gestion simplifiée et efficace de vos employés.</p>
    <div class="flex justify-center gap-5 mt-9 px-3">
        <a href="{{route('dashboard_entreprise')}}" class="inline-block py-2 px-6 bg-slate-800 text-white font-semibold rounded-lg hover:bg-slate-900 transition-colors">Gérer mon entreprise</a>
        <a href="{{route('employe_dashboard')}}" class="inline-block py-2 px-6 bg-white text-slate-800 font-semibold rounded-lg hover:bg-slate-200 transition-colors">Consultez ma page employé</a>
    </div>
</header>




<section class="py-20" id="services">
    <div class="container mx-auto px-6">
        <h2 class="text-3xl font-bold text-center mb-12 text-slate-900">Les Services Clés De Notre Application</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">

            <div class="bg-slate-700 p-6 rounded-lg shadow-lg hover:shadow-xl transition-shadow duration-300 flex flex-col justify-around">
                <div class="text-center mb-4">
                    <i class="fas fa-users text-4xl text-slate-300"></i>
                </div>
                <h3 class="text-xl font-semibold text-white mb-4">Gestion des employés</h3>
                <ul class="list-disc list-inside text-gray-400 mb-6">
                    <li>Ajouter, modifier ou supprimer des profils d’employés.</li>
                    <li>Stocker des informations détaillées : nom, poste, etc.</li>
                </ul>
                <a href="{{route('dashboard_entreprise')}}" class="bg-white hover:bg-slate-600 text-slate-600 hover:text-white font-bold py-2 px-4 rounded-lg self-start transition duration-300">Commencer</a>
            </div>


            <div class="bg-slate-700 p-6 rounded-lg shadow-lg hover:shadow-xl transition-shadow duration-300 flex flex-col justify-between">
                <div class="text-center mb-4">
                    <i class="fas fa-calendar-day text-4xl text-slate-300"></i>
                </div>
                <h3 class="text-xl font-semibold text-white mb-4">Gestion des congés</h3>
                <ul class="list-disc list-inside text-gray-400 mb-6">
                    <li>Système de demande de congés pour les employés.</li>
                    <li>Calcul automatique du solde des congés.</li>
                </ul>
                <a href="{{route('dashboard_entreprise')}}" class="bg-white hover:bg-slate-600 text-slate-600 hover:text-white font-bold py-2 px-4 rounded-lg self-start transition duration-300">Commencer</a>
            </div>


            <div class="bg-slate-700 p-6 rounded-lg shadow-lg hover:shadow-xl transition-shadow duration-300 flex flex-col justify-between">
                <div class="text-center mb-4">
                    <i class="fas fa-clock text-4xl text-slate-300"></i>
                </div>
                <h3 class="text-xl font-semibold text-white mb-4">Suivi des temps et présences</h3>
                <ul class="list-disc list-inside text-gray-400 mb-6">
                    <li>Intégration avec une pointeuse ou saisie manuelle des horaires.</li>
                    <li>Rapport mensuel des heures travaillées.</li>
                </ul>
                <a href="{{route('dashboard_entreprise')}}" class="bg-white hover:bg-slate-600 text-slate-600 hover:text-white font-bold py-2 px-4 rounded-lg self-start transition duration-300">Commencer</a>
            </div>


            <div class="bg-slate-700 p-6 rounded-lg shadow-lg hover:shadow-xl transition-shadow duration-300 flex flex-col justify-between">
                <div class="text-center mb-4">
                    <i class="fas fa-money-bill-wave text-4xl text-slate-300"></i>
                </div>
                <h3 class="text-xl font-semibold text-white mb-4">Traitement des paies</h3>
                <ul class="list-disc list-inside text-gray-400 mb-6">
                    <li>Génération automatique des bulletins de salaire.</li>
                    <li>Export des fichiers de paie en PDF ou Excel.</li>
                </ul>
                <a href="{{route('dashboard_entreprise')}}" class="bg-white hover:bg-slate-600 text-slate-600 hover:text-white font-bold py-2 px-4 rounded-lg self-start transition duration-300">Commencer</a>
            </div>


            <div class="bg-slate-700 p-6 rounded-lg shadow-lg hover:shadow-xl transition-shadow duration-300 flex flex-col justify-between">
                <div class="text-center mb-4">
                    <i class="fas fa-star-half-alt text-4xl text-slate-300"></i>
                </div>
                <h3 class="text-xl font-semibold text-white mb-4">Évaluations de performance</h3>
                <ul class="list-disc list-inside text-gray-400 mb-6">
                    <li>Système d’évaluation annuel ou trimestriel.</li>
                    <li>Rapports sur les objectifs atteints.</li>
                </ul>
                <a href="{{route('dashboard_entreprise')}}" class="bg-white hover:bg-slate-600 text-slate-600 hover:text-white font-bold py-2 px-4 rounded-lg self-start transition duration-300">Commencer</a>
            </div>


            <div class="bg-slate-700 p-6 rounded-lg shadow-lg hover:shadow-xl transition-shadow duration-300 flex flex-col justify-between">
                <div class="text-center mb-4">
                    <i class="fas fa-chart-line text-4xl text-slate-300"></i>
                </div>
                <h3 class="text-xl font-semibold text-white mb-4">Tableaux analytiques</h3>
                <ul class="list-disc list-inside text-gray-400 mb-6">
                    <li>Rapports graphiques pour visualiser les données.</li>
                    <li>Indicateurs stratégiques pour la direction.</li>
                </ul>
                <a href="{{route('dashboard_entreprise')}}" class="bg-white hover:bg-slate-600 text-slate-600 hover:text-white font-bold py-2 px-4 rounded-lg self-start transition duration-300">Commencer</a>
            </div>
        </div>
    </div>
</section>


    <!-- Footer -->
    @include('footer')

    <!-- Chargement de la page avec loading spinner -->
    @include('loading')
</body>
</html>
