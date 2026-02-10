<!DOCTYPE html>
<html lang="fr" class="overflow-x-hidden">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - EM-Manager</title>
    <link rel="shortcut icon" href="images/management.png" type="image/x-icon">
    @include('style')

    <!-- Animation AOS.js (optionnel) -->
    @include('aos')
</head>
<body class="bg-slate-100 h-screen items-center justify-center">

    <!-- Barre de navigation : nav.blade.php -->
    @include('nav')

    @if ($errors->any())
    <div class="mt-3 flex items-center justify-center z-50 mx-4">
        <div class="bg-slate-600 text-white p-4 rounded-lg mb-6 shadow-lg transition duration-300 ease-in-out transform max-w-lg w-full">
            <div class="flex justify-between items-center">
                <!-- Message d'erreur -->
                <div>
                    <strong class="font-bold">Erreur :</strong>
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                <!-- Bouton pour fermer l'alerte -->
                <button onclick="this.parentElement.parentElement.style.display='none'" class="text-white hover:text-gray-200 focus:outline-none">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        </div>
    </div>
@endif



    <section class="flex mx-auto justify-center py-6" data-aos="zoom-in" data-aos-duration="1500">
        <!-- Container Principal -->
        <div class="bg-slate-800 text-white p-8 rounded-xl shadow-lg w-full max-w-xl mx-4 sm:mx-[15px]">
            <!-- Titre -->
            <h1 class="text-3xl font-bold text-center mb-6">Connexion</h1>
            <p class="text-center text-slate-300 mb-8">Connectez-vous à votre compte EM-Manager.</p>

            <!-- Formulaire de connexion -->
            <form action="/login" method="POST" class="space-y-6">
                <!-- Ajout du CSRF token pour sécuriser la requête AJAX -->
                @csrf
                <!-- Matricule -->
                <div>
                    <label for="matricule" class="block text-sm font-medium text-slate-200 mb-2">Matricule</label>
                    <input type="text" id="matricule" name="matricule" required 
                        class="w-full px-4 py-2 rounded-lg bg-slate-700 border border-slate-600 placeholder-slate-400 focus:ring focus:ring-slate-500 focus:outline-none"
                        value="{{old('matricule')}}">
                </div>

                <!-- Mot de passe -->
                <div>
                    <label for="password" class="block text-sm font-medium text-slate-200 mb-2">Mot de passe</label>
                    <input type="password" id="password" name="password" required 
                        class="w-full px-4 py-2 rounded-lg bg-slate-700 border border-slate-600 placeholder-slate-400 focus:ring focus:ring-slate-500 focus:outline-none">
                </div><br>

                <!-- Bouton de connexion -->
                <div>
                    <button type="submit" 
                        class="w-full bg-slate-600 hover:bg-slate-700 text-white font-bold py-3 rounded-lg transition duration-300 ease-in-out">
                        Se connecter
                    </button>
                </div>
            </form>

            <!-- Lien vers l'inscription -->
            <p class="text-center text-sm text-slate-400 mt-6">
                Vous êtes une entreprise et vous n'avez pas de compte ? <a href="/register" class="text-slate-300 underline">Inscrivez-vous ici</a>
            </p>
        </div>
    </section>

    <!-- Footer -->
    @include('footer')

    <!-- Chargement de la page avec loading spinner -->
    @include('loading')
</body>
</html>
