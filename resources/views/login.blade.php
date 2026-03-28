<!DOCTYPE html>
<html lang="fr" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - EM-Manager</title>
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
        
        .login-container {
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
        
        .alert-error {
            background: rgba(239, 68, 68, 0.2);
            border: 1px solid rgba(239, 68, 68, 0.3);
            backdrop-filter: blur(8px);
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

    <!-- Section Connexion -->
    <section class="min-h-screen flex items-center justify-center py-20 px-4 relative overflow-hidden">
        <!-- Éléments décoratifs -->
        <div class="absolute top-20 left-10 w-72 h-72 bg-indigo-500 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-pulse"></div>
        <div class="absolute bottom-20 right-10 w-96 h-96 bg-purple-500 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-pulse" style="animation-delay: 2s;"></div>
        
        <div class="w-full max-w-md mx-auto relative z-10" data-aos="fade-up" data-aos-duration="800">
            
            <!-- Affichage des erreurs -->
            @if ($errors->any())
            <div class="mb-6 alert-error rounded-xl p-4" data-aos="fade-down" data-aos-duration="500">
                <div class="flex items-start gap-3">
                    <div class="flex-shrink-0">
                        <i class="fas fa-exclamation-triangle text-red-400 text-lg"></i>
                    </div>
                    <div class="flex-1">
                        <h3 class="font-semibold text-red-300 text-sm mb-1">Erreur de connexion</h3>
                        <ul class="text-red-200 text-sm space-y-1">
                            @foreach ($errors->all() as $error)
                                <li class="flex items-center gap-2">
                                    <i class="fas fa-circle text-red-400 text-[6px]"></i>
                                    <span>{{ $error }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <button onclick="this.closest('.alert-error').style.display='none'" class="text-red-300 hover:text-red-200 transition-colors">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
            @endif

            <!-- Container Principal -->
            <div class="login-container p-6 md:p-8">
                <!-- En-tête -->
                <div class="text-center mb-8">
                    <div class="flex justify-center mb-4">
                        <div class="w-16 h-16 rounded-xl bg-indigo-500/20 flex items-center justify-center">
                            <i class="fas fa-key text-3xl text-indigo-400"></i>
                        </div>
                    </div>
                    <h1 class="text-3xl md:text-4xl font-bold text-white mb-2">
                        Bienvenue sur <span class="gradient-text">EM-Manager</span>
                    </h1>
                    <p class="text-slate-400">
                        Connectez-vous à votre compte
                    </p>
                </div>

                <!-- Formulaire de connexion -->
                <form id="formLogin" action="/login" method="POST" class="space-y-5">
                    @csrf
                    
                    <!-- Matricule -->
                    <div>
                        <label for="matricule" class="block text-sm font-medium text-slate-300 mb-2">
                            <i class="fas fa-id-card mr-2 text-indigo-400 text-xs"></i>Matricule
                            <span class="text-red-400">*</span>
                        </label>
                        <div class="relative">
                            <i class="fas fa-id-card absolute left-3 top-1/2 transform -translate-y-1/2 text-indigo-400 text-sm"></i>
                            <input type="text" id="matricule" name="matricule" required 
                                   value="{{ old('matricule') }}"
                                   placeholder="ENT-1234 / EMP-1234"
                                   class="form-input w-full px-4 py-3 pl-10 rounded-xl text-white placeholder-slate-500 focus:outline-none">
                        </div>
                        <p class="text-xs text-slate-500 mt-1">
                            <i class="fas fa-info-circle mr-1"></i>Matricule à 8 caractères
                        </p>
                    </div>

                    <!-- Mot de passe -->
                    <div>
                        <label for="password" class="block text-sm font-medium text-slate-300 mb-2">
                            <i class="fas fa-lock mr-2 text-indigo-400 text-xs"></i>Mot de passe
                            <span class="text-red-400">*</span>
                        </label>
                        <div class="relative">
                            <i class="fas fa-lock absolute left-3 top-1/2 transform -translate-y-1/2 text-indigo-400 text-sm"></i>
                            <input type="password" id="password" name="password" required 
                                   placeholder="••••••••"
                                   class="form-input w-full px-4 py-3 pl-10 rounded-xl text-white placeholder-slate-500 focus:outline-none">
                            <button type="button" id="togglePassword" class="absolute right-3 top-1/2 transform -translate-y-1/2 text-slate-400 hover:text-indigo-400 transition-colors">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Lien mot de passe oublié -->
                    <div class="text-right">
                        <a href="{{route('contact')}}" class="text-xs text-slate-400 hover:text-indigo-400 transition-colors">
                            <i class="fas fa-question-circle mr-1"></i>Mot de passe oublié ?
                        </a>
                    </div>

                    <!-- Bouton de connexion -->
                    <div class="pt-2">
                        <button id="btnSubmit" type="submit" 
                                class="btn-primary w-full py-3 rounded-xl text-white font-semibold flex items-center justify-center gap-2 transition-all duration-200">
                            <i class="fas fa-sign-in-alt"></i>
                            <span>Se connecter</span>
                            <i class="fas fa-arrow-right text-sm"></i>
                        </button>
                    </div>
                </form>

                <!-- Séparateur -->
                <div class="relative my-6">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-slate-700/50"></div>
                    </div>
                    <div class="relative flex justify-center text-xs">
                        <span class="bg-slate-800/50 px-2 text-slate-400">ou</span>
                    </div>
                </div>

                <!-- Lien vers l'inscription -->
                <div class="text-center">
                    <p class="text-slate-400 text-sm">
                        Vous n'avez pas de compte ?
                        <a href="{{route('register')}}" class="text-indigo-400 hover:text-indigo-300 font-medium transition-colors">
                            Créer un compte
                            <i class="fas fa-arrow-right ml-1 text-xs"></i>
                        </a>
                    </p>
                </div>

                <!-- Informations supplémentaires -->
                <div class="mt-6 pt-4 border-t border-slate-700/50">
                    <div class="flex justify-center gap-4 text-xs text-slate-500">
                        <span><i class="fas fa-building mr-1"></i>Compte entreprise</span>
                        <span><i class="fas fa-user-tie mr-1"></i>Compte employé</span>
                        <span><i class="fas fa-shield-alt mr-1"></i>Sécurisé</span>
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
        const form = document.getElementById('formLogin');
        const button = document.getElementById('btnSubmit');
        const togglePassword = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('password');

        // Toggle password visibility
        if (togglePassword && passwordInput) {
            togglePassword.addEventListener('click', function () {
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);
                this.innerHTML = type === 'password' ? '<i class="fas fa-eye"></i>' : '<i class="fas fa-eye-slash"></i>';
            });
        }

        // Form submission handler
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
                        Connexion en cours...
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