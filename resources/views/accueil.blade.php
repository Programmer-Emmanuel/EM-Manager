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
    

    <script src="https://cdn.tailwindcss.com"></script>
    
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
        
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #0f172a; /* slate-900 */
            color: #f8fafc; /* slate-50 */
            overflow-x: hidden;
        }
        
        .gradient-text {
            background: linear-gradient(90deg, #6366f1, #8b5cf6, #d946ef);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }
        
        .hero-gradient {
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 50%, #334155 100%);
        }
        
        .feature-card {
            background: rgba(15, 23, 42, 0.6);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }
        
        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 25px -5px rgba(99, 102, 241, 0.2), 0 10px 10px -5px rgba(99, 102, 241, 0.04);
            border-color: rgba(99, 102, 241, 0.3);
        }
        
        .testimonial-card {
            background: linear-gradient(145deg, #1e293b 0%, #0f172a 100%);
            border: 1px solid rgba(99, 102, 241, 0.2);
        }
        
        .glow {
            box-shadow: 0 0 15px rgba(99, 102, 241, 0.5);
        }
        
        .btn-primary {
            background: linear-gradient(90deg, #6366f1, #8b5cf6);
            transition: all 0.3s ease;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(99, 102, 241, 0.3);
        }
        
        .btn-secondary {
            background: transparent;
            border: 2px solid #6366f1;
            transition: all 0.3s ease;
        }
        
        .btn-secondary:hover {
            background: rgba(99, 102, 241, 0.1);
        }
        
        .stars {
            color: #fbbf24;
        }
        
        .floating {
            animation: floating 6s ease-in-out infinite;
        }
        
        @keyframes floating {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-15px); }
            100% { transform: translateY(0px); }
        }
    </style>
</head>
<body class="antialiased">

    <!-- Navigation -->
    @include('nav')

    <!-- Hero Section -->
    <section class="hero-gradient min-h-screen flex items-center pt-20 pb-32 px-4 sm:px-6 lg:px-8 overflow-hidden">
        <div class="container mx-auto">
            <div class="flex flex-col lg:flex-row items-center justify-between gap-12">
                <div class="lg:w-1/2" data-aos="fade-right" data-aos-duration="800">
                    <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold leading-tight mb-6">
                        <span class="gradient-text">Optimisez</span> votre gestion RH 
                    </h1>
                    <p class="text-lg md:text-xl text-slate-300 mb-8 max-w-lg">
                        EM-Manager révolutionne la façon dont vous gérez vos équipes avec des outils intuitifs et puissants pour booster la productivité et simplifier vos processus.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4">
                        <a href="@auth {{route('dashboard_entreprise')}} @else {{route('register')}} @endauth" class="btn-primary text-white font-semibold py-3 px-8 rounded-full inline-flex items-center justify-center">
                            Commencer maintenant <i class="fas fa-arrow-right ml-2"></i>
                        </a>
                    </div>
                </div>
                <div class="lg:w-1/2 relative" data-aos="fade-left" data-aos-duration="800" data-aos-delay="200">
                    <div class="floating relative z-8">
                        <img src="/images/accueil.jpeg" alt="Dashboard EM-Manager" class="rounded-xl shadow-2xl glow border border-slate-700/50 h-[600px] w-full max-w-2xl mx-auto">
                    </div>
                    <div class="absolute -bottom-10 -left-10 w-64 h-64 bg-indigo-500 rounded-full mix-blend-multiply filter blur-2xl opacity-20 animate-blob"></div>
                    <div class="absolute -top-10 -right-10 w-64 h-64 bg-purple-500 rounded-full mix-blend-multiply filter blur-2xl opacity-20 animate-blob animation-delay-2000"></div>
                    <div class="absolute -bottom-20 right-20 w-64 h-64 bg-pink-500 rounded-full mix-blend-multiply filter blur-2xl opacity-20 animate-blob animation-delay-4000"></div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-20 relative overflow-hidden">
        <div class="absolute -top-1/2 left-0 w-full h-full bg-gradient-to-b from-slate-900/0 via-slate-900/50 to-slate-900 z-0"></div>
        <div class="container mx-auto px-4 relative z-10">
            <div class="text-center mb-16" data-aos="fade-up">
                <h2 class="text-3xl md:text-4xl font-bold mb-4">Une solution <span class="gradient-text">complète</span></h2>
                <p class="text-lg text-slate-400 max-w-2xl mx-auto">Découvrez les fonctionnalités qui révolutionneront votre gestion des ressources humaines</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div class="feature-card p-8 rounded-2xl" data-aos="fade-up" data-aos-delay="100">
                    <div class="w-16 h-16 bg-indigo-500/10 rounded-lg flex items-center justify-center text-indigo-400 mb-6">
                        <i class="fas fa-calendar-alt text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-3">Gestion des plannings</h3>
                    <p class="text-slate-400 mb-4">Créez et gérez facilement les horaires de vos équipes avec notre interface intuitive et personnalisable.</p><br>
                    <a href="{{route('service')}}" class="text-indigo-400 hover:text-indigo-300 inline-flex items-center">
                        En savoir plus <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>
                
                <!-- Feature 2 -->
                <div class="feature-card p-8 rounded-2xl" data-aos="fade-up" data-aos-delay="200">
                    <div class="w-16 h-16 bg-purple-500/10 rounded-lg flex items-center justify-center text-purple-400 mb-6">
                        <i class="fas fa-umbrella-beach text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-3">Suivi des congés</h3>
                    <p class="text-slate-400 mb-4">Visualisez et approuvez les demandes de congés en temps réel avec un système automatisé et transparent.</p><br>
                    <a href="{{route('service')}}" class="text-indigo-400 hover:text-indigo-300 inline-flex items-center">
                        En savoir plus <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>
                
                <!-- Feature 3 -->
                <div class="feature-card p-8 rounded-2xl" data-aos="fade-up" data-aos-delay="300">
                    <div class="w-16 h-16 bg-pink-500/10 rounded-lg flex items-center justify-center text-pink-400 mb-6">
                        <i class="fas fa-chart-line text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-3">Analyses de performance</h3>
                    <p class="text-slate-400 mb-4">Obtenez des insights précieux sur la productivité de vos équipes grâce à nos tableaux de bord analytiques.</p>
                    <a href="{{route('service')}}" class="text-indigo-400 hover:text-indigo-300 inline-flex items-center">
                        En savoir plus <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>
                
                <!-- Feature 4 -->
                <div class="feature-card p-8 rounded-2xl" data-aos="fade-up" data-aos-delay="400">
                    <div class="w-16 h-16 bg-blue-500/10 rounded-lg flex items-center justify-center text-blue-400 mb-6">
                        <i class="fas fa-file-invoice-dollar text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-3">Gestion de paie</h3>
                    <p class="text-slate-400 mb-4">Automatisez vos processus de paie avec un système intégré qui calcule et génère vos bulletins en quelques clics.</p>
                    <a href="{{route('service')}}" class="text-indigo-400 hover:text-indigo-300 inline-flex items-center">
                        En savoir plus <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>
                
                <!-- Feature 5 -->
                <div class="feature-card p-8 rounded-2xl" data-aos="fade-up" data-aos-delay="500">
                    <div class="w-16 h-16 bg-green-500/10 rounded-lg flex items-center justify-center text-green-400 mb-6">
                        <i class="fas fa-tasks text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-3">Gestion des tâches</h3>
                    <p class="text-slate-400 mb-4">Assignez et suivez les tâches de vos équipes avec un système collaboratif et transparent.</p>
                    <a href="{{route('service')}}" class="text-indigo-400 hover:text-indigo-300 inline-flex items-center">
                        En savoir plus <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>
                
                <!-- Feature 6 -->
                <div class="feature-card p-8 rounded-2xl" data-aos="fade-up" data-aos-delay="600">
                    <div class="w-16 h-16 bg-yellow-500/10 rounded-lg flex items-center justify-center text-yellow-400 mb-6">
                        <i class="fas fa-bell text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-3">Alertes intelligentes</h3>
                    <p class="text-slate-400 mb-4">Recevez des notifications personnalisées pour les actions importantes concernant vos employés.</p>
                    <a href="{{route('service')}}" class="text-indigo-400 hover:text-indigo-300 inline-flex items-center">
                        En savoir plus <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>
            </div>
            
            <div class="text-center mt-16" data-aos="fade-up">
                <a href="{{route('service')}}" class="btn-primary text-white font-semibold py-3 px-8 rounded-full inline-flex items-center">
                    Voir toutes les fonctionnalités <i class="fas fa-arrow-right ml-2"></i>
                </a>
            </div>
        </div>
    </section>

    <!-- Testimonials -->
    <section class="py-20 bg-gradient-to-b from-slate-900 to-slate-800">
        <div class="container mx-auto px-4">
            <div class="text-center mb-16" data-aos="fade-up">
                <h2 class="text-3xl md:text-4xl font-bold mb-4">Ce qu'ils disent <span class="gradient-text">de nous</span></h2>
                <p class="text-lg text-slate-400 max-w-2xl mx-auto">Des centaines d'entreprises nous font déjà confiance pour leur gestion RH</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Testimonial 1 -->
                <div class="testimonial-card p-8 rounded-2xl" data-aos="fade-up" data-aos-delay="100">
                    <div class="flex items-center mb-6">
                        <div class="w-16 h-16 rounded-full overflow-hidden mr-4">
                            <img src="https://randomuser.me/api/portraits/men/32.jpg" alt="Jean Dupont" class="w-full h-full object-cover">
                        </div>
                        <div>
                            <h4 class="font-bold">Jean Dupont</h4>
                            <p class="text-slate-400 text-sm">Directeur RH</p>
                        </div>
                    </div>
                    <div class="stars mb-4">
                        ★★★★★
                    </div>
                    <p class="text-slate-300 italic mb-4">
                        "EM-Manager a transformé notre façon de gérer les ressources humaines. L'interface est intuitive et les fonctionnalités couvrent tous nos besoins."
                    </p>
                    <div class="text-indigo-400 text-sm">
                        <i class="fas fa-building mr-2"></i> Entreprise A
                    </div>
                </div>
                
                <!-- Testimonial 2 -->
                <div class="testimonial-card p-8 rounded-2xl" data-aos="fade-up" data-aos-delay="200">
                    <div class="flex items-center mb-6">
                        <div class="w-16 h-16 rounded-full overflow-hidden mr-4">
                            <img src="https://randomuser.me/api/portraits/women/44.jpg" alt="Marie Lefevre" class="w-full h-full object-cover">
                        </div>
                        <div>
                            <h4 class="font-bold">Marie Lefevre</h4>
                            <p class="text-slate-400 text-sm">Responsable d'équipe</p>
                        </div>
                    </div>
                    <div class="stars mb-4">
                        ★★★★☆
                    </div>
                    <p class="text-slate-300 italic mb-4">
                        "La gestion des plannings est devenue un jeu d'enfant avec EM-Manager. Nous avons gagné un temps précieux et réduit les erreurs."
                    </p><br>
                    <div class="text-indigo-400 text-sm">
                        <i class="fas fa-building mr-2"></i> Entreprise B
                    </div>
                </div>
                
                <!-- Testimonial 3 -->
                <div class="testimonial-card p-8 rounded-2xl" data-aos="fade-up" data-aos-delay="300">
                    <div class="flex items-center mb-6">
                        <div class="w-16 h-16 rounded-full overflow-hidden mr-4">
                            <img src="https://randomuser.me/api/portraits/men/75.jpg" alt="Pierre Martin" class="w-full h-full object-cover">
                        </div>
                        <div>
                            <h4 class="font-bold">Pierre Martin</h4>
                            <p class="text-slate-400 text-sm">Chef de projet</p>
                        </div>
                    </div>
                    <div class="stars mb-4">
                        ★★★★★
                    </div>
                    <p class="text-slate-300 italic mb-4">
                        "Les analyses de performance nous ont permis d'identifier des axes d'amélioration concrets. Un outil indispensable pour toute entreprise moderne."
                    </p>
                    <div class="text-indigo-400 text-sm">
                        <i class="fas fa-building mr-2"></i> Entreprise C
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-20 bg-gradient-to-r from-indigo-600 to-purple-600 relative overflow-hidden">
        <div class="absolute inset-0 opacity-10">
            <div class="absolute inset-0 bg-[url('https://grainy-gradients.vercel.app/noise.svg')]"></div>
        </div>
        <div class="container mx-auto px-4 text-center relative z-10">
            <div class="max-w-3xl mx-auto" data-aos="fade-up">
                <h2 class="text-3xl md:text-4xl font-bold text-white mb-6">Prêt à révolutionner votre gestion RH ?</h2>
                <p class="text-xl text-indigo-100 mb-8">Rejoignez des centaines d'entreprises qui optimisent déjà leur gestion des ressources humaines avec EM-Manager.</p>
                <div class="flex flex-col sm:flex-row justify-center gap-4">
                    <a href="@auth {{route('dashboard_entreprise')}} @else {{route('register')}} @endauth" class="bg-white hover:bg-gray-100 text-indigo-600 font-bold py-3 px-8 rounded-full transition-all duration-300 transform hover:scale-105 shadow-lg inline-flex items-center">
                        <i class="fas fa-rocket mr-2"></i> @auth Commencer @else Essai @endauth
                    </a>
                    <a href="{{route('contact')}}" class="border-2 border-white text-white hover:bg-white hover:text-indigo-600 font-bold py-3 px-8 rounded-full transition-all duration-300 transform hover:scale-105 inline-flex items-center">
                        <i class="fas fa-envelope mr-2"></i> Nous contacter
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