<!DOCTYPE html>
<html lang="fr" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EM-Manager | Gestion RH Innovante</title>
    <link rel="shortcut icon" href="images/management.png" type="image/x-icon">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <!-- Animation AOS.js -->
    @include('aos')
    

    @include('style')
    
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');
        
        body {
            font-family: 'Inter', sans-serif;
            background-color: #0f172a;
            color: #f8fafc;
            overflow-x: hidden;
        }
        
        .gradient-text {
            background: linear-gradient(135deg, #6366f1, #8b5cf6, #a855f7);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }
        
        .hero-gradient {
            background: radial-gradient(circle at 10% 20%, rgb(15, 23, 42) 0%, rgb(30, 41, 59) 90%);
        }
        
        .feature-card {
            background: rgba(30, 41, 59, 0.6);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(99, 102, 241, 0.15);
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }
        
        .feature-card:hover {
            transform: translateY(-8px);
            border-color: rgba(99, 102, 241, 0.4);
            box-shadow: 0 20px 35px -12px rgba(0, 0, 0, 0.3);
        }
        
        .testimonial-card {
            background: linear-gradient(145deg, #1e293b 0%, #0f172a 100%);
            border: 1px solid rgba(99, 102, 241, 0.2);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .testimonial-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px -12px rgba(99, 102, 241, 0.2);
        }
        
        .glow {
            box-shadow: 0 0 20px rgba(99, 102, 241, 0.3);
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px -5px rgba(99, 102, 241, 0.4);
        }
        
        .btn-primary:active {
            transform: translateY(0);
        }
        
        .stars {
            color: #fbbf24;
            letter-spacing: 2px;
        }
        
        .floating {
            animation: floating 5s ease-in-out infinite;
        }
        
        @keyframes floating {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-8px); }
        }
        
        /* Nouveaux styles pour une UI plus professionnelle */
        .stat-card {
            background: rgba(15, 23, 42, 0.8);
            backdrop-filter: blur(8px);
            border: 1px solid rgba(99, 102, 241, 0.2);
            transition: all 0.3s ease;
        }
        
        .stat-card:hover {
            border-color: rgba(99, 102, 241, 0.5);
            transform: scale(1.02);
        }
        
        .icon-wrapper {
            background: linear-gradient(135deg, rgba(99, 102, 241, 0.2), rgba(139, 92, 246, 0.2));
            border-radius: 1rem;
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
        
        /* Animation pour les éléments décoratifs */
        @keyframes pulse-glow {
            0%, 100% { opacity: 0.3; }
            50% { opacity: 0.6; }
        }
        
        .animate-pulse-glow {
            animation: pulse-glow 4s ease-in-out infinite;
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
        
        /* Image container carré et réduit */
        .hero-image-container {
            position: relative;
            width: 100%;
            max-width: 380px;
            margin: 0 auto;
            border-radius: 1rem;
            overflow: hidden;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
            aspect-ratio: 1 / 1;
        }
        
        .hero-image-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.6s cubic-bezier(0.4, 0, 0.2, 1);
            display: block;
        }
        
        .hero-image-container:hover img {
            transform: scale(1.05);
        }
        
        .image-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, rgba(99, 102, 241, 0.2), rgba(139, 92, 246, 0.1));
            pointer-events: none;
        }
        
        /* Ajustement pour les écrans plus petits */
        @media (max-width: 1024px) {
            .hero-image-container {
                max-width: 320px;
            }
        }
        
        @media (max-width: 768px) {
            .hero-image-container {
                max-width: 280px;
            }
        }
    </style>
</head>
<body class="antialiased">

    <!-- Navigation -->
    @include('nav')

    <!-- Hero Section avec image carrée réduite -->
    <section class="hero-gradient min-h-screen flex items-center pt-20 pb-24 px-4 sm:px-6 lg:px-8 overflow-hidden relative">
        <!-- Éléments décoratifs -->
        <div class="absolute top-20 left-10 w-72 h-72 bg-indigo-500 rounded-full mix-blend-multiply filter blur-3xl opacity-10 animate-pulse-glow"></div>
        <div class="absolute bottom-20 right-10 w-96 h-96 bg-purple-500 rounded-full mix-blend-multiply filter blur-3xl opacity-10 animate-pulse-glow" style="animation-delay: 2s;"></div>
        
        <div class="container mx-auto relative z-10">
            <div class="flex flex-col lg:flex-row items-center justify-between gap-12">
                <div class="lg:w-1/2" data-aos="fade-right" data-aos-duration="800">
                    <div class="mb-6">
                        <span class="section-badge">
                            <i class="fas fa-chart-line mr-2"></i> Solution RH nouvelle génération
                        </span>
                    </div>
                    <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold leading-tight mb-6">
                        Optimisez votre gestion <span class="gradient-text">RH</span> avec intelligence
                    </h1>
                    <p class="text-lg text-slate-300 mb-8 leading-relaxed max-w-lg">
                        EM-Manager révolutionne la gestion des ressources humaines grâce à une plateforme intuitive, 
                        des analyses avancées et des outils collaboratifs puissants.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4">
                        <a href="@auth {{route('dashboard_entreprise')}} @else {{route('register')}} @endauth" class="btn-primary text-white font-semibold py-3 px-8 rounded-full inline-flex items-center justify-center gap-2">
                            <i class="fas fa-rocket"></i> Commencer maintenant
                            <i class="fas fa-arrow-right ml-1 text-sm"></i>
                        </a>
                    </div>
                    
                    <!-- Statistiques rapides -->
                    <div class="grid grid-cols-3 gap-4 mt-12">
                        <div class="stat-card p-3 rounded-lg text-center">
                            <div class="text-2xl font-bold text-indigo-400">500+</div>
                            <div class="text-xs text-slate-400">Entreprises</div>
                        </div>
                        <div class="stat-card p-3 rounded-lg text-center">
                            <div class="text-2xl font-bold text-indigo-400">10k+</div>
                            <div class="text-xs text-slate-400">Utilisateurs</div>
                        </div>
                        <div class="stat-card p-3 rounded-lg text-center">
                            <div class="text-2xl font-bold text-indigo-400">98%</div>
                            <div class="text-xs text-slate-400">Satisfaction</div>
                        </div>
                    </div>
                </div>
                
                <div class="lg:w-1/2 flex justify-center" data-aos="fade-left" data-aos-duration="800" data-aos-delay="200">
                    <div class="floating">
                        <div class="hero-image-container">
                            <img src="/images/accueil.jpeg" alt="Dashboard EM-Manager">
                            <div class="image-overlay"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section avec structure améliorée -->
    <section class="py-24 relative overflow-hidden">
        <div class="container mx-auto px-4 relative z-10">
            <div class="text-center mb-16" data-aos="fade-up">
                <span class="section-badge">
                    <i class="fas fa-crown mr-2"></i> Pourquoi nous choisir ?
                </span>
                <h2 class="text-3xl md:text-4xl font-bold mb-4 mt-4">
                    Une solution <span class="gradient-text">complète</span> et <span class="gradient-text">intégrée</span>
                </h2>
                <p class="text-lg text-slate-400 max-w-2xl mx-auto">
                    Découvrez comment EM-Manager transforme la gestion des ressources humaines
                </p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div class="feature-card p-8 rounded-2xl" data-aos="fade-up" data-aos-delay="100">
                    <div class="icon-wrapper w-14 h-14 flex items-center justify-center mb-6">
                        <i class="fas fa-calendar-alt text-2xl text-indigo-400"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-3">Gestion des plannings</h3>
                    <p class="text-slate-400 leading-relaxed mb-4">Planification intelligente avec visualisation en temps réel des disponibilités et des charges de travail.</p>
                    <a href="{{route('service')}}" class="text-indigo-400 hover:text-indigo-300 inline-flex items-center text-sm font-medium">
                        Découvrir <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>
                
                <!-- Feature 2 -->
                <div class="feature-card p-8 rounded-2xl" data-aos="fade-up" data-aos-delay="200">
                    <div class="icon-wrapper w-14 h-14 flex items-center justify-center mb-6">
                        <i class="fas fa-umbrella-beach text-2xl text-purple-400"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-3">Suivi des congés</h3>
                    <p class="text-slate-400 leading-relaxed mb-4">Automatisation complète du processus de demande et d'approbation avec tableau de bord dédié.</p>
                    <a href="{{route('service')}}" class="text-indigo-400 hover:text-indigo-300 inline-flex items-center text-sm font-medium">
                        Découvrir <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>
                
                <!-- Feature 3 -->
                <div class="feature-card p-8 rounded-2xl" data-aos="fade-up" data-aos-delay="300">
                    <div class="icon-wrapper w-14 h-14 flex items-center justify-center mb-6">
                        <i class="fas fa-chart-line text-2xl text-pink-400"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-3">Analyses avancées</h3>
                    <p class="text-slate-400 leading-relaxed mb-4">Tableaux de bord interactifs et rapports personnalisés pour piloter votre performance RH.</p>
                    <a href="{{route('service')}}" class="text-indigo-400 hover:text-indigo-300 inline-flex items-center text-sm font-medium">
                        Découvrir <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>
                
                <!-- Feature 4 -->
                <div class="feature-card p-8 rounded-2xl" data-aos="fade-up" data-aos-delay="400">
                    <div class="icon-wrapper w-14 h-14 flex items-center justify-center mb-6">
                        <i class="fas fa-file-invoice-dollar text-2xl text-blue-400"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-3">Gestion de paie</h3>
                    <p class="text-slate-400 leading-relaxed mb-4">Calcul automatisé des salaires, génération des bulletins et conformité légale garantie.</p>
                    <a href="{{route('service')}}" class="text-indigo-400 hover:text-indigo-300 inline-flex items-center text-sm font-medium">
                        Découvrir <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>
                
                <!-- Feature 5 -->
                <div class="feature-card p-8 rounded-2xl" data-aos="fade-up" data-aos-delay="500">
                    <div class="icon-wrapper w-14 h-14 flex items-center justify-center mb-6">
                        <i class="fas fa-tasks text-2xl text-green-400"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-3">Gestion collaborative</h3>
                    <p class="text-slate-400 leading-relaxed mb-4">Assignation et suivi des tâches avec notifications en temps réel et historisation complète.</p>
                    <a href="{{route('service')}}" class="text-indigo-400 hover:text-indigo-300 inline-flex items-center text-sm font-medium">
                        Découvrir <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>
                
                <!-- Feature 6 -->
                <div class="feature-card p-8 rounded-2xl" data-aos="fade-up" data-aos-delay="600">
                    <div class="icon-wrapper w-14 h-14 flex items-center justify-center mb-6">
                        <i class="fas fa-shield-alt text-2xl text-yellow-400"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-3">Sécurité maximale</h3>
                    <p class="text-slate-400 leading-relaxed mb-4">Données chiffrées, accès sécurisés et conformité RGPD pour une tranquillité d'esprit totale.</p>
                    <a href="{{route('service')}}" class="text-indigo-400 hover:text-indigo-300 inline-flex items-center text-sm font-medium">
                        Découvrir <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials avec personnes noires et blanche -->
    <section class="py-24 bg-gradient-to-b from-slate-900 via-slate-800/50 to-slate-900">
        <div class="container mx-auto px-4">
            <div class="text-center mb-16" data-aos="fade-up">
                <span class="section-badge">
                    <i class="fas fa-quote-left mr-2"></i> Témoignages
                </span>
                <h2 class="text-3xl md:text-4xl font-bold mb-4 mt-4">
                    Ce qu'ils disent <span class="gradient-text">de nous</span>
                </h2>
                <p class="text-lg text-slate-400 max-w-2xl mx-auto">
                    Découvrez les retours d'expérience de nos clients satisfaits
                </p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Testimonial 1 - Femme noire -->
                <div class="testimonial-card p-8 rounded-2xl" data-aos="fade-up" data-aos-delay="100">
                    <div class="flex items-center mb-6">
                        <div class="w-16 h-16 rounded-full overflow-hidden mr-4 ring-2 ring-indigo-500/50">
                            <img src="https://randomuser.me/api/portraits/women/62.jpg" alt="Aminata Diallo" class="w-full h-full object-cover">
                        </div>
                        <div>
                            <h4 class="font-bold text-lg">Aminata Diallo</h4>
                            <p class="text-slate-400 text-sm">Directrice des Ressources Humaines</p>
                        </div>
                    </div>
                    <div class="stars mb-4 text-xl">
                        ★★★★★
                    </div>
                    <p class="text-slate-300 leading-relaxed mb-4">
                        "EM-Manager a transformé notre gestion RH. L'automatisation des processus nous fait gagner 15 heures par semaine. Une solution indispensable pour notre croissance."
                    </p>
                    <div class="text-indigo-400 text-sm font-medium">
                        <i class="fas fa-building mr-2"></i> Groupe Sénégal SA
                    </div>
                </div>
                
                <!-- Testimonial 2 - Homme noir -->
                <div class="testimonial-card p-8 rounded-2xl" data-aos="fade-up" data-aos-delay="200">
                    <div class="flex items-center mb-6">
                        <div class="w-16 h-16 rounded-full overflow-hidden mr-4 ring-2 ring-purple-500/50">
                            <img src="https://randomuser.me/api/portraits/men/83.jpg" alt="Koffi Konan" class="w-full h-full object-cover">
                        </div>
                        <div>
                            <h4 class="font-bold text-lg">Koffi Konan</h4>
                            <p class="text-slate-400 text-sm">Responsable IT & Digital</p>
                        </div>
                    </div>
                    <div class="stars mb-4 text-xl">
                        ★★★★★
                    </div>
                    <p class="text-slate-300 leading-relaxed mb-4">
                        "L'interface est intuitive et les fonctionnalités de reporting sont exceptionnelles. Nous avons gagné en efficacité et en transparence dans la gestion de nos équipes."
                    </p>
                    <div class="text-indigo-400 text-sm font-medium">
                        <i class="fas fa-building mr-2"></i> Tech Solutions Côte d'Ivoire
                    </div>
                </div>
                
                <!-- Testimonial 3 - Femme blanche -->
                <div class="testimonial-card p-8 rounded-2xl" data-aos="fade-up" data-aos-delay="300">
                    <div class="flex items-center mb-6">
                        <div class="w-16 h-16 rounded-full overflow-hidden mr-4 ring-2 ring-pink-500/50">
                            <img src="https://randomuser.me/api/portraits/women/45.jpg" alt="Sophie Martin" class="w-full h-full object-cover">
                        </div>
                        <div>
                            <h4 class="font-bold text-lg">Sophie Martin</h4>
                            <p class="text-slate-400 text-sm">Chef de projet RH</p>
                        </div>
                    </div>
                    <div class="stars mb-4 text-xl">
                        ★★★★☆
                    </div>
                    <p class="text-slate-300 leading-relaxed mb-4">
                        "Le suivi des congés et la gestion des plannings sont devenus un jeu d'enfant. Le support client est réactif et professionnel. Je recommande vivement !"
                    </p>
                    <div class="text-indigo-400 text-sm font-medium">
                        <i class="fas fa-building mr-2"></i> Cabinet Conseil International
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section simplifiée -->
    <section class="py-20 relative overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-r from-indigo-600/20 to-purple-600/20"></div>
        <div class="absolute inset-0 bg-[url('https://grainy-gradients.vercel.app/noise.svg')] opacity-20"></div>
        <div class="container mx-auto px-4 text-center relative z-10">
            <div class="max-w-3xl mx-auto" data-aos="fade-up">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-white/10 rounded-full mb-6">
                    <i class="fas fa-chart-line text-2xl text-indigo-400"></i>
                </div>
                <h2 class="text-3xl md:text-4xl font-bold text-white mb-4">
                    Prêt à transformer votre <span class="gradient-text">gestion RH</span> ?
                </h2>
                <p class="text-xl text-slate-300 mb-8">
                    Rejoignez plus de 500 entreprises qui optimisent déjà leurs ressources humaines avec EM-Manager.
                </p>
                <div class="flex flex-col sm:flex-row justify-center gap-4">
                    <a href="@auth {{route('dashboard_entreprise')}} @else {{route('register')}} @endauth" class="btn-primary text-white font-semibold py-3 px-8 rounded-full inline-flex items-center justify-center gap-2">
                        <i class="fas fa-gem"></i> Commencer maintenant
                        <i class="fas fa-arrow-right ml-1"></i>
                    </a>
                    <a href="{{route('contact')}}" class="border-2 border-white/30 hover:border-white text-white hover:bg-white/10 font-semibold py-3 px-8 rounded-full transition-all duration-300 inline-flex items-center justify-center gap-2">
                        <i class="fas fa-envelope"></i> Nous contacter
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    @include('footer')

    <!-- Chargement de la page avec loading spinner -->
    @include('loading')

    <script>
        // Animation for blob elements
        document.addEventListener('DOMContentLoaded', () => {
            const blobs = document.querySelectorAll('.animate-blob');
            blobs.forEach((blob, index) => {
                blob.style.animationDelay = `${index * 2}s`;
            });
        });
    </script>
</body>
</html>