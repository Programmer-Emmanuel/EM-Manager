<!DOCTYPE html>
<html lang="fr" class="scroll-smooth overflow-x-hidden">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nos Services - EM-Manager</title>
    <link rel="shortcut icon" href="images/management.png" type="image/x-icon">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Animation AOS.js -->
    @include('aos')
    
    <style>
        .service-card {
            transition: all 0.3s ease;
            transform: translateY(0);
        }
        .service-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }
        .icon-wrapper {
            width: 80px;
            height: 80px;
            margin: 0 auto 1.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            background: rgba(71, 85, 105, 0.1);
        }
        .divider {
            height: 3px;
            background: linear-gradient(90deg, transparent, #64748b, transparent);
        }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 overflow-x-hidden">
    <!-- Barre de navigation : nav.blade.php -->
    @include('nav')

    <!-- Hero Section -->
    <header class="relative bg-gradient-to-r from-slate-800 via-slate-700 to-slate-900 py-24 md:py-32 overflow-hidden" data-aos="fade-up" data-aos-duration="1000">
        <div class="absolute inset-0 opacity-20 bg-[url('https://images.unsplash.com/photo-1522071820081-009f0129c71c?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80')] bg-cover bg-center"></div>
        <div class="absolute inset-0 bg-gradient-to-t from-slate-900 to-transparent"></div>
        
        <div class="container mx-auto px-6 relative z-10">
            <div class="max-w-3xl mx-auto text-center">
                <h1 class="text-4xl md:text-5xl font-bold text-white mb-6 leading-tight">Solutions <span class="text-slate-300">RH Complètes</span></h1>
                <p class="text-lg md:text-xl text-slate-300 mb-8">Optimisez la gestion de vos ressources humaines avec nos outils performants et intuitifs.</p>
                <div class="flex flex-col sm:flex-row justify-center gap-4 mt-6">
                    <a href="{{route('dashboard_entreprise')}}" class="px-8 py-3 bg-slate-700 hover:bg-slate-600 text-white font-medium rounded-lg transition-all duration-300 transform hover:scale-105 shadow-lg">
                        <i class="fas fa-building mr-2"></i> Gérer mon entreprise
                    </a>
                    <a href="{{route('employe_dashboard')}}" class="px-8 py-3 bg-white hover:bg-slate-100 text-slate-800 font-medium rounded-lg transition-all duration-300 transform hover:scale-105 shadow-lg">
                        <i class="fas fa-user-tie mr-2"></i> Espace employé
                    </a>
                </div>
            </div>
        </div>
    </header>

    <!-- Services Section -->
    <section class="py-20 bg-slate-700" id="services">
        <div class="container mx-auto px-6">
            <div class="text-center mb-16" data-aos="fade-up">
                <h2 class="text-3xl md:text-4xl font-bold text-white mb-4">Nos Services Clés</h2>
                <div class="divider w-40 mx-auto mb-6"></div>
                <p class="text-lg text-white max-w-2xl mx-auto">Des solutions conçues pour simplifier et optimiser votre gestion des ressources humaines.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Service Card 1 -->
                <div class="service-card bg-slate-100 p-8 rounded-xl border border-slate-200 shadow-sm" data-aos="fade-up" data-aos-delay="100">
                    <div class="icon-wrapper text-slate-700">
                        <i class="fas fa-users text-3xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-slate-800 mb-4 text-center">Gestion des employés</h3>
                    <ul class="space-y-3 mb-6 text-slate-600">
                        <li class="flex items-start">
                            <i class="fas fa-check-circle text-slate-500 mt-1 mr-2"></i>
                            <span>Ajout, modification et suppression des profils</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-check-circle text-slate-500 mt-1 mr-2"></i>
                            <span>Stockage sécurisé des informations</span>
                        </li>
                    </ul>
                    <a href="{{route('dashboard_entreprise')}}" class="block text-center px-6 py-2 bg-slate-700 hover:bg-slate-800 text-white rounded-lg transition-all font-medium">
                        Démarrer <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>

                <!-- Service Card 2 -->
                <div class="service-card bg-slate-100 p-8 rounded-xl border border-slate-200 shadow-sm" data-aos="fade-up" data-aos-delay="200">
                    <div class="icon-wrapper text-slate-700">
                        <i class="fas fa-calendar-day text-3xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-slate-800 mb-4 text-center">Gestion des congés</h3>
                    <ul class="space-y-3 mb-6 text-slate-600">
                        <li class="flex items-start">
                            <i class="fas fa-check-circle text-slate-500 mt-1 mr-2"></i>
                            <span>Demandes de congés en ligne</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-check-circle text-slate-500 mt-1 mr-2"></i>
                            <span>Calcul automatique des soldes</span>
                        </li>
                    </ul><br><br>
                    <a href="{{route('dashboard_entreprise')}}" class="block text-center px-6 py-2 bg-slate-700 hover:bg-slate-800 text-white rounded-lg transition-all font-medium">
                        Démarrer <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>

                <!-- Service Card 3 -->
                <div class="service-card bg-slate-100 p-8 rounded-xl border border-slate-200 shadow-sm" data-aos="fade-up" data-aos-delay="300">
                    <div class="icon-wrapper text-slate-700">
                        <i class="fas fa-clock text-3xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-slate-800 mb-4 text-center">Suivi des temps</h3>
                    <ul class="space-y-3 mb-6 text-slate-600">
                        <li class="flex items-start">
                            <i class="fas fa-check-circle text-slate-500 mt-1 mr-2"></i>
                            <span>Intégration avec pointeuse</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-check-circle text-slate-500 mt-1 mr-2"></i>
                            <span>Rapports des heures travaillées</span>
                        </li>
                    </ul><br>
                    <a href="{{route('dashboard_entreprise')}}" class="block text-center px-6 py-2 bg-slate-700 hover:bg-slate-800 text-white rounded-lg transition-all font-medium">
                        Démarrer <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>

                <!-- Service Card 4 -->
                <div class="service-card bg-slate-100 p-8 rounded-xl border border-slate-200 shadow-sm" data-aos="fade-up" data-aos-delay="400">
                    <div class="icon-wrapper text-slate-700">
                        <i class="fas fa-money-bill-wave text-3xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-slate-800 mb-4 text-center">Traitement des paies</h3>
                    <ul class="space-y-3 mb-6 text-slate-600">
                        <li class="flex items-start">
                            <i class="fas fa-check-circle text-slate-500 mt-1 mr-2"></i>
                            <span>Génération automatique</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-check-circle text-slate-500 mt-1 mr-2"></i>
                            <span>Export PDF/Excel</span>
                        </li>
                    </ul>
                    <a href="{{route('dashboard_entreprise')}}" class="block text-center px-6 py-2 bg-slate-700 hover:bg-slate-800 text-white rounded-lg transition-all font-medium">
                        Démarrer <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>

                <!-- Service Card 5 -->
                <div class="service-card bg-slate-100 p-8 rounded-xl border border-slate-200 shadow-sm" data-aos="fade-up" data-aos-delay="500">
                    <div class="icon-wrapper text-slate-700">
                        <i class="fas fa-star-half-alt text-3xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-slate-800 mb-4 text-center">Évaluations</h3>
                    <ul class="space-y-3 mb-6 text-slate-600">
                        <li class="flex items-start">
                            <i class="fas fa-check-circle text-slate-500 mt-1 mr-2"></i>
                            <span>Évaluations périodiques</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-check-circle text-slate-500 mt-1 mr-2"></i>
                            <span>Suivi des objectifs</span>
                        </li>
                    </ul>
                    <a href="{{route('dashboard_entreprise')}}" class="block text-center px-6 py-2 bg-slate-700 hover:bg-slate-800 text-white rounded-lg transition-all font-medium">
                        Démarrer <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>

                <!-- Service Card 6 -->
                <div class="service-card bg-slate-100 p-8 rounded-xl border border-slate-200 shadow-sm" data-aos="fade-up" data-aos-delay="600">
                    <div class="icon-wrapper text-slate-700">
                        <i class="fas fa-chart-line text-3xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-slate-800 mb-4 text-center">Analytique RH</h3>
                    <ul class="space-y-3 mb-6 text-slate-600">
                        <li class="flex items-start">
                            <i class="fas fa-check-circle text-slate-500 mt-1 mr-2"></i>
                            <span>Tableaux de bord visuels</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-check-circle text-slate-500 mt-1 mr-2"></i>
                            <span>Indicateurs stratégiques</span>
                        </li>
                    </ul>
                    <a href="{{route('dashboard_entreprise')}}" class="block text-center px-6 py-2 bg-slate-700 hover:bg-slate-800 text-white rounded-lg transition-all font-medium">
                        Démarrer <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-20 bg-slate-100">
        <div class="container mx-auto px-6">
            <div class="text-center mb-16" data-aos="fade-up">
                <h2 class="text-3xl md:text-4xl font-bold text-slate-800 mb-4">Pourquoi choisir EM-Manager ?</h2>
                <div class="divider w-40 mx-auto mb-6"></div>
                <p class="text-lg text-slate-600 max-w-2xl mx-auto">Les avantages qui font la différence pour votre entreprise</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-white p-8 rounded-xl shadow-sm border border-slate-200" data-aos="fade-up" data-aos-delay="100">
                    <div class="text-slate-700 text-4xl mb-4">
                        <i class="fas fa-lock"></i>
                    </div>
                    <h3 class="text-xl font-bold text-slate-800 mb-3">Sécurité des données</h3>
                    <p class="text-slate-600">Protection avancée de vos informations sensibles avec chiffrement des données.</p>
                </div>

                <div class="bg-white p-8 rounded-xl shadow-sm border border-slate-200" data-aos="fade-up" data-aos-delay="200">
                    <div class="text-slate-700 text-4xl mb-4">
                        <i class="fas fa-mobile-alt"></i>
                    </div>
                    <h3 class="text-xl font-bold text-slate-800 mb-3">Accessibilité</h3>
                    <p class="text-slate-600">Accédez à votre espace depuis n'importe quel appareil, à tout moment.</p>
                </div>

                <div class="bg-white p-8 rounded-xl shadow-sm border border-slate-200" data-aos="fade-up" data-aos-delay="300">
                    <div class="text-slate-700 text-4xl mb-4">
                        <i class="fas fa-headset"></i>
                    </div>
                    <h3 class="text-xl font-bold text-slate-800 mb-3">Support réactif</h3>
                    <p class="text-slate-600">Notre équipe est disponible pour vous accompagner dans votre utilisation.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-16 bg-gradient-to-r from-slate-800 to-slate-700">
        <div class="container mx-auto px-6 text-center">
            <div class="max-w-3xl mx-auto" data-aos="fade-up">
                <h2 class="text-3xl font-bold text-white mb-6">Prêt à optimiser votre gestion RH ?</h2>
                <p class="text-xl text-slate-300 mb-8">Rejoignez notre communauté d'entreprises satisfaites dès aujourd'hui.</p>
                <div class="flex flex-col sm:flex-row justify-center gap-4">
                    <a href="{{route('dashboard_entreprise')}}" class="px-8 py-3 bg-white hover:bg-slate-100 text-slate-800 font-bold rounded-lg transition-all duration-300 transform hover:scale-105 shadow-lg">
                        <i class="fas fa-rocket mr-2"></i> Commencer
                    </a>
                    <a href="{{route('contact')}}" class="px-8 py-3 border-2 border-white text-white hover:bg-white hover:text-slate-800 font-bold rounded-lg transition-all duration-300 transform hover:scale-105">
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
</body>
</html>