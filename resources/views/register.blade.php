<!DOCTYPE html>
<html lang="fr" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription - EM-Manager</title>
    <link rel="shortcut icon" href="images/management.png" type="image/x-icon">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    @include('style')
    @include('aos')
    
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');
        
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 100%);
            color: #f8fafc;
        }
        
        .register-container {
            background: rgba(30, 41, 59, 0.6);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(99, 102, 241, 0.2);
            border-radius: 1.5rem;
        }
        
        .section-badge {
            display: inline-block;
            padding: 0.5rem 1rem;
            background: rgba(99, 102, 241, 0.1);
            border: 1px solid rgba(99, 102, 241, 0.3);
            border-radius: 2rem;
            font-size: 0.75rem;
            font-weight: 500;
            color: #818cf8;
            margin-bottom: 1rem;
        }
        
        .gradient-text {
            background: linear-gradient(135deg, #6366f1, #8b5cf6, #a855f7);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }
        
        .form-input {
            background: rgba(15, 23, 42, 0.6);
            border: 1px solid rgba(99, 102, 241, 0.2);
            transition: all 0.3s ease;
        }
        
        .form-input:focus {
            border-color: #6366f1;
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.2);
            outline: none;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            transition: all 0.3s ease;
        }
        
        .btn-primary:hover:not(:disabled) {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px -5px rgba(99, 102, 241, 0.4);
        }
        
        .btn-primary:active:not(:disabled) {
            transform: translateY(0);
        }
        
        .input-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #818cf8;
            font-size: 1rem;
        }
        
        .input-field {
            padding-left: 2.5rem;
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }
        
        .float-animation {
            animation: float 6s ease-in-out infinite;
        }
    </style>
</head>
<body class="antialiased overflow-x-hidden">

    <!-- Navigation -->
    @include('nav')

    <!-- Section Inscription -->
    <section class="min-h-screen flex items-center justify-center py-20 px-4 relative overflow-hidden">
        <!-- Éléments décoratifs -->
        <div class="absolute top-20 left-10 w-72 h-72 bg-indigo-500 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-pulse"></div>
        <div class="absolute bottom-20 right-10 w-96 h-96 bg-purple-500 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-pulse" style="animation-delay: 2s;"></div>
        
        <div class="w-full max-w-2xl mx-auto relative z-10" data-aos="fade-up" data-aos-duration="800">
            <!-- Container Principal -->
            <div class="register-container p-6 md:p-8">
                <!-- En-tête -->
                <div class="text-center mb-8">
                    <div class="flex justify-center mb-4">
                        <div class="w-16 h-16 rounded-xl bg-indigo-500/20 flex items-center justify-center">
                            <i class="fas fa-building text-3xl text-indigo-400"></i>
                        </div>
                    </div>
                    <h1 class="text-3xl md:text-4xl font-bold text-white mb-2">
                        Créer un <span class="gradient-text">compte entreprise</span>
                    </h1>
                    <p class="text-slate-400">
                        Rejoignez EM-Manager et simplifiez votre gestion RH
                    </p>
                </div>

                <!-- Formulaire -->
                <form id="formRegister" action="/register" method="POST" class="space-y-5">
                    @csrf

                    <!-- Nom de l'entreprise -->
                    <div>
                        <label for="nom-entreprise" class="block text-sm font-medium text-slate-300 mb-2">
                            <i class="fas fa-building mr-2 text-indigo-400 text-xs"></i>Nom de l'entreprise
                            <span class="text-red-400">*</span>
                        </label>
                        <div class="relative">
                            <i class="fas fa-building absolute left-3 top-1/2 transform -translate-y-1/2 text-indigo-400 text-sm"></i>
                            <input type="text" id="nom-entreprise" name="nom_entreprise" value="{{ old('nom_entreprise') }}" 
                                   placeholder="Ex: Entreprise SARL"
                                   class="form-input w-full px-4 py-3 pl-10 rounded-xl text-white placeholder-slate-500 focus:outline-none">
                        </div>
                        @error('nom_entreprise')
                        <p class="text-red-400 text-sm mt-1"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Nom et prénom du directeur -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label for="nom-directeur" class="block text-sm font-medium text-slate-300 mb-2">
                                <i class="fas fa-user mr-2 text-indigo-400 text-xs"></i>Nom du directeur
                                <span class="text-red-400">*</span>
                            </label>
                            <div class="relative">
                                <i class="fas fa-user absolute left-3 top-1/2 transform -translate-y-1/2 text-indigo-400 text-sm"></i>
                                <input type="text" id="nom-directeur" name="nom_directeur" value="{{ old('nom_directeur') }}" 
                                       placeholder="Dupont"
                                       class="form-input w-full px-4 py-3 pl-10 rounded-xl text-white placeholder-slate-500 focus:outline-none">
                            </div>
                            @error('nom_directeur')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="prenom-directeur" class="block text-sm font-medium text-slate-300 mb-2">
                                <i class="fas fa-user mr-2 text-indigo-400 text-xs"></i>Prénom du directeur
                                <span class="text-red-400">*</span>
                            </label>
                            <div class="relative">
                                <i class="fas fa-user absolute left-3 top-1/2 transform -translate-y-1/2 text-indigo-400 text-sm"></i>
                                <input type="text" id="prenom-directeur" name="prenom_directeur" value="{{ old('prenom_directeur') }}" 
                                       placeholder="Jean"
                                       class="form-input w-full px-4 py-3 pl-10 rounded-xl text-white placeholder-slate-500 focus:outline-none">
                            </div>
                            @error('prenom_directeur')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Téléphone -->
                    <div>
                        <label for="numero-entreprise" class="block text-sm font-medium text-slate-300 mb-2">
                            <i class="fas fa-phone mr-2 text-indigo-400 text-xs"></i>Téléphone de l'entreprise
                            <span class="text-red-400">*</span>
                        </label>
                        <div class="relative">
                            <i class="fas fa-phone absolute left-3 top-1/2 transform -translate-y-1/2 text-indigo-400 text-sm"></i>
                            <input type="tel" id="numero-entreprise" name="telephone" value="{{ old('telephone') }}" 
                                   placeholder="+225 01 23 45 67 89"
                                   class="form-input w-full px-4 py-3 pl-10 rounded-xl text-white placeholder-slate-500 focus:outline-none">
                        </div>
                        @error('telephone')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email-entreprise" class="block text-sm font-medium text-slate-300 mb-2">
                            <i class="fas fa-envelope mr-2 text-indigo-400 text-xs"></i>Email de l'entreprise
                            <span class="text-red-400">*</span>
                        </label>
                        <div class="relative">
                            <i class="fas fa-envelope absolute left-3 top-1/2 transform -translate-y-1/2 text-indigo-400 text-sm"></i>
                            <input type="email" id="email-entreprise" name="email_entreprise" value="{{ old('email_entreprise') }}" 
                                   placeholder="contact@entreprise.com"
                                   class="form-input w-full px-4 py-3 pl-10 rounded-xl text-white placeholder-slate-500 focus:outline-none">
                        </div>
                        @error('email_entreprise')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Mot de passe et confirmation -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label for="motDePasse-entreprise" class="block text-sm font-medium text-slate-300 mb-2">
                                <i class="fas fa-lock mr-2 text-indigo-400 text-xs"></i>Mot de passe
                                <span class="text-red-400">*</span>
                            </label>
                            <div class="relative">
                                <i class="fas fa-lock absolute left-3 top-1/2 transform -translate-y-1/2 text-indigo-400 text-sm"></i>
                                <input type="password" id="motDePasse-entreprise" name="motDePasse_entreprise" 
                                       placeholder="••••••••"
                                       class="form-input w-full px-4 py-3 pl-10 rounded-xl text-white placeholder-slate-500 focus:outline-none">
                            </div>
                            @error('motDePasse_entreprise')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="confirmation_password" class="block text-sm font-medium text-slate-300 mb-2">
                                <i class="fas fa-check-circle mr-2 text-indigo-400 text-xs"></i>Confirmation
                                <span class="text-red-400">*</span>
                            </label>
                            <div class="relative">
                                <i class="fas fa-check-circle absolute left-3 top-1/2 transform -translate-y-1/2 text-indigo-400 text-sm"></i>
                                <input type="password" id="confirmation_password" name="confirmation_password" 
                                       placeholder="••••••••"
                                       class="form-input w-full px-4 py-3 pl-10 rounded-xl text-white placeholder-slate-500 focus:outline-none">
                            </div>
                            @error('confirmation_password')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Bouton d'inscription -->
                    <div class="pt-4">
                        <button id="btnSubmit" type="submit" 
                                class="btn-primary w-full py-3 rounded-xl text-white font-semibold flex items-center justify-center gap-2 transition-all duration-200">
                            <i class="fas fa-rocket"></i>
                            <span>S'inscrire</span>
                            <i class="fas fa-arrow-right text-sm"></i>
                        </button>
                    </div>
                </form>

                <!-- Lien vers la connexion -->
                <div class="mt-8 text-center">
                    <p class="text-slate-400 text-sm">
                        Vous avez déjà un compte ? 
                        <a href="{{route('login')}}" class="text-indigo-400 hover:text-indigo-300 font-medium transition-colors">
                            Connectez-vous ici
                            <i class="fas fa-arrow-right ml-1 text-xs"></i>
                        </a>
                    </p>
                </div>

                <!-- Avantages -->
                <div class="mt-8 pt-6 border-t border-slate-700/50">
                    <div class="grid grid-cols-3 gap-3 text-center">
                        <div>
                            <i class="fas fa-shield-alt text-indigo-400 text-lg mb-1 block"></i>
                            <p class="text-xs text-slate-400">Sécurisé</p>
                        </div>
                        <div>
                            <i class="fas fa-clock text-indigo-400 text-lg mb-1 block"></i>
                            <p class="text-xs text-slate-400">Rapide</p>
                        </div>
                        <div>
                            <i class="fas fa-headset text-indigo-400 text-lg mb-1 block"></i>
                            <p class="text-xs text-slate-400">Support 24/7</p>
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

    <script>
    document.addEventListener("DOMContentLoaded", function () {
        const form = document.getElementById('formRegister');
        const button = document.getElementById('btnSubmit');

        if (form) {
            form.addEventListener('submit', function () {
                if (button.disabled) {
                    return false;
                }

                button.disabled = true;
                button.innerHTML = `
                    <span class="flex items-center justify-center gap-2">
                        <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                        </svg>
                        Inscription en cours...
                    </span>
                `;
                button.classList.remove('btn-primary');
                button.classList.add('opacity-70', 'cursor-not-allowed', 'bg-slate-600');
            });
        }
    });
    </script>
</body>
</html>