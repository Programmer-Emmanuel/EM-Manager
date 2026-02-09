<!DOCTYPE html>
<html lang="fr" class="overflow-x-hidden">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription - EM-Manager</title>
    <link rel="shortcut icon" href="images/management.png" type="image/x-icon">
    @vite('resources/css/app.css')
            <!-- Aniation AOS.js -->
            @include('aos')
</head>
<body class="bg-slate-100 h-screen items-center justify-center">

        <!-- Barre de navigation : nav.blade.php -->
        @include('nav')

    <section class="flex mx-auto justify-center py-6" data-aos="zoom-in" data-aos-duration="1500">
        <!-- Container Principal -->
    <div class="bg-slate-800 text-white p-8 rounded-xl shadow-lg w-full max-w-xl mx-4 sm:mx-[15px]">
        <!-- Titre -->
        <h1 class="text-3xl font-bold text-center mb-6">Inscription</h1>
        <p class="text-center text-slate-300">Créez votre compte EM-Manager en quelques étapes.</p>
        <p class="text-center text-slate-300 mb-8">Cette page n’est reservée qu’à la création d’une entreprise.</p>

        <!-- Formulaire -->
        <form action="/register" method="POST" class="space-y-6">
    @csrf
    <!-- Nom de l'entreprise -->
    <div>
        <label for="nom-entreprise" class="block text-sm font-medium text-slate-200 mb-2">Nom de l'entreprise <span class="text-red-700 text-xxl">*</span></label>
        <input type="text" id="nom-entreprise" name="nom_entreprise" value="{{ old('nom_entreprise') }}"  
               class="w-full px-4 py-2 rounded-lg bg-slate-700 border border-slate-600 placeholder-slate-400 focus:ring focus:ring-slate-500 focus:outline-none">
        @error('nom_entreprise')
        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>

    <!-- Nom et prénom du directeur -->
    <div class="flex justify-between w-full gap-4">
        <div class="w-full md:w-1/2">
            <label for="nom-directeur" class="block text-sm font-medium text-slate-200 mb-2">Nom directeur <span class="text-red-700 text-xxl">*</span></label>
            <input type="text" id="nom-directeur" name="nom_directeur" value="{{ old('nom_directeur') }}"  
                   class="w-full px-4 py-2 rounded-lg bg-slate-700 border border-slate-600 placeholder-slate-400 focus:ring focus:ring-slate-500 focus:outline-none">
            @error('nom_directeur')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="w-full md:w-1/2">
            <label for="prenom-directeur" class="block text-sm font-medium text-slate-200 mb-2">Prénom directeur <span class="text-red-700 text-xxl">*</span></label>
            <input type="text" id="prenom-directeur" name="prenom_directeur" value="{{ old('prenom_directeur') }}"  
                   class="w-full px-4 py-2 rounded-lg bg-slate-700 border border-slate-600 placeholder-slate-400 focus:ring focus:ring-slate-500 focus:outline-none">
            @error('prenom_directeur')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>
    </div>
    <!-- Numero de l’entreprise -->
    <div>
        <label for="numero-entreprise" class="block text-sm font-medium text-slate-200 mb-2">Telephone de l'entreprise <span class="text-red-700 text-xxl">*</span></label>
        <input type="text" id="numero-entreprise" name="telephone" value="{{ old('telephone_entreprise') }}"  
               class="w-full px-4 py-2 rounded-lg bg-slate-700 border border-slate-600 placeholder-slate-400 focus:ring focus:ring-slate-500 focus:outline-none">
        @error('telephone')
        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>

    <!-- Email de l'entreprise -->
    <div>
        <label for="email-entreprise" class="block text-sm font-medium text-slate-200 mb-2">Email de l'entreprise <span class="text-red-700 text-xxl">*</span></label>
        <input type="email" id="email-entreprise" name="email_entreprise" value="{{ old('email_entreprise') }}"  
               class="w-full px-4 py-2 rounded-lg bg-slate-700 border border-slate-600 placeholder-slate-400 focus:ring focus:ring-slate-500 focus:outline-none">
        @error('email_entreprise')
        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>

    <!-- Mot de passe et confirmation -->
    <div class="flex justify-between w-full gap-4">
        <div class="w-full md:w-1/2">
            <label for="motDePasse-entreprise" class="block text-sm font-medium text-slate-200 mb-2">Mot de passe <span class="text-red-700 text-xxl">*</span></label>
            <input type="password" id="motDePasse-entreprise" name="motDePasse_entreprise"  
                   class="w-full px-4 py-2 rounded-lg bg-slate-700 border border-slate-600 placeholder-slate-400 focus:ring focus:ring-slate-500 focus:outline-none">
            @error('motDePasse_entreprise')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="w-full md:w-1/2">
            <label for="confirmation_password" class="block text-sm font-medium text-slate-200 mb-2">Confirmation MDP <span class="text-red-700 text-xxl">*</span></label>
            <input type="password" id="confirmation_password" name="confirmation_password"  
                   class="w-full px-4 py-2 rounded-lg bg-slate-700 border border-slate-600 placeholder-slate-400 focus:ring focus:ring-slate-500 focus:outline-none">
            @error('confirmation_password')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <!-- Bouton d'inscription -->
    <div>
        <button type="submit" class="w-full bg-slate-600 hover:bg-slate-700 text-white font-bold py-3 rounded-lg transition duration-300 ease-in-out">
            S'inscrire
        </button>
    </div>
</form>


        <!-- Lien vers la connexion -->
        <p class="text-center text-sm text-slate-400 mt-6">
            Vous avez déjà un compte ? <a href="{{route('login')}}" class="text-slate-300 underline">Connectez-vous ici</a>
        </p>
    </div>
    </section>

        <!-- Footer -->
        @include('footer')

        <!-- Chargement de la page avec loading spinner -->
        @include('loading')
</body>
</html>
