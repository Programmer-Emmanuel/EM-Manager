<!DOCTYPE html>
<html lang="fr" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact | Développeur EM-Manager</title>
    <link rel="shortcut icon" href="images/management.png" type="image/x-icon">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    @vite('resources/css/app.css')
    @include('aos')
    
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
        
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8fafc;
            color: #0f172a;
        }
        
        .social-card {
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(15, 23, 42, 0.1);
        }
        
        .social-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 25px -5px rgba(15, 23, 42, 0.1), 0 10px 10px -5px rgba(15, 23, 42, 0.04);
        }
        
        .whatsapp-card {
            background: linear-gradient(145deg, #25D366 0%, #128C7E 100%);
        }
        
        .github-card {
            background: linear-gradient(145deg, #333 0%, #0d1117 100%);
        }
        
        .linkedin-card {
            background: linear-gradient(145deg, #0077B5 0%, #0A66C2 100%);
        }
        
        .btn-social {
            transition: all 0.3s ease;
        }
        
        .btn-social:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        }
        
        .glow {
            animation: glow 2s infinite alternate;
        }
        
        @keyframes glow {
            from {
                box-shadow: 0 0 10px rgba(37, 211, 102, 0.5);
            }
            to {
                box-shadow: 0 0 20px rgba(37, 211, 102, 0.8);
            }
        }
    </style>
</head>
<body class="antialiased">

    <!-- Navigation -->
    @include('nav')

    <!-- Main Content -->
    <main class="min-h-[80vh] py-16 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            <!-- Header Section -->
            <div class="text-center mb-16" data-aos="fade-up">
                <h1 class="text-4xl md:text-5xl font-bold text-slate-900 mb-4">Connectons-nous</h1>
                <div class="w-20 h-1 bg-slate-300 mx-auto mb-6"></div>
                <p class="text-lg text-slate-600 max-w-2xl mx-auto">
                    Discutons de votre projet ou explorons comment EM-Manager peut répondre à vos besoins en gestion RH.
                </p>
            </div>
            
            <!-- Social Cards Grid -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-6xl mx-auto">
                <!-- WhatsApp Card -->
                <div class="social-card whatsapp-card text-white rounded-xl overflow-hidden shadow-xl" data-aos="fade-up" data-aos-delay="100">
                    <div class="p-8 text-center">
                        <div class="w-20 h-20 mx-auto mb-6 rounded-full bg-white/20 flex items-center justify-center text-3xl">
                            <i class="fab fa-whatsapp"></i>
                        </div>
                        <h2 class="text-2xl font-bold mb-3">WhatsApp</h2>
                        <p class="text-white/90 mb-6">Contact direct et réponses rapides</p><br>
                        <a href="https://wa.me/2250140022693" 
                           class="btn-social inline-block bg-white text-slate-900 font-semibold py-3 px-6 rounded-full"
                           target="_blank">
                           <i class="fas fa-comment-dots mr-2"></i> Envoyer un message
                        </a>
                    </div>
                    <div class="bg-black/10 p-4 text-center text-sm">
                        <i class="fas fa-clock mr-1"></i> Réponse sous 24h
                    </div>
                </div>
                
                <!-- GitHub Card -->
                <div class="social-card github-card text-white rounded-xl overflow-hidden shadow-xl" data-aos="fade-up" data-aos-delay="200">
                    <div class="p-8 text-center">
                        <div class="w-20 h-20 mx-auto mb-6 rounded-full bg-white/20 flex items-center justify-center text-3xl">
                            <i class="fab fa-github"></i>
                        </div>
                        <h2 class="text-2xl font-bold mb-3">GitHub</h2>
                        <p class="text-white/90 mb-6">Découvrez mes projets open-source</p><br>
                        <a href="https://github.com/Programmer-Emmanuel" 
                           class="btn-social inline-block bg-white text-slate-900 font-semibold py-3 px-6 rounded-full"
                           target="_blank">
                           <i class="fas fa-code-branch mr-2"></i> Voir mes repositories
                        </a>
                    </div>
                    <div class="bg-black/10 p-4 text-center text-sm">
                        <i class="fas fa-star mr-1"></i> Contributions bienvenues
                    </div>
                </div>
                
                <!-- LinkedIn Card -->
                <div class="social-card linkedin-card text-white rounded-xl overflow-hidden shadow-xl" data-aos="fade-up" data-aos-delay="300">
                    <div class="p-8 text-center">
                        <div class="w-20 h-20 mx-auto mb-6 rounded-full bg-white/20 flex items-center justify-center text-3xl">
                            <i class="fab fa-linkedin-in"></i>
                        </div>
                        <h2 class="text-2xl font-bold mb-3">LinkedIn</h2>
                        <p class="text-white/90 mb-6">Connectons-nous professionnellement</p>
                        <a href="https://www.linkedin.com/in/emmanuel-bamidele-b63a49274" 
                           class="btn-social inline-block bg-white text-slate-900 font-semibold py-3 px-6 rounded-full"
                           target="_blank">
                           <i class="fas fa-user-plus mr-2"></i> Visiter mon profil
                        </a>
                    </div>
                    <div class="bg-black/10 p-4 text-center text-sm">
                        <i class="fas fa-briefcase mr-1"></i> Opportunités professionnelles
                    </div>
                </div>
            </div>
            
            <!-- Additional Contact Info -->
            <div class="max-w-2xl mx-auto mt-20 bg-white rounded-xl shadow-lg p-8" data-aos="fade-up">
                <h2 class="text-2xl font-bold text-slate-800 mb-6 text-center">Autres moyens de contact</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="flex items-start">
                        <div class="bg-slate-100 p-3 rounded-lg mr-4">
                            <i class="fas fa-envelope text-slate-700 text-xl"></i>
                        </div>
                        <div>
                            <h3 class="font-semibold text-slate-800">Email</h3>
                            <p class="text-slate-600">marcbamidele@gmail.com</p>
                        </div>
                    </div>
                    <div class="flex items-start">
                        <div class="bg-slate-100 p-3 rounded-lg mr-4">
                            <i class="fas fa-phone-alt text-slate-700 text-xl"></i>
                        </div>
                        <div>
                            <h3 class="font-semibold text-slate-800">Téléphone</h3>
                            <p class="text-slate-600">+225 01 40 02 26 93</p>
                        </div>
                    </div>
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
           class="w-16 h-16 bg-[#25D366] text-white rounded-full flex items-center justify-center text-2xl shadow-lg glow"
           target="_blank">
           <i class="fab fa-whatsapp"></i>
        </a>
    </div>
</body>
</html>