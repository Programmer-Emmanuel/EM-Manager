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

    /* Styles de la modale de déconnexion */
    .logout-modal-overlay {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: rgba(0, 0, 0, 0.5);
        backdrop-filter: blur(4px);
        z-index: 9999;
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        visibility: hidden;
        transition: opacity 0.3s ease, visibility 0.3s ease;
    }

    .logout-modal-overlay.active {
        opacity: 1;
        visibility: visible;
    }

    .logout-modal {
        background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
        border-radius: 1rem;
        border: 1px solid rgba(71, 85, 105, 0.5);
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
        width: 90%;
        max-width: 450px;
        transform: scale(0.9);
        transition: transform 0.3s cubic-bezier(0.34, 1.2, 0.64, 1);
        margin: 1rem;
    }

    .logout-modal-overlay.active .logout-modal {
        transform: scale(1);
    }

    .modal-header {
        padding: 1.5rem;
        border-bottom: 1px solid rgba(71, 85, 105, 0.5);
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .modal-title {
        font-size: 1.25rem;
        font-weight: 700;
        color: white;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .modal-close {
        background: none;
        border: none;
        color: #94a3b8;
        cursor: pointer;
        padding: 0.5rem;
        border-radius: 0.5rem;
        transition: all 0.2s ease;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .modal-close:hover {
        background-color: rgba(255, 255, 255, 0.1);
        color: white;
        transform: rotate(90deg);
    }

    .modal-body {
        padding: 1.5rem;
        color: #cbd5e1;
        text-align: center;
    }

    .modal-body p {
        margin-bottom: 0.5rem;
    }

    .modal-body .warning-text {
        font-size: 0.875rem;
        color: #f59e0b;
        margin-top: 0.5rem;
    }

    .modal-footer {
        padding: 1.5rem;
        border-top: 1px solid rgba(71, 85, 105, 0.5);
        display: flex;
        gap: 1rem;
        justify-content: flex-end;
    }

    .btn-cancel {
        padding: 0.625rem 1.25rem;
        background-color: #334155;
        color: white;
        border: none;
        border-radius: 0.5rem;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.2s ease;
        font-size: 0.875rem;
    }

    .btn-cancel:hover {
        background-color: #475569;
        transform: translateY(-1px);
    }

    .btn-confirm {
        padding: 0.625rem 1.25rem;
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
        color: white;
        border: none;
        border-radius: 0.5rem;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.2s ease;
        font-size: 0.875rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .btn-confirm:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
    }

    .btn-confirm:active {
        transform: translateY(0);
    }

    /* Animation d'entrée */
    @keyframes modalSlideIn {
        from {
            opacity: 0;
            transform: translateY(-20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Responsive pour les petits écrans */
    @media (max-width: 640px) {
        .modal-footer {
            flex-direction: column-reverse;
        }
        
        .btn-cancel, .btn-confirm {
            width: 100%;
            justify-content: center;
        }
        
        .modal-header {
            padding: 1rem;
        }
        
        .modal-body {
            padding: 1rem;
        }
        
        .modal-footer {
            padding: 1rem;
        }
        
        .modal-title {
            font-size: 1.125rem;
        }
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
                           onclick="showLogoutModal(event, '/logout')" 
                           class="fill-btn px-4 py-2 rounded-md text-sm font-medium text-white bg-slate-800 hover:bg-slate-700 border border-slate-700">
                           Déconnexion
                        </a>
                    @else
                        <div class="flex items-center space-x-4">
                            <a href="{{route('login')}}" class="fill-btn px-4 py-2 rounded-md text-sm font-medium text-white hover:bg-opacity-10">
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
                       onclick="showLogoutModal(event, '/logout')" 
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

<!-- Modale de déconnexion -->
<div id="logoutModal" class="logout-modal-overlay">
    <div class="logout-modal">
        <div class="modal-header">
            <div class="modal-title">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                </svg>
                Déconnexion
            </div>
            <button class="modal-close" onclick="closeLogoutModal()">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        <div class="modal-body">
            <p>Êtes-vous sûr de vouloir vous déconnecter ?</p>
            <p class="warning-text">Vous serez redirigé vers la page de connexion.</p>
        </div>
        <div class="modal-footer">
            <button class="btn-cancel" onclick="closeLogoutModal()">Annuler</button>
            <button class="btn-confirm" id="confirmLogoutBtn">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                </svg>
                Se déconnecter
            </button>
        </div>
    </div>
</div>

<script>
    let logoutUrl = '/login';

    function showLogoutModal(event, url) {
        event.preventDefault();
        logoutUrl = url;
        const modal = document.getElementById('logoutModal');
        modal.classList.add('active');
        
        // Empêche le défilement de la page lorsque la modale est ouverte
        document.body.style.overflow = 'hidden';
    }

    function closeLogoutModal() {
        const modal = document.getElementById('logoutModal');
        modal.classList.remove('active');
        
        // Réactive le défilement
        document.body.style.overflow = '';
    }

    function confirmLogout() {
        window.location.href = logoutUrl;
    }

    document.addEventListener('DOMContentLoaded', () => {
        const menuToggle = document.getElementById('menu-toggle');
        const mobileMenu = document.getElementById('mobile-menu');
        const burgerIcon = document.getElementById('burger-icon');
        const crossIcon = document.getElementById('cross-icon');
        const menuLinks = mobileMenu.querySelectorAll('a');
        const modal = document.getElementById('logoutModal');
        const confirmBtn = document.getElementById('confirmLogoutBtn');

        // Gestion du bouton de confirmation
        if (confirmBtn) {
            confirmBtn.addEventListener('click', confirmLogout);
        }

        const toggleMenu = () => {
            const isActive = mobileMenu.classList.contains('active');
            
            if (isActive) {
                mobileMenu.classList.remove('active');
                setTimeout(() => {
                    document.body.style.overflow = '';
                }, 300);
            } else {
                mobileMenu.classList.add('active');
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

        // Ferme la modale si on clique à l'extérieur
        modal.addEventListener('click', (e) => {
            if (e.target === modal) {
                closeLogoutModal();
            }
        });

        // Ferme la modale avec la touche Echap
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && modal.classList.contains('active')) {
                closeLogoutModal();
            }
        });
    });
</script>