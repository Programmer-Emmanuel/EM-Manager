<!DOCTYPE html>
<html lang="fr" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact | EM-Manager</title>
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
        
        .contact-card {
            background: rgba(30, 41, 59, 0.6);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(99, 102, 241, 0.2);
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }
        
        .contact-card:hover {
            transform: translateY(-8px);
            border-color: rgba(99, 102, 241, 0.5);
            box-shadow: 0 20px 35px -12px rgba(99, 102, 241, 0.3);
        }
        
        .whatsapp-card {
            background: linear-gradient(135deg, rgba(37, 211, 102, 0.2), rgba(18, 140, 126, 0.1));
            border-color: rgba(37, 211, 102, 0.3);
        }
        
        .whatsapp-card:hover {
            border-color: #25D366;
        }
        
        .github-card {
            background: linear-gradient(135deg, rgba(51, 51, 51, 0.2), rgba(13, 17, 23, 0.1));
            border-color: rgba(51, 51, 51, 0.3);
        }
        
        .github-card:hover {
            border-color: #ffffff;
        }
        
        .linkedin-card {
            background: linear-gradient(135deg, rgba(0, 119, 181, 0.2), rgba(10, 102, 194, 0.1));
            border-color: rgba(0, 119, 181, 0.3);
        }
        
        .linkedin-card:hover {
            border-color: #0077B5;
        }
        
        .icon-circle {
            width: 80px;
            height: 80px;
            background: rgba(99, 102, 241, 0.2);
            border-radius: 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            transition: all 0.3s ease;
        }
        
        .contact-card:hover .icon-circle {
            transform: scale(1.05);
            background: rgba(99, 102, 241, 0.3);
        }
        
        .icon-circle i {
            font-size: 2.5rem;
            color: #818cf8;
        }
        
        .whatsapp-card .icon-circle i {
            color: #25D366;
        }
        
        .github-card .icon-circle i {
            color: #ffffff;
        }
        
        .linkedin-card .icon-circle i {
            color: #0077B5;
        }
        
        .btn-social {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            transition: all 0.3s ease;
        }
        
        .btn-social:hover {
            background: rgba(255, 255, 255, 0.2);
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
        
        .info-item {
            background: rgba(15, 23, 42, 0.5);
            backdrop-filter: blur(8px);
            border: 1px solid rgba(99, 102, 241, 0.15);
            transition: all 0.3s ease;
        }
        
        .info-item:hover {
            border-color: rgba(99, 102, 241, 0.4);
            transform: scale(1.02);
        }
        
        .floating-wa {
            animation: pulse-wa 2s ease-in-out infinite;
        }
        
        @keyframes pulse-wa {
            0%, 100% {
                transform: scale(1);
                box-shadow: 0 0 0 0 rgba(37, 211, 102, 0.7);
            }
            50% {
                transform: scale(1.05);
                box-shadow: 0 0 0 10px rgba(37, 211, 102, 0);
            }
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }
        
        .float-animation {
            animation: float 6s ease-in-out infinite;
        }
        
        .gradient-text {
            background: linear-gradient(135deg, #6366f1, #8b5cf6, #a855f7);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }
    </style>
</head>
<body class="antialiased">

    <!-- Navigation -->
    @include('nav')

    <!-- Main Content -->
    <main class="min-h-screen py-20 px-4 sm:px-6 lg:px-8 relative overflow-hidden">
        <!-- Éléments décoratifs -->
        <div class="absolute top-20 left-10 w-72 h-72 bg-indigo-500 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-pulse"></div>
        <div class="absolute bottom-20 right-10 w-96 h-96 bg-purple-500 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-pulse" style="animation-delay: 2s;"></div>
        
        <div class="max-w-7xl mx-auto relative z-10">
            <!-- Header Section -->
            <div class="text-center mb-16" data-aos="fade-up">
                <span class="section-badge">
                    <i class="fas fa-address-card mr-2"></i> Restons en contact
                </span>
                <h1 class="text-4xl md:text-5xl font-bold text-white mb-4">
                    Connectons-<span class="gradient-text">nous</span>
                </h1>
                <p class="text-lg text-slate-400 max-w-2xl mx-auto leading-relaxed">
                    Discutons de votre projet ou explorons comment EM-Manager peut répondre à vos besoins en gestion RH.
                </p>
            </div>
            
            <!-- Social Cards Grid -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-5xl mx-auto">
                <!-- WhatsApp Card -->
                <div class="contact-card whatsapp-card rounded-2xl overflow-hidden" data-aos="fade-up" data-aos-delay="100">
                    <div class="p-8 text-center">
                        <div class="icon-circle">
                            <i class="fab fa-whatsapp"></i>
                        </div>
                        <h2 class="text-2xl font-bold text-white mb-3">WhatsApp</h2>
                        <p class="text-slate-400 mb-6">Contact direct et réponses rapides</p>
                        <a href="https://wa.me/2250140022693" 
                           class="btn-social inline-flex items-center gap-2 text-white font-medium py-3 px-6 rounded-full transition-all"
                           target="_blank">
                           <i class="fab fa-whatsapp"></i>
                           <span>Envoyer un message</span>
                           <i class="fas fa-arrow-right text-sm"></i>
                        </a>
                    </div>
                    <div class="bg-black/20 p-4 text-center text-sm text-slate-400">
                        <i class="fas fa-clock mr-1"></i> Réponse sous 24h
                    </div>
                </div>
                
                <!-- GitHub Card -->
                <div class="contact-card github-card rounded-2xl overflow-hidden" data-aos="fade-up" data-aos-delay="200">
                    <div class="p-8 text-center">
                        <div class="icon-circle">
                            <i class="fab fa-github"></i>
                        </div>
                        <h2 class="text-2xl font-bold text-white mb-3">GitHub</h2>
                        <p class="text-slate-400 mb-6">Découvrez mes projets open-source</p>
                        <a href="https://github.com/Programmer-Emmanuel" 
                           class="btn-social inline-flex items-center gap-2 text-white font-medium py-3 px-6 rounded-full transition-all"
                           target="_blank">
                           <i class="fab fa-github"></i>
                           <span>Voir mes repositories</span>
                           <i class="fas fa-arrow-right text-sm"></i>
                        </a>
                    </div>
                    <div class="bg-black/20 p-4 text-center text-sm text-slate-400">
                        <i class="fas fa-star mr-1"></i> Contributions bienvenues
                    </div>
                </div>
                
                <!-- LinkedIn Card -->
                <div class="contact-card linkedin-card rounded-2xl overflow-hidden" data-aos="fade-up" data-aos-delay="300">
                    <div class="p-8 text-center">
                        <div class="icon-circle">
                            <i class="fab fa-linkedin-in"></i>
                        </div>
                        <h2 class="text-2xl font-bold text-white mb-3">LinkedIn</h2>
                        <p class="text-slate-400 mb-6">Connectons-nous professionnellement</p>
                        <a href="https://www.linkedin.com/in/emmanuel-bamidele-b63a49274" 
                           class="btn-social inline-flex items-center gap-2 text-white font-medium py-3 px-6 rounded-full transition-all"
                           target="_blank">
                           <i class="fab fa-linkedin-in"></i>
                           <span>Visiter mon profil</span>
                           <i class="fas fa-arrow-right text-sm"></i>
                        </a>
                    </div>
                    <div class="bg-black/20 p-4 text-center text-sm text-slate-400">
                        <i class="fas fa-briefcase mr-1"></i> Opportunités professionnelles
                    </div>
                </div>
            </div>
            
            <!-- Additional Contact Info -->
            <div class="max-w-3xl mx-auto mt-20" data-aos="fade-up">
                <div class="text-center mb-8">
                    <span class="section-badge">
                        <i class="fas fa-phone-alt mr-2"></i> Autres moyens
                    </span>
                    <h2 class="text-2xl font-bold text-white mt-4">Restez en contact</h2>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="info-item p-6 rounded-xl flex items-start gap-4">
                        <div class="w-12 h-12 rounded-lg bg-indigo-500/20 flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-envelope text-indigo-400 text-xl"></i>
                        </div>
                        <div>
                            <h3 class="font-semibold text-white mb-1">Email</h3>
                            <p class="text-slate-400">marcbamidele@gmail.com</p>
                        </div>
                    </div>
                    
                    <div class="info-item p-6 rounded-xl flex items-start gap-4">
                        <div class="w-12 h-12 rounded-lg bg-indigo-500/20 flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-phone-alt text-indigo-400 text-xl"></i>
                        </div>
                        <div>
                            <h3 class="font-semibold text-white mb-1">Téléphone</h3>
                            <p class="text-slate-400">+225 01 40 02 26 93</p>
                        </div>
                    </div>
                </div>
                
                <div class="mt-8 p-6 rounded-xl bg-indigo-500/10 border border-indigo-500/20 text-center">
                    <p class="text-slate-300">
                        <i class="fas fa-clock text-indigo-400 mr-2"></i>
                        Disponible du lundi au vendredi, de 9h à 18h
                    </p>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    @include('footer')

    <!-- Chargement de la page avec loading spinner -->
    @include('loading')

    <!-- Floating WhatsApp Button -->
    <div class="fixed bottom-8 right-8 z-50" data-aos="fade-up" data-aos-delay="500">
        <a href="https://wa.me/2250140022693" 
           class="w-14 h-14 bg-[#25D366] text-white rounded-full flex items-center justify-center text-2xl shadow-lg floating-wa transition-all hover:scale-110"
           target="_blank">
           <i class="fab fa-whatsapp"></i>
        </a>
    </div>
</body>
</html>