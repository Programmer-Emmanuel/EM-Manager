<!DOCTYPE html>
<html lang="fr" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>À Propos - EM-Manager</title>
    <link rel="shortcut icon" href="images/management.png" type="image/x-icon">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    @include('style')

    <!-- Animation AOS.js -->
    @include('aos')
    
    <style>
        /* Styles modernes et cohérents */
        body {
            background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 100%);
        }
        
        .hero-gradient {
            background: radial-gradient(circle at 20% 30%, #1e293b, #0f172a);
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
        
        .about-card {
            background: rgba(30, 41, 59, 0.6);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(99, 102, 241, 0.2);
            transition: all 0.4s ease;
        }
        
        .about-card:hover {
            transform: translateY(-5px);
            border-color: rgba(99, 102, 241, 0.5);
            box-shadow: 0 15px 30px -12px rgba(99, 102, 241, 0.2);
        }
        
        .icon-circle {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, rgba(99, 102, 241, 0.2), rgba(139, 92, 246, 0.2));
            border-radius: 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
        }
        
        .icon-circle i {
            font-size: 2rem;
            color: #818cf8;
        }
        
        .team-card {
            background: rgba(30, 41, 59, 0.6);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(99, 102, 241, 0.2);
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }
        
        .team-card:hover {
            transform: translateY(-8px);
            border-color: rgba(99, 102, 241, 0.5);
            box-shadow: 0 20px 35px -12px rgba(99, 102, 241, 0.3);
        }
        
        .team-image {
            width: 120px;
            height: 120px;
            margin: 0 auto 1rem;
            border-radius: 50%;
            overflow: hidden;
            border: 3px solid #6366f1;
            transition: all 0.3s ease;
        }
        
        .team-card:hover .team-image {
            border-color: #8b5cf6;
            transform: scale(1.05);
        }
        
        .team-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
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
        
        .value-item {
            background: rgba(15, 23, 42, 0.5);
            backdrop-filter: blur(8px);
            border: 1px solid rgba(99, 102, 241, 0.15);
            transition: all 0.3s ease;
        }
        
        .value-item:hover {
            border-color: rgba(99, 102, 241, 0.4);
            transform: scale(1.02);
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
    <!-- Barre de navigation -->
    @include('nav')

    <!-- Hero Section moderne -->
    <section class="hero-gradient min-h-[60vh] flex items-center relative overflow-hidden">
        <!-- Éléments décoratifs -->
        <div class="absolute top-20 left-10 w-72 h-72 bg-indigo-500 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-pulse"></div>
        <div class="absolute bottom-20 right-10 w-96 h-96 bg-purple-500 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-pulse" style="animation-delay: 2s;"></div>
        
        <div class="container mx-auto p-6 relative z-10">
            <div class="max-w-4xl mx-auto text-center" data-aos="fade-up" data-aos-duration="800">
                <span class="section-badge">
                    <i class="fas fa-users mr-2"></i> Qui sommes-nous ?
                </span>
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-white mb-6 leading-tight">
                    Votre partenaire <span class="bg-gradient-to-r from-indigo-400 to-purple-400 bg-clip-text text-transparent">RH de confiance</span>
                </h1>
                <p class="text-lg md:text-xl text-slate-300 max-w-3xl mx-auto mb-10 leading-relaxed">
                    Une solution complète et innovante pour optimiser la gestion de vos employés et ressources humaines.
                </p>
                <div class="flex flex-col sm:flex-row justify-center gap-4">
                    <a href="{{route('service')}}" class="btn-primary px-8 py-3 rounded-full text-white font-semibold inline-flex items-center justify-center gap-2">
                        <i class="fas fa-briefcase"></i> Découvrir nos services
                        <i class="fas fa-arrow-right text-sm"></i>
                    </a>
                    <a href="{{route('contact')}}" class="btn-outline px-8 py-3 rounded-full text-white font-semibold inline-flex items-center justify-center gap-2">
                        <i class="fas fa-envelope"></i> Nous contacter
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Mission, Vision, Valeurs - Version simplifiée -->
    <section class="py-24 relative">
        <div class="container mx-auto px-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Mission -->
                <div class="about-card p-8 rounded-2xl text-center" data-aos="fade-up" data-aos-delay="100">
                    <div class="icon-circle">
                        <i class="fas fa-bullseye"></i>
                    </div>
                    <h2 class="text-2xl font-bold text-white mb-4">Notre Mission</h2>
                    <p class="text-slate-400 leading-relaxed">
                        Révolutionner la gestion RH en proposant des solutions innovantes, simples et efficaces pour aider les entreprises à optimiser la gestion de leurs équipes.
                    </p>
                </div>

                <!-- Vision -->
                <div class="about-card p-8 rounded-2xl text-center" data-aos="fade-up" data-aos-delay="200">
                    <div class="icon-circle">
                        <i class="fas fa-eye"></i>
                    </div>
                    <h2 class="text-2xl font-bold text-white mb-4">Notre Vision</h2>
                    <p class="text-slate-400 leading-relaxed">
                        Devenir la référence en matière de solutions RH numériques, accompagnant la transformation digitale des services RH.
                    </p>
                </div>

                <!-- Valeurs -->
                <div class="about-card p-8 rounded-2xl text-center" data-aos="fade-up" data-aos-delay="300">
                    <div class="icon-circle">
                        <i class="fas fa-heart"></i>
                    </div>
                    <h2 class="text-2xl font-bold text-white mb-4">Nos Valeurs</h2>
                    <div class="space-y-3 text-slate-400">
                        <div class="flex items-center justify-center gap-2">
                            <i class="fas fa-check-circle text-indigo-400 text-sm"></i>
                            <span>Innovation</span>
                        </div>
                        <div class="flex items-center justify-center gap-2">
                            <i class="fas fa-check-circle text-indigo-400 text-sm"></i>
                            <span>Simplicité</span>
                        </div>
                        <div class="flex items-center justify-center gap-2">
                            <i class="fas fa-check-circle text-indigo-400 text-sm"></i>
                            <span>Engagement</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Section Équipe - Factorisée et modernisée -->
    <section class="py-5 relative">
        <div class="container mx-auto px-6">
            <div class="text-center mb-16" data-aos="fade-up">
                <span class="section-badge">
                    <i class="fas fa-user-friends mr-2"></i> Fondateur
                </span>
                <h2 class="text-3xl md:text-4xl font-bold text-white mb-4">
                    Derrière <span class="gradient-text">EM-Manager</span>
                </h2>
                <p class="text-lg text-slate-400 max-w-2xl mx-auto">
                    Une vision, une passion, une innovation au service des entreprises
                </p>
            </div>

            <div class="max-w-md mx-auto" data-aos="fade-up" data-aos-duration="800">
                <div class="team-card p-8 rounded-2xl text-center">
                    <div class="team-image">
                        <img src="/images/WhatsApp Image 2025-05-17 à 10.16.48_3684913b.jpg" alt="Emmanuel Bamidélé">
                    </div>
                    <h3 class="text-2xl font-bold text-white mb-2">Emmanuel Bamidélé</h3>
                    <p class="text-indigo-400 font-medium mb-4">CEO & Fondateur</p>
                    <div class="flex justify-center gap-1 mb-4">
                        <i class="fas fa-star text-yellow-500 text-sm"></i>
                        <i class="fas fa-star text-yellow-500 text-sm"></i>
                        <i class="fas fa-star text-yellow-500 text-sm"></i>
                        <i class="fas fa-star text-yellow-500 text-sm"></i>
                        <i class="fas fa-star text-yellow-500 text-sm"></i>
                    </div>
                    <p class="text-slate-400 leading-relaxed mb-6">
                        Visionnaire et entrepreneur passionné par l'innovation RH, Emmanuel Bamidélé a fondé EM-Manager avec une conviction forte : 
                        simplifier et optimiser la gestion des ressources humaines pour permettre aux entreprises de se concentrer sur l'essentiel.
                    </p>
                    <div class="flex justify-center space-x-4">
                        <a href="{{ route('contact') }}" class="w-10 h-10 rounded-full bg-slate-700 flex items-center justify-center text-slate-400 hover:bg-indigo-500 hover:text-white transition-all">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                        <a href="{{ route('contact') }}" class="w-10 h-10 rounded-full bg-slate-700 flex items-center justify-center text-slate-400 hover:bg-indigo-500 hover:text-white transition-all">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="{{ route('contact') }}" class="w-10 h-10 rounded-full bg-slate-700 flex items-center justify-center text-slate-400 hover:bg-indigo-500 hover:text-white transition-all">
                            <i class="fab fa-github"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Chiffres clés - Section ajoutée pour plus de crédibilité -->
    <section class="py-16 relative">
        <div class="container mx-auto px-6">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                <div class="text-center" data-aos="fade-up" data-aos-delay="100">
                    <div class="text-3xl md:text-4xl font-bold text-indigo-400 mb-2">500+</div>
                    <div class="text-sm text-slate-400">Entreprises clientes</div>
                </div>
                <div class="text-center" data-aos="fade-up" data-aos-delay="200">
                    <div class="text-3xl md:text-4xl font-bold text-indigo-400 mb-2">10k+</div>
                    <div class="text-sm text-slate-400">Utilisateurs actifs</div>
                </div>
                <div class="text-center" data-aos="fade-up" data-aos-delay="300">
                    <div class="text-3xl md:text-4xl font-bold text-indigo-400 mb-2">98%</div>
                    <div class="text-sm text-slate-400">Taux de satisfaction</div>
                </div>
                <div class="text-center" data-aos="fade-up" data-aos-delay="400">
                    <div class="text-3xl md:text-4xl font-bold text-indigo-400 mb-2">24/7</div>
                    <div class="text-sm text-slate-400">Support disponible</div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section épurée -->
    <section class="py-20 relative">
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
                    Rejoignez notre communauté d'entreprises satisfaites et découvrez comment EM-Manager peut transformer votre quotidien.
                </p>
                <div class="flex flex-col sm:flex-row justify-center gap-4">
                    <a href="{{route('dashboard_entreprise')}}" class="btn-primary px-8 py-3 rounded-full text-white font-semibold inline-flex items-center justify-center gap-2">
                        <i class="fas fa-rocket"></i> Commencer maintenant
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