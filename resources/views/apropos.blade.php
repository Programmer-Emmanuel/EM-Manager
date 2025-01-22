<!DOCTYPE html>
<html lang="fr" class="scroll-smooth overflow-x-hidden">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>À Propos - EM-Manager</title>
    <link rel="shortcut icon" href="images/management.png" type="image/x-icon">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>

        <!-- Aniation AOS.js -->
        @include('aos')
</head>
<body class="bg-slate-900 text-white overflow-x-hidden overflow-x-clip">
    <!-- Barre de navigation : nav.blade.php -->
    @include('nav')


    <header class="text-center bg-gradient-to-r from-slate-800 via-slate-600 to-slate-800 py-16 border-t-[1px] shadow-lg" data-aos="fade-up" data-aos-duration="2000">
        <h1 class="text-5xl font-extrabold text-white mb-4 tracking-tight">À Propos de EM-Manager</h1>
        <p class="text-lg text-white-200 mb-6">Une solution complète pour la gestion de vos employés et ressources humaines.</p>
        <a href="{{route('service')}}" class="inline-block py-2 px-6 bg-slate-800 text-white font-semibold rounded-lg hover:bg-slate-800 transition-colors">Découvrez nos services</a>
    </header>


    <section class="py-20" id="apropos">
        <div class="container mx-auto px-6">
            <div data-aos="fade-left" data-aos-duration="2000">
                <h2 class="text-3xl font-bold text-center mb-12 text-gray-100">Notre Mission</h2>
                <p class="text-lg text-gray-300 mb-8">Chez EM-Manager, nous nous engageons à fournir des solutions innovantes et simples pour améliorer la gestion de vos équipes et de vos processus RH. Notre objectif est d'aider les entreprises à optimiser leur gestion des employés, des congés, des paies, et plus encore, en offrant des outils intuitifs et performants.</p>
            </div>
            
            <div data-aos="fade-right" data-aos-duration="2000">
                <h2 class="text-3xl font-bold text-center mb-12 text-gray-100">Notre Vision</h2>
                <p class="text-lg text-gray-300 mb-8">Nous souhaitons devenir le leader en matière de solutions RH numériques, en permettant aux entreprises de se concentrer sur leur croissance tout en simplifiant les aspects administratifs liés aux ressources humaines.</p>
            </div>

            <div data-aos="fade-left" data-aos-duration="2000">
            <h2 class="text-3xl font-bold text-center mb-12 text-gray-100">Notre Équipe</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <div class="bg-slate-800 p-6 rounded-lg shadow-lg hover:shadow-xl transition-shadow duration-300 text-center">
                    <i class="fas fa-user-tie text-4xl text-slate-300 mb-4"></i>
                    <h3 class="text-xl font-semibold text-white">Emmanuel Bamidélé</h3>
                    <p class="text-gray-400">CEO et Fondateur</p>
                </div>
                <div class="bg-slate-800 p-6 rounded-lg shadow-lg hover:shadow-xl transition-shadow duration-300 text-center">
                    <i class="fas fa-users-cog text-4xl text-slate-300 mb-4"></i>
                    <h3 class="text-xl font-semibold text-white">Emmanuel Bamidélé</h3>
                    <p class="text-gray-400">Responsable Produit</p>
                </div>
                <div class="bg-slate-800 p-6 rounded-lg shadow-lg hover:shadow-xl transition-shadow duration-300 text-center">
                    <i class="fas fa-laptop-code text-4xl text-slate-300 mb-4"></i>
                    <h3 class="text-xl font-semibold text-white">Emmanuel Bamidélé</h3>
                    <p class="text-gray-400">Développeur</p>
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
