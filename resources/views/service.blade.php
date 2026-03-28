<!DOCTYPE html>
<html lang="fr" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nos Services - EM-Manager</title>
    <link rel="shortcut icon" href="images/management.png" type="image/x-icon">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    @include('style')

    <!-- Animation AOS.js -->
    @include('aos')
    
    <style>
        /* Styles modernes et épurés */
        body {
            background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 100%);
        }

        /* Amélioration de la scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }
        
        ::-webkit-scrollbar-track {
            background: #1e293b;
        }
        
        ::-webkit-scrollbar-thumb {
            background: #6366f1;
            border-radius: 4px;
        }
        
        ::-webkit-scrollbar-thumb:hover {
            background: #8b5cf6;
        }
        
        .service-card {
            background: rgba(30, 41, 59, 0.6);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(99, 102, 241, 0.2);
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }
        
        .service-card:hover {
            transform: translateY(-8px);
            border-color: rgba(99, 102, 241, 0.5);
            box-shadow: 0 20px 35px -12px rgba(99, 102, 241, 0.3);
        }
        
        .icon-wrapper {
            width: 70px;
            height: 70px;
            background: linear-gradient(135deg, rgba(99, 102, 241, 0.2), rgba(139, 92, 246, 0.2));
            border-radius: 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1.5rem;
        }
        
        .icon-wrapper i {
            font-size: 2rem;
            color: #818cf8;
        }
        
        .feature-card {
            background: rgba(15, 23, 42, 0.5);
            backdrop-filter: blur(8px);
            border: 1px solid rgba(99, 102, 241, 0.15);
            transition: all 0.3s ease;
        }
        
        .feature-card:hover {
            border-color: rgba(99, 102, 241, 0.4);
            transform: scale(1.02);
        }
        
        .hero-gradient {
            background: radial-gradient(circle at 20% 30%, #1e293b, #0f172a);
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            transition: all 0.3s ease;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px -5px rgba(99, 102, 241, 0.4);
        }
        
        .btn-outline {
            border: 2px solid #6366f1;
            transition: all 0.3s ease;
        }
        
        .btn-outline:hover {
            background: rgba(99, 102, 241, 0.1);
            transform: translateY(-2px);
        }
        
        .section-badge {
            display: inline-block;
            padding: 0.5rem 1rem;
            background: rgba(99, 102, 241, 0.1);
            border: 1px solid rgba(99, 102, 241, 0.3);
            border-radius: 2rem;
            font-size: 0.875rem;
            font-weight: 500;
            color: #818cf8;
            margin-bottom: 1rem;
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }
        
        .float-animation {
            animation: float 6s ease-in-out infinite;
        }
        
        /* Effet de brillance */
        .glow-effect {
            position: relative;
            overflow: hidden;
        }
        
        .glow-effect::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(99, 102, 241, 0.1), transparent);
            opacity: 0;
            transition: opacity 0.6s ease;
        }
        
        .glow-effect:hover::before {
            opacity: 1;
        }
    </style>
</head>
<body class="antialiased overflow-x-hidden">
    <!-- Barre de navigation -->
    @include('nav')

    <!-- Hero Section moderne -->
    <section class="hero-gradient min-h-[70vh] flex items-center relative overflow-hidden">
        <!-- Éléments décoratifs -->
        <div class="absolute top-20 left-10 w-72 h-72 bg-indigo-500 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-pulse"></div>
        <div class="absolute bottom-20 right-10 w-96 h-96 bg-purple-500 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-pulse" style="animation-delay: 2s;"></div>
        
        <div class="container mx-auto px-6 relative z-10">
            <div class="max-w-4xl mx-auto text-center" data-aos="fade-up" data-aos-duration="800">
                <span class="section-badge">
                    <i class="fas fa-crown mr-2"></i> Excellence opérationnelle
                </span>
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-white mb-6 leading-tight">
                    Solutions RH <span class="bg-gradient-to-r from-indigo-400 to-purple-400 bg-clip-text text-transparent">complètes</span>
                </h1>
                <p class="text-lg md:text-xl text-slate-300 mb-10 max-w-2xl mx-auto leading-relaxed">
                    Automatisez, simplifiez et optimisez la gestion de vos ressources humaines avec notre plateforme tout-en-un.
                </p>
                <div class="flex flex-col sm:flex-row justify-center gap-4">
                    <a href="{{route('dashboard_entreprise')}}" class="btn-primary px-8 py-3 rounded-full text-white font-semibold inline-flex items-center justify-center gap-2 transition-all">
                        <i class="fas fa-building"></i> Espace Entreprise
                        <i class="fas fa-arrow-right text-sm"></i>
                    </a>
                    <a href="{{route('employe_dashboard')}}" class="btn-outline px-8 py-3 rounded-full text-white font-semibold inline-flex items-center justify-center gap-2 transition-all">
                        <i class="fas fa-user-tie"></i> Espace Employé
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Services Section - Épurée avec 4 cartes principales -->
    <section class="py-24 relative">
        <div class="container mx-auto px-6">
            <div class="text-center mb-16" data-aos="fade-up">
                <span class="section-badge">
                    <i class="fas fa-rocket mr-2"></i> Nos services
                </span>
                <h2 class="text-3xl md:text-4xl font-bold text-white mb-4">
                    Une gestion RH <span class="gradient-text">intelligente</span>
                </h2>
                <p class="text-lg text-slate-400 max-w-2xl mx-auto">
                    Des outils puissants pour une gestion optimisée de vos équipes
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Service 1 -->
                <div class="service-card p-6 rounded-2xl" data-aos="fade-up" data-aos-delay="100">
                    <div class="icon-wrapper">
                        <i class="fas fa-users"></i>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-3">Gestion des employés</h3>
                    <p class="text-slate-400 text-sm leading-relaxed mb-4">
                        Centralisez toutes les informations de vos collaborateurs en un seul endroit sécurisé.
                    </p>
                    <ul class="space-y-2 text-slate-400 text-sm">
                        <li class="flex items-center gap-2">
                            <i class="fas fa-check-circle text-indigo-400 text-xs"></i>
                            <span>Profils personnalisés</span>
                        </li>
                        <li class="flex items-center gap-2">
                            <i class="fas fa-check-circle text-indigo-400 text-xs"></i>
                            <span>Documents centralisés</span>
                        </li>
                    </ul>
                </div>

                <!-- Service 2 -->
                <div class="service-card p-6 rounded-2xl" data-aos="fade-up" data-aos-delay="200">
                    <div class="icon-wrapper">
                        <i class="fas fa-calendar-alt"></i>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-3">Gestion des congés</h3>
                    <p class="text-slate-400 text-sm leading-relaxed mb-4">
                        Automatisez les demandes et le suivi des absences en toute transparence.
                    </p>
                    <ul class="space-y-2 text-slate-400 text-sm">
                        <li class="flex items-center gap-2">
                            <i class="fas fa-check-circle text-indigo-400 text-xs"></i>
                            <span>Demandes en ligne</span>
                        </li>
                        <li class="flex items-center gap-2">
                            <i class="fas fa-check-circle text-indigo-400 text-xs"></i>
                            <span>Soldes automatiques</span>
                        </li>
                    </ul>
                </div>

                <!-- Service 3 -->
                <div class="service-card p-6 rounded-2xl" data-aos="fade-up" data-aos-delay="300">
                    <div class="icon-wrapper">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-3">Suivi des performances</h3>
                    <p class="text-slate-400 text-sm leading-relaxed mb-4">
                        Évaluez et développez les compétences de vos équipes efficacement.
                    </p>
                    <ul class="space-y-2 text-slate-400 text-sm">
                        <li class="flex items-center gap-2">
                            <i class="fas fa-check-circle text-indigo-400 text-xs"></i>
                            <span>Évaluations structurées</span>
                        </li>
                        <li class="flex items-center gap-2">
                            <i class="fas fa-check-circle text-indigo-400 text-xs"></i>
                            <span>Objectifs suivis</span>
                        </li>
                    </ul>
                </div>

                <!-- Service 4 -->
                <div class="service-card p-6 rounded-2xl" data-aos="fade-up" data-aos-delay="400">
                    <div class="icon-wrapper">
                        <i class="fas fa-chart-pie"></i>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-3">Analytique avancée</h3>
                    <p class="text-slate-400 text-sm leading-relaxed mb-4">
                        Des indicateurs clés pour piloter votre stratégie RH en temps réel.
                    </p>
                    <ul class="space-y-2 text-slate-400 text-sm">
                        <li class="flex items-center gap-2">
                            <i class="fas fa-check-circle text-indigo-400 text-xs"></i>
                            <span>Tableaux de bord</span>
                        </li>
                        <li class="flex items-center gap-2">
                            <i class="fas fa-check-circle text-indigo-400 text-xs"></i>
                            <span>Rapports exportables</span>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Lien vers plus de détails -->
            <div class="text-center mt-12" data-aos="fade-up">
                <a href="{{route('dashboard_entreprise')}}" class="inline-flex items-center gap-2 text-indigo-400 hover:text-indigo-300 transition-colors font-medium">
                    <span>Découvrir toutes les fonctionnalités</span>
                    <i class="fas fa-arrow-right text-sm"></i>
                </a>
            </div>
        </div>
    </section>

    <!-- Avantages - Section simplifiée -->
    <section class="py-20 relative">
        <div class="container mx-auto px-6">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <div data-aos="fade-right">
                    <span class="section-badge">
                        <i class="fas fa-star mr-2"></i> Pourquoi nous choisir
                    </span>
                    <h2 class="text-3xl md:text-4xl font-bold text-white mb-4">
                        L'excellence RH à <span class="gradient-text">portée de main</span>
                    </h2>
                    <p class="text-slate-400 mb-8 leading-relaxed">
                        EM-Manager combine technologie de pointe et simplicité d'utilisation pour transformer votre gestion des ressources humaines.
                    </p>
                    
                    <div class="space-y-4">
                        <div class="flex items-start gap-4">
                            <div class="w-10 h-10 rounded-lg bg-indigo-500/20 flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-shield-alt text-indigo-400"></i>
                            </div>
                            <div>
                                <h3 class="text-white font-semibold mb-1">Sécurité maximale</h3>
                                <p class="text-slate-400 text-sm">Données chiffrées et conformité RGPD garantie</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-4">
                            <div class="w-10 h-10 rounded-lg bg-indigo-500/20 flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-cloud-upload-alt text-indigo-400"></i>
                            </div>
                            <div>
                                <h3 class="text-white font-semibold mb-1">Accessibilité totale</h3>
                                <p class="text-slate-400 text-sm">Accédez à vos données depuis n'importe quel appareil</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-4">
                            <div class="w-10 h-10 rounded-lg bg-indigo-500/20 flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-headset text-indigo-400"></i>
                            </div>
                            <div>
                                <h3 class="text-white font-semibold mb-1">Support réactif</h3>
                                <p class="text-slate-400 text-sm">Une équipe dédiée à votre disposition 24h/24</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="relative" data-aos="fade-left">
                    <div class="relative rounded-2xl overflow-hidden border border-indigo-500/20">
                        <img src="https://images.unsplash.com/photo-1522071820081-009f0129c71c?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80" alt="Dashboard EM-Manager" class="w-full h-auto">
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-900 via-transparent to-transparent"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section épurée -->
    <section class="py-16 relative">
        <div class="absolute inset-0 bg-gradient-to-r from-indigo-600/10 to-purple-600/10"></div>
        <div class="container mx-auto px-6 text-center relative z-10">
            <div class="max-w-3xl mx-auto" data-aos="fade-up">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-indigo-500/20 rounded-full mb-6">
                    <i class="fas fa-chart-line text-2xl text-indigo-400"></i>
                </div>
                <h2 class="text-3xl md:text-4xl font-bold text-white mb-4">
                    Prêt à <span class="gradient-text">révolutionner</span> votre gestion RH ?
                </h2>
                <p class="text-lg text-slate-400 mb-8">
                    Rejoignez plus de 500 entreprises qui nous font déjà confiance
                </p>
                <div class="flex flex-col sm:flex-row justify-center gap-4">
                    <a href="{{route('dashboard_entreprise')}}" class="btn-primary px-8 py-3 rounded-full text-white font-semibold inline-flex items-center justify-center gap-2">
                        <i class="fas fa-rocket"></i> Commencer maintenant
                    </a>
                    <a href="{{route('contact')}}" class="btn-outline px-8 py-3 rounded-full text-white font-semibold inline-flex items-center justify-center gap-2">
                        <i class="fas fa-envelope"></i> Nous contacter
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    @include('footer')

    <!-- Chargement de la page -->
    @include('loading')
</body>
</html>