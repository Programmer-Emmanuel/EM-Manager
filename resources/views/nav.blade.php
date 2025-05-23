<style>
    /* Animation du menu mobile */
    #mobile-menu {
        transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1), opacity 0.2s ease;
        transform: translateY(-20px);
        opacity: 0;
        pointer-events: none;
    }

    #mobile-menu.active {
        transform: translateY(0);
        opacity: 1;
        pointer-events: auto;
    }

    /* Animation des icônes */
    .menu-icon {
        transition: transform 0.3s ease;
    }

    .menu-icon.active {
        transform: rotate(180deg);
    }

    /* Effet de soulignement des liens */
    .nav-link {
        position: relative;
    }

    .nav-link::after {
        content: '';
        position: absolute;
        bottom: -2px;
        left: 0;
        width: 0;
        height: 2px;
        background: currentColor;
        transition: width 0.3s ease;
    }

    .nav-link:hover::after {
        width: 100%;
    }

    /* Bouton avec effet de remplissage */
    .fill-btn {
        position: relative;
        overflow: hidden;
        z-index: 1;
    }

    .fill-btn::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 0;
        height: 100%;
        background-color: rgba(255, 255, 255, 0.1);
        transition: width 0.3s ease;
        z-index: -1;
    }

    .fill-btn:hover::before {
        width: 100%;
    }
</style>

<nav class="bg-slate-900 sticky top-0 z-[1000] shadow-lg border-b border-slate-700/50 backdrop-blur-sm bg-opacity-90">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">
            <!-- Logo -->
            <div class="flex-shrink-0 flex items-center">
                <a href="{{ route('accueil') }}" class="flex items-center group">
                    <img class="h-8 w-8 rounded-full group-hover:rotate-12 transition-transform" src="/images/management.png" alt="EM-Manager">
                    <span class="ml-3 text-xl font-bold text-white group-hover:text-indigo-300 transition-colors">EM-Manager</span>
                </a>
            </div>

            <!-- Menu Desktop -->
            <div class="hidden md:block">
                <div class="ml-10 flex items-center space-x-8">
                    <a href="{{ route('accueil') }}" class="nav-link text-sm font-medium text-white hover:text-indigo-300">Accueil</a>
                    <a href="{{ route('apropos') }}" class="nav-link text-sm font-medium text-white hover:text-indigo-300">À propos</a>
                    <a href="{{ route('service') }}" class="nav-link text-sm font-medium text-white hover:text-indigo-300">Services</a>
                    <a href="{{ route('contact') }}" class="nav-link text-sm font-medium text-white hover:text-indigo-300">Contact</a>
                    
                    @if(Auth::guard('employe')->check() || Auth::check())
                        <a href="#" 
                           onclick="confirmLogout(event, '/logout')" 
                           class="fill-btn px-4 py-2 rounded-md text-sm font-medium text-white bg-slate-800 hover:bg-slate-700 border border-slate-700">
                           Déconnexion
                        </a>
                    @else
                        <div class="flex items-center space-x-4">
                            <a href="{{route('login')}}" class="fill-btn px-4 py-2 rounded-md text-sm font-medium text-white hover:bg-white hover:bg-opacity-10">
                                Connexion
                            </a>
                            <a href="{{route('register')}}" class="px-4 py-2 rounded-md text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 transition-colors shadow-md">
                                Inscription
                            </a>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Bouton Mobile -->
            <div class="md:hidden flex items-center">
                <button id="menu-toggle" class="text-white focus:outline-none">
                    <svg id="burger-icon" class="menu-icon h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                    <svg id="cross-icon" class="menu-icon h-6 w-6 hidden" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Menu Mobile -->
    <div id="mobile-menu" class="md:hidden absolute w-full bg-slate-900 border-t border-slate-700 shadow-xl">
        <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3">
            <a href="{{ route('accueil') }}" class="block px-3 py-2 rounded-md text-base font-medium text-white hover:bg-slate-800">Accueil</a>
            <a href="{{ route('apropos') }}" class="block px-3 py-2 rounded-md text-base font-medium text-white hover:bg-slate-800">À propos</a>
            <a href="{{ route('service') }}" class="block px-3 py-2 rounded-md text-base font-medium text-white hover:bg-slate-800">Services</a>
            <a href="{{ route('contact') }}" class="block px-3 py-2 rounded-md text-base font-medium text-white hover:bg-slate-800">Contact</a>
            
            <div class="pt-2 border-t border-slate-800">
                @if(Auth::guard('employe')->check() || Auth::check())
                    <a href="#" 
                       onclick="confirmLogout(event, '/logout')" 
                       class="block w-full px-3 py-2 rounded-md text-base font-medium text-white bg-slate-800 hover:bg-slate-700 text-center">
                       Déconnexion
                    </a>
                @else
                    <div class="grid grid-cols-2 gap-2">
                        <a href="{{route('login')}}" class="block px-3 py-2 rounded-md text-base font-medium text-white hover:bg-slate-800 text-center border border-slate-700">
                            Connexion
                        </a>
                        <a href="{{route('register')}}" class="block px-3 py-2 rounded-md text-base font-medium text-white bg-indigo-600 hover:bg-indigo-700 text-center">
                            Inscription
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</nav>

<script>
    function confirmLogout(event, logoutUrl) {
        event.preventDefault();
        const userConfirmed = confirm("Êtes-vous sûr de vouloir vous déconnecter ?");
        if (userConfirmed) {
            window.location.href = logoutUrl;
        }
    }

    document.addEventListener('DOMContentLoaded', () => {
        const menuToggle = document.getElementById('menu-toggle');
        const mobileMenu = document.getElementById('mobile-menu');
        const burgerIcon = document.getElementById('burger-icon');
        const crossIcon = document.getElementById('cross-icon');
        const menuLinks = mobileMenu.querySelectorAll('a');

        const toggleMenu = () => {
            const isActive = mobileMenu.classList.contains('active');
            
            if (isActive) {
                mobileMenu.classList.remove('active');
                // Désactive le scroll lock après l'animation
                setTimeout(() => {
                    document.body.style.overflow = '';
                }, 300);
            } else {
                mobileMenu.classList.add('active');
                // Empêche le défilement de la page lorsque le menu est ouvert
                document.body.style.overflow = 'hidden';
            }

            burgerIcon.classList.toggle('hidden');
            crossIcon.classList.toggle('hidden');
            burgerIcon.classList.toggle('active');
            crossIcon.classList.toggle('active');
        };

        menuToggle.addEventListener('click', toggleMenu);

        menuLinks.forEach(link => {
            link.addEventListener('click', () => {
                if (mobileMenu.classList.contains('active')) {
                    toggleMenu();
                }
            });
        });

        // Ferme le menu si on clique à l'extérieur
        document.addEventListener('click', (e) => {
            if (!mobileMenu.contains(e.target) && !menuToggle.contains(e.target)) {
                if (mobileMenu.classList.contains('active')) {
                    toggleMenu();
                }
            }
        });
    });
</script>