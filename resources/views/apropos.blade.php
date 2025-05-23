<!DOCTYPE html>
<html lang="fr" class="scroll-smooth overflow-x-hidden">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>À Propos - EM-Manager</title>
    <link rel="shortcut icon" href="images/management.png" type="image/x-icon">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Animation AOS.js -->
    @include('aos')
    
    <style>
        .team-card {
            transition: all 0.3s ease;
            transform: translateY(0);
        }
        .team-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.2);
        }
        .icon-circle {
            width: 100px;
            height: 100px;
            margin: 0 auto 1.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            background: linear-gradient(135deg, #3b82f6 0%, #1e40af 100%);
        }
    </style>
</head>
<body class="bg-slate-900 text-white overflow-x-hidden">
    <!-- Barre de navigation : nav.blade.php -->
    @include('nav')

    <!-- Hero Section -->
    <header class="relative bg-gradient-to-r from-slate-800 via-slate-700 to-slate-900 py-24 md:py-32 overflow-hidden">
        <div class="absolute inset-0 opacity-20 bg-[url('https://images.unsplash.com/photo-1522071820081-009f0129c71c?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80')] bg-cover bg-center"></div>
        <div class="absolute inset-0 bg-gradient-to-t from-slate-900 to-transparent"></div>
        
        <div class="container mx-auto px-6 relative z-10 text-center" data-aos="fade-up" data-aos-duration="800">
            <h1 class="text-4xl md:text-5xl font-bold mb-6 leading-tight">Votre partenaire en <span class="text-blue-400">gestion RH</span></h1>
            <p class="text-xl text-gray-300 max-w-3xl mx-auto mb-8">Une solution complète et innovante pour optimiser la gestion de vos employés et ressources humaines.</p>
            <div class="flex flex-col sm:flex-row justify-center gap-4">
                <a href="{{route('service')}}" class="px-8 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-all duration-300 transform hover:scale-105 shadow-lg">
                    <i class="fas fa-briefcase mr-2"></i> Nos services
                </a>
                <a href="{{route('contact')}}" class="px-8 py-3 border-2 border-white text-white hover:bg-white hover:text-slate-900 font-medium rounded-lg transition-all duration-300 transform hover:scale-105">
                    <i class="fas fa-envelope mr-2"></i> Nous contacter
                </a>
            </div>
        </div>
    </header>

    <!-- About Section -->
    <section class="py-20 bg-slate-800" id="apropos">
        <div class="container mx-auto px-6">
            <!-- Mission -->
            <div class="max-w-4xl mx-auto mb-20" data-aos="fade-up" data-aos-duration="800">
                <div class="flex flex-col md:flex-row items-center gap-8">
                    <div class="md:w-1/3 flex justify-center">
                        <div class="icon-circle text-white text-4xl">
                            <i class="fas fa-bullseye"></i>
                        </div>
                    </div>
                    <div class="md:w-2/3">
                        <h2 class="text-3xl font-bold mb-6 text-white">Notre Mission</h2>
                        <p class="text-lg text-gray-300 leading-relaxed">
                            Chez EM-Manager, nous nous engageons à révolutionner la gestion RH en proposant des solutions innovantes, simples et efficaces. Notre plateforme a été conçue pour aider les entreprises de toutes tailles à optimiser la gestion de leurs équipes, des congés aux paies, en passant par le suivi des performances.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Vision -->
            <div class="max-w-4xl mx-auto mb-20" data-aos="fade-up" data-aos-duration="800" data-aos-delay="100">
                <div class="flex flex-col md:flex-row-reverse items-center gap-8">
                    <div class="md:w-1/3 flex justify-center">
                        <div class="icon-circle text-white text-4xl">
                            <i class="fas fa-eye"></i>
                        </div>
                    </div>
                    <div class="md:w-2/3">
                        <h2 class="text-3xl font-bold mb-6 text-white">Notre Vision</h2>
                        <p class="text-lg text-gray-300 leading-relaxed">
                            Nous aspirons à devenir la référence en matière de solutions RH numériques, permettant aux entreprises de se concentrer sur leur cœur de métier tout en automatisant et simplifiant leurs processus administratifs. Notre objectif est d'accompagner la transformation digitale des services RH.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Valeurs -->
            <div class="max-w-4xl mx-auto mb-20" data-aos="fade-up" data-aos-duration="800" data-aos-delay="200">
                <div class="flex flex-col md:flex-row items-center gap-8">
                    <div class="md:w-1/3 flex justify-center">
                        <div class="icon-circle text-white text-4xl">
                            <i class="fas fa-heart"></i>
                        </div>
                    </div>
                    <div class="md:w-2/3">
                        <h2 class="text-3xl font-bold mb-6 text-white">Nos Valeurs</h2>
                        <ul class="space-y-4 text-gray-300">
                            <li class="flex items-start">
                                <i class="fas fa-check-circle text-blue-400 mt-1 mr-3"></i>
                                <span><strong>Innovation :</strong> Nous repoussons constamment les limites pour offrir des solutions avant-gardistes.</span>
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-check-circle text-blue-400 mt-1 mr-3"></i>
                                <span><strong>Simplicité :</strong> Des outils intuitifs pour une prise en main immédiate.</span>
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-check-circle text-blue-400 mt-1 mr-3"></i>
                                <span><strong>Engagement :</strong> Un accompagnement personnalisé pour chaque client.</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Team Section -->
    <section class="py-20 bg-slate-900">
        <div class="container mx-auto px-6">
            <div class="text-center mb-16" data-aos="fade-up">
                <h2 class="text-3xl md:text-4xl font-bold text-white mb-4">Rencontrez notre équipe</h2>
                <div class="w-20 h-1 bg-blue-500 mx-auto mb-6"></div>
                <p class="text-lg text-gray-400 max-w-2xl mx-auto">Une équipe passionnée dédiée à votre succès</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8" data-aos="fade-up" data-aos-duration="800">
                <!-- Team Member 1 -->
                <div class="team-card bg-slate-800 p-8 rounded-xl text-center">
                    <div class="w-32 h-32 mx-auto mb-6 rounded-full overflow-hidden border-4 border-blue-500">
                        <img src="/images/WhatsApp Image 2025-05-17 à 10.16.48_3684913b.jpg" 
                             alt="Emmanuel Bamidélé" class="w-full h-full object-cover">
                    </div>
                    <h3 class="text-xl font-bold text-white mb-2">Emmanuel Bamidélé</h3>
                    <p class="text-blue-400 font-medium mb-4">CEO & Fondateur</p>
                    <p class="text-gray-400 mb-4">Visionnaire et entrepreneur passionné par l'innovation RH.</p><br>
                    <div class="flex justify-center space-x-4">
                        <a href="{{ route('contact') }}" class="text-gray-400 hover:text-blue-400 transition-colors">
                            <i class="fab fa-linkedin-in text-lg"></i>
                        </a>
                        <a href="{{ route('contact') }}" class="text-gray-400 hover:text-blue-400 transition-colors">
                            <i class="fab fa-facebook text-lg"></i>
                        </a>
                    </div>
                </div>

                <!-- Team Member 2 -->
                <div class="team-card bg-slate-800 p-8 rounded-xl text-center">
                    <div class="w-32 h-32 mx-auto mb-6 rounded-full overflow-hidden border-4 border-blue-500">
                        <img src="/images/WhatsApp Image 2025-05-17 à 10.16.48_3684913b.jpg" 
                             alt="Emmanuel Bamidélé" class="w-full h-full object-cover">
                    </div>
                    <h3 class="text-xl font-bold text-white mb-2">Emmanuel Bamidélé</h3>
                    <p class="text-blue-400 font-medium mb-4">Responsable Produit</p>
                    <p class="text-gray-400 mb-4">Expert en conception d'expériences utilisateur optimales.</p>
                    <div class="flex justify-center space-x-4">
                        <a href="{{ route('contact') }}" class="text-gray-400 hover:text-blue-400 transition-colors">
                            <i class="fab fa-linkedin-in text-lg"></i>
                        </a>
                        <a href="{{ route('contact') }}" class="text-gray-400 hover:text-blue-400 transition-colors">
                            <i class="fab fa-facebook text-lg"></i>
                        </a>
                    </div>
                </div>

                <!-- Team Member 3 -->
                <div class="team-card bg-slate-800 p-8 rounded-xl text-center">
                    <div class="w-32 h-32 mx-auto mb-6 rounded-full overflow-hidden border-4 border-blue-500">
                        <img src="/images/WhatsApp Image 2025-05-17 à 10.16.48_3684913b.jpg" 
                             alt="Emmanuel Bamidélé" class="w-full h-full object-cover">
                    </div>
                    <h3 class="text-xl font-bold text-white mb-2">Emmanuel Bamidélé</h3>
                    <p class="text-blue-400 font-medium mb-4">Développeur Principal</p>
                    <p class="text-gray-400 mb-4">Architecte des solutions techniques les plus performantes.</p><br>
                    <div class="flex justify-center space-x-4">
                        <a href="{{ route('contact') }}" class="text-gray-400 hover:text-blue-400 transition-colors">
                            <i class="fab fa-linkedin-in text-lg"></i>
                        </a>
                        <a href="{{ route('contact') }}" class="text-gray-400 hover:text-blue-400 transition-colors">
                            <i class="fab fa-facebook text-lg"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-16 bg-gradient-to-r from-blue-600 to-blue-800">
        <div class="container mx-auto px-6 text-center">
            <div class="max-w-3xl mx-auto" data-aos="fade-up">
                <h2 class="text-3xl font-bold text-white mb-6">Prêt à révolutionner votre gestion RH ?</h2>
                <p class="text-xl text-blue-100 mb-8">Rejoignez notre communauté d'entreprises satisfaites et découvrez comment EM-Manager peut transformer votre quotidien.</p>
                <div class="flex flex-col sm:flex-row justify-center gap-4">
                    <a href="{{route('register')}}" class="px-8 py-3 bg-white hover:bg-gray-100 text-blue-800 font-bold rounded-lg transition-all duration-300 transform hover:scale-105 shadow-lg">
                        <i class="fas fa-play-circle mr-2"></i> S’inscire
                    </a>
                    <a href="{{ route('dashboard_entreprise') }}" class="px-8 py-3 border-2 border-white text-white hover:bg-white hover:text-blue-800 font-bold rounded-lg transition-all duration-300 transform hover:scale-105">
                        <i class="fas fa-desktop mr-2"></i> Commencer maintenant
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