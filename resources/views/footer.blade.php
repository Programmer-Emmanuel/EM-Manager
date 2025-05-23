<style>
    .footer-link {
        position: relative;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        padding: 0.5rem 0;
    }
    
    .footer-link::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 0;
        height: 2px;
        background: linear-gradient(90deg, #6366f1, #8b5cf6);
        transition: width 0.3s ease;
    }
    
    .footer-link:hover::after {
        width: 100%;
    }
    
    .built-by {
        background: linear-gradient(90deg, #6366f1, #8b5cf6, #d946ef);
        -webkit-background-clip: text;
        background-clip: text;
        color: transparent;
        font-weight: 600;
        position: relative;
    }
    
    .built-by::after {
        content: '';
        position: absolute;
        bottom: -2px;
        left: 0;
        width: 0;
        height: 1px;
        background: linear-gradient(90deg, #6366f1, #8b5cf6);
        transition: width 0.3s ease;
    }
    
    .built-by:hover::after {
        width: 100%;
    }
    
    .social-icon {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        transform: translateY(0);
    }
    
    .social-icon:hover {
        transform: translateY(-4px);
    }
    
    .whatsapp-icon:hover {
        box-shadow: 0 0 20px rgba(37, 211, 102, 0.4);
    }
    
    .github-icon:hover {
        box-shadow: 0 0 20px rgba(36, 41, 46, 0.4);
    }
    
    .linkedin-icon:hover {
        box-shadow: 0 0 20px rgba(10, 102, 194, 0.4);
    }
    
    .logo-divider {
        transition: all 0.3s ease;
    }
    
    .logo-container:hover .logo-divider {
        background: linear-gradient(90deg, #6366f1, #8b5cf6);
    }
</style>

<footer class="bg-slate-900 text-white pt-16 pb-10 border-t border-slate-700/50 relative overflow-hidden">
    <!-- Effets décoratifs -->
    <div class="absolute -top-32 -left-32 w-64 h-64 bg-indigo-500 rounded-full mix-blend-multiply filter blur-3xl opacity-10 animate-float-slow"></div>
    <div class="absolute -bottom-32 -right-32 w-64 h-64 bg-purple-500 rounded-full mix-blend-multiply filter blur-3xl opacity-10 animate-float-slow animation-delay-2000"></div>
    
    <div class="container mx-auto px-6 relative z-10">
        <!-- Contenu principal -->
        <div class="flex flex-col lg:flex-row justify-between items-center">
            <!-- Logo et copyright -->
            <div class="mb-8 lg:mb-0 flex items-center logo-container">
                <a href="{{ route('accueil') }}" class="flex items-center group">
                    <img class="h-10 w-10 rounded-full group-hover:rotate-12 transition-transform duration-300" src="/images/management.png" alt="EM-Manager">
                    <span class="ml-3 text-xl font-bold text-white group-hover:text-indigo-300 transition-colors duration-300">EM-Manager</span>
                    <div class="logo-divider border-r-2 border-white h-6 mx-4"></div>
                </a>
                <p class="text-white hidden md:block">&copy; {{ date('Y') }}</p>
            </div>
            
            <!-- Liens -->
            <div class="flex flex-wrap justify-center gap-8 mb-8 lg:mb-0">
                <div class="flex flex-col sm:flex-row gap-8">
                    <div class="flex flex-col items-center sm:items-start">
                        <h3 class="text-sm font-semibold text-slate-400 mb-3">NAVIGATION</h3>
                        <div class="flex flex-col items-center sm:items-start gap-2">
                            <a href="{{ route('accueil') }}" class="footer-link text-white hover:text-indigo-300">Accueil</a>
                            <a href="{{ route('apropos') }}" class="footer-link text-white hover:text-indigo-300">À propos</a>
                            <a href="{{ route('service') }}" class="footer-link text-white hover:text-indigo-300">Services</a>
                        </div>
                    </div>
                    
                    <div class="flex flex-col items-center sm:items-start">
                        <h3 class="text-sm font-semibold text-slate-400 mb-3">LEGAL</h3>
                        <div class="flex flex-col items-center sm:items-start gap-2">
                            <a href="{{ route('contact') }}" class="footer-link text-white hover:text-indigo-300">Contact</a>
                            <a href="#" class="footer-link text-white hover:text-indigo-300">Mentions légales</a>
                            <a href="#" class="footer-link text-white hover:text-indigo-300">Confidentialité</a>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Réseaux sociaux -->
            <div class="flex flex-col items-center">
                <h3 class="text-sm font-semibold text-slate-400 mb-4">SUIVEZ-NOUS</h3>
                <div class="flex space-x-4">
                    <a href="https://wa.me/2250140022693" target="_blank" class="social-icon whatsapp-icon w-12 h-12 rounded-full bg-slate-800 hover:bg-green-500 text-white flex items-center justify-center transition-all">
                        <i class="fab fa-whatsapp text-xl"></i>
                    </a>
                    <a href="https://github.com/Programmer-Emmanuel" target="_blank" class="social-icon github-icon w-12 h-12 rounded-full bg-slate-800 hover:bg-slate-700 text-white flex items-center justify-center transition-all">
                        <i class="fab fa-github text-xl"></i>
                    </a>
                    <a href="https://www.linkedin.com/in/emmanuel-bamidele-b63a49274" target="_blank" class="social-icon linkedin-icon w-12 h-12 rounded-full bg-slate-800 hover:bg-blue-600 text-white flex items-center justify-center transition-all">
                        <i class="fab fa-linkedin-in text-xl"></i>
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Copyright et crédits -->
        <div class="mt-12 pt-8 border-t border-slate-800/50">
            <div class="flex flex-col md:flex-row justify-between items-center gap-4">
                <p class="text-slate-400 text-sm order-2 md:order-1">Tous droits réservés</p>
                <p class="text-slate-400 text-sm order-1 md:order-2">
                    Développé par 
                    <a href="https://www.linkedin.com/in/emmanuel-bamidele-b63a49274" target="_blank" class="built-by">Emmanuel Bamidélé</a>
                </p>
            </div>
        </div>
    </div>
</footer>

<script>
    // Animation pour les éléments flottants
    document.addEventListener('DOMContentLoaded', () => {
        const style = document.createElement('style');
        style.textContent = `
            @keyframes float-slow {
                0%, 100% { transform: translateY(0) rotate(0deg); }
                50% { transform: translateY(-20px) rotate(5deg); }
            }
            .animate-float-slow { animation: float-slow 8s ease-in-out infinite; }
            .animation-delay-2000 { animation-delay: 2s; }
        `;
        document.head.appendChild(style);
    });
</script>