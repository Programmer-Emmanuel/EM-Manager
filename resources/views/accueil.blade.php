<!DOCTYPE html>
<html lang="fr" class="scroll-smooth overflow-x-hidden">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil- EM-Manager</title>
    <link rel="shortcut icon" href="images/management.png" type="image/x-icon">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
        <!-- Aniation AOS.js -->
        @include('aos')
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-900 overflow-x-hidden overflow-x-clip">
    <!-- Barre de navigation : nav.blade.php -->
    @include('nav')

    <header class="flex flex-col md:flex-row items-center justify-between p-8 bg-gray-100 gap-3">
        <div class="w-full md:w-2/5 mb-8 md:mb-0" data-aos="fade-right" data-aos-duration="2000">
            <img src="/images/accueil.jpeg" alt="Erreur" class="w-full h-auto max-w-[400px] mx-auto rounded-lg shadow-lg">
        </div>

        <div class="w-full md:w-3/5 text-center md:text-left" data-aos="fade-left" data-aos-duration="2000">
            <h1 class="text-4xl font-bold text-gray-800 mb-4">Bienvenue sur EM-Manager.</h1>
            <p class="text-lg text-gray-600 mb-6">Une solution complète pour la gestion de vos employés. EM-Manager vous aide à suivre les horaires, la performance et la gestion des tâches, tout en optimisant la productivité et en améliorant la communication au sein de votre entreprise.</p>
            <p class="text-gray-500 mb-6">Nos outils vous permettent de planifier les plannings, suivre les congés et absences, gérer les évaluations de performance et recevoir des alertes pour les actions à entreprendre concernant vos employés.</p>
            <a href="{{route('service')}}" class="bg-slate-800 hover:bg-slate-900 text-white font-bold py-3 px-6 rounded-lg transition duration-300 ease-in-out">Découvrez nos services</a>
        </div>
    </header>

<!-- Section Fonctionnalités -->
<section class="py-20 bg-gray-200 border-t-[5px] border-gray-600">
    <div class="container mx-auto text-center px-6">
        <h2 class="text-3xl font-bold text-gray-800 mb-8">Nos Fonctionnalités</h2>
        <div class="flex flex-col md:flex-row justify-center items-center gap-8 md:gap-10">

            <div class="bg-white p-6 rounded-lg shadow-lg max-w-xs w-full" data-aos="fade-up-right" data-aos-duration="2000">
                <h3 class="text-xl font-semibold text-gray-800 mb-4">Gestion des Plannings</h3>
                <p class="text-gray-600 mb-4">Organisez et suivez facilement les horaires de vos employés pour une gestion efficace du temps et une meilleure planification.</p><br>
                <a href="{{route('service')}}" class="text-gray-950 hover:text-gray-990 underline">En savoir plus</a>
            </div>

            <div class="bg-white p-6 rounded-lg shadow-lg max-w-xs w-full" data-aos="fade-up" data-aos-duration="2000">
                <h3 class="text-xl font-semibold text-gray-800 mb-4">Suivi des Congés & Absences</h3>
                <p class="text-gray-600 mb-4">Gardez un œil sur les congés et absences de vos employés pour garantir une gestion fluide et sans accroc de vos équipes.</p>
                <a href="{{route('service')}}" class="text-gray-950 hover:text-gray-990 underline">En savoir plus</a>
            </div>

            <div class="bg-white p-6 rounded-lg shadow-lg max-w-xs w-full" data-aos="fade-up-left" data-aos-duration="2000">
                <h3 class="text-xl font-semibold text-gray-800 mb-4">Évaluations de Performance</h3>
                <p class="text-gray-600 mb-4">Suivez et évaluez les performances de vos employés pour aider leur développement et améliorer les résultats de votre entreprise.</p>
                <a href="{{route('service')}}" class="text-gray-950 hover:text-gray-990 underline">En savoir plus</a>
            </div>
        </div>
    </div>
</section>



    <!-- Section Témoignages -->
    <section class="py-20 bg-slate-800 text-white">
    <div class="container mx-auto text-center">
    <h2 class="text-3xl font-bold mb-8">★ Avis de nos clients ★</h2>
        <div class="flex flex-wrap justify-center gap-8">

            <div class="bg-white text-gray-800 p-6 rounded-lg shadow-lg max-w-xs w-full" data-aos="fade-up-right" data-aos-duration="2000">
                <div class="flex items-center mb-4 flex-col">
                    <i class="fas fa-user-circle text-4xl text-slate-800 mr-4"></i>
                    <div>
                        <p class="italic mb-2">"EM-Manager a transformé la façon dont nous gérons nos employés. La planification est maintenant plus simple et plus efficace."</p>
                        <span class="mb-3" style=" background: linear-gradient(45deg, #FFD700, #FFAA00); background-clip: text; -webkit-background-clip: text; -webkit-text-fill-color: transparent; display: inline-block;">★★★★★</span>
                        <p class="font-semibold">Jean Dupont</p>
                        <p class="text-gray-500">Directeur RH</p>
                    </div>
                </div>
            </div>

            <div class="bg-white text-gray-800 p-6 rounded-lg shadow-lg max-w-xs w-full" data-aos="fade-up" data-aos-duration="2000">
                <div class="flex items-center mb-4 flex-col">
                    <i class="fas fa-user-circle text-4xl text-slate-800 mr-4"></i>
                    <div>
                        <p class="italic mb-2">"Grâce à EM-Manager, nous avons réduit les erreurs de planification et amélioré la performance de notre équipe."</p>
                        <span class="mb-3" style=" background: linear-gradient(45deg, #FFD700, #FFAA00); background-clip: text; -webkit-background-clip: text; -webkit-text-fill-color: transparent; display: inline-block;">★★★★</span>
                        <p class="font-semibold">Marie Lefevre</p>
                        <p class="text-gray-500">Responsable d'équipe</p>
                    </div>
                </div>
            </div>

            <div class="bg-white text-gray-800 p-6 rounded-lg shadow-lg max-w-xs w-full" data-aos="fade-up-left" data-aos-duration="2000">
                <div class="flex items-center mb-4 flex-col">
                    <i class="fas fa-user-circle text-4xl text-slate-800 mr-4"></i>
                    <div>
                        <p class="italic mb-2">"Une solution idéale pour une gestion fluide des ressources humaines et une meilleure coordination au sein de notre équipe."</p>
                        <span class="mb-3" style=" background: linear-gradient(45deg, #FFD700, #FFAA00); background-clip: text; -webkit-background-clip: text; -webkit-text-fill-color: transparent; display: inline-block;">★★★★★</span>
                        <p class="font-semibold">Pierre Martin</p>
                        <p class="text-gray-500">Chef de projet</p>
                    </div>
                </div>
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
