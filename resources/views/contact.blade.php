<!DOCTYPE html>
<html lang="fr" class="overflow-x-hidden">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="images/management.png" type="image/x-icon">
    <title>Contact - Developpeur EM-Manager</title>
    <script src="https://cdn.tailwindcss.com"></script>
    @include('aos')
</head>
<body class="bg-gray-100 min-h-screen overflow-x-hidden overflow-x-clip">

    <!-- Barre de navigation : nav.blade.php -->
    @include('nav')

    <div class="container mx-auto px-4 mb-10 mt-11">
        <h1 class="text-4xl font-bold text-center text-gray-800 mb-8">Mes Réseaux</h1>
        <div class="grid gap-8 sm:grid-cols-1 md:grid-cols-3">
            <!-- Carte WhatsApp -->
            <div class="bg-white shadow-lg rounded-lg p-6 text-center" data-aos="fade-up-right" data-aos-duration="2000">
                <div class="text-slate-900 text-4xl mb-4">
                    <i class="fab fa-whatsapp"></i>
                </div>
                <h2 class="text-xl font-semibold text-gray-800">WhatsApp</h2>
                <p class="text-gray-600 mt-2">Contactez-nous rapidement via WhatsApp.</p>
                <a href="https://wa.me/2250140022693" 
                   class="mt-4 inline-block bg-slate-800 hover:bg-slate-950 text-white font-bold py-2 px-4 rounded transition duration-300"
                   target="_blank">
                   Ouvrir WhatsApp
                </a>
            </div>
            <!-- Carte GitHub -->
            <div class="bg-white shadow-lg rounded-lg p-6 text-center" data-aos="fade-up" data-aos-duration="2000">
                <div class="text-slate-900 text-4xl mb-4">
                    <i class="fab fa-github"></i>
                </div>
                <h2 class="text-xl font-semibold text-gray-800">GitHub</h2>
                <p class="text-gray-600 mt-2">Découvrez mes projets open-source.</p><br>
                <a href="https://github.com/Programmer-Emmanuel" 
                   class="mt-4 inline-block bg-slate-800 hover:bg-slate-950 text-white font-bold py-2 px-4 rounded transition duration-300"
                   target="_blank">
                   Voir mon GitHub
                </a>
            </div>
            <!-- Carte LinkedIn -->
            <div class="bg-white shadow-lg rounded-lg p-6 text-center" data-aos="fade-up-left" data-aos-duration="2000">
                <div class="text-slate-900 text-4xl mb-4">
                    <i class="fab fa-linkedin"></i>
                </div>
                <h2 class="text-xl font-semibold text-gray-800">LinkedIn</h2>
                <p class="text-gray-600 mt-2">Réseautons sur LinkedIn.</p><br>
                <a href="https://www.linkedin.com/in/emmanuel-bamidele-b63a49274" 
                   class="mt-4 inline-block bg-slate-800 hover:bg-slate-950 text-white font-bold py-2 px-4 rounded transition duration-300"
                   target="_blank">
                   Mon LinkedIn
                </a>
            </div>
        </div>
    </div>

        <!-- Footer -->
        @include('footer')

        <!-- Chargement de la page avec loading spinner -->
        @include('loading')

    <!-- Font Awesome Icons -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js"></script>
</body>
</html>
