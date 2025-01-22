<style>
    #mobile-menu {
        transition: max-height 0.3s ease-in-out, opacity 0.3s ease-in-out;
        max-height: 0;
        opacity: 0;
        overflow: hidden;
    }

    #mobile-menu.active {
        max-height: 500px; /* Ajustez cette valeur selon le contenu */
        opacity: 1;
    }
</style>

<nav class="bg-gray-800 sticky top-0 z-10">
    <div class="flex items-center justify-between h-16 px-4 sm:px-6">

        <div class="flex items-center">
            <a href="{{ route('accueil') }}" class="flex items-center">
                <img class="h-8 w-8 rounded-full" src="/images/management.png" alt="Em-Manager">
                <span class="ml-3 text-xl font-bold text-white">EM-Manager</span>
            </a>
        </div>

        <div class="sm:hidden">
            <button id="menu-toggle" class="text-white focus:outline-none">
                <svg id="burger-icon" class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
                </svg>
                <svg id="cross-icon" class="h-6 w-6 hidden" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <div class="hidden sm:block">
            <div class="flex space-x-4 items-center">
                <a href="{{ route('accueil') }}" class="text-sm font-medium text-white hover:text-gray-300">Accueil</a>
                <a href="{{ route('apropos') }}" class="text-sm font-medium text-white hover:text-gray-300">À propos</a>
                <a href="{{ route('service') }}" class="text-sm font-medium text-white hover:text-gray-300">Services</a>
                <a href="{{ route('contact') }}" class="text-sm font-medium text-white hover:text-gray-300">Contact</a>
                @if(Auth::guard('employe')->check() || Auth::check())
                    <a href="#" 
                       onclick="confirmLogout(event, '/logout')" 
                       class="bg-white rounded-md text-sm font-medium text-gray-800 hover:bg-gray-200 hover:text-gray-900 p-2">
                       Déconnexion
                    </a>
                @else
                    <a href="{{route('login')}}" class="bg-white rounded-md text-sm font-medium text-gray-800 hover:bg-gray-200 hover:text-gray-900 p-2">Connexion</a>
                    <a href="{{route('register')}}" class="ml-4 bg-white rounded-md text-sm font-medium text-gray-800 hover:bg-gray-200 hover:text-gray-900 p-2">Inscription</a>
                @endif
            </div>
        </div>
    </div>

    <div id="mobile-menu" class="hidden bg-gray-800 sm:hidden border-t-[1px] border-gray">
        <div class="flex flex-col space-y-2 px-4 py-2 text-right">
            <a href="{{ route('accueil') }}" class="text-sm font-medium text-white hover:text-gray-300">Accueil</a><hr>
            <a href="{{ route('apropos') }}" class="text-sm font-medium text-white hover:text-gray-300">À propos</a><hr>
            <a href="{{ route('service') }}" class="text-sm font-medium text-white hover:text-gray-300">Services</a><hr>
            <a href="{{ route('contact') }}" class="text-sm font-medium text-white hover:text-gray-300">Contact</a><hr>
            <div class="flex justify-end">
            @if(Auth::guard('employe')->check() || Auth::check())
                <a href="#" 
                   onclick="confirmLogout(event, '/logout')" 
                   class="bg-white rounded-md text-sm font-medium text-gray-800 hover:bg-gray-200 hover:text-gray-900 p-2 text-center" style="width: 100px;">
                   Déconnexion
                </a>
            @else
                <a href="{{route('login')}}" class="bg-white rounded-md text-sm font-medium text-gray-800 hover:bg-gray-200 hover:text-gray-900 p-2 text-center" style="width: 100px; margin-right: 5px;"> Connexion</a><hr>
                <a href="{{route('register')}}" class="bg-white rounded-md text-sm font-medium text-gray-800 hover:bg-gray-200 hover:text-gray-900 p-2 text-center" style="width: 100px;">Inscription</a>
            @endif
            </div>
        </div>
    </div>
</nav>

<script>
    function confirmLogout(event, logoutUrl) {
        event.preventDefault(); // Empêche le comportement par défaut du lien
        const userConfirmed = confirm("Êtes-vous sûr de vouloir vous déconnecter ?");
        if (userConfirmed) {
            // Redirige vers la route de déconnexion
            window.location.href = logoutUrl;
        }
    }

    document.addEventListener('DOMContentLoaded', () => {
        const menuToggle = document.getElementById('menu-toggle');
        const mobileMenu = document.getElementById('mobile-menu');
        const burgerIcon = document.getElementById('burger-icon');
        const crossIcon = document.getElementById('cross-icon');
        const menuLinks = mobileMenu.querySelectorAll('a'); // Sélectionne tous les liens du menu mobile

        // Fonction pour afficher/masquer le menu
        const toggleMenu = () => {
            const isActive = mobileMenu.classList.contains('active');

            if (isActive) {
                // Cache le menu
                mobileMenu.classList.remove('active');
                setTimeout(() => mobileMenu.classList.add('hidden'), 300);
            } else {
                // Affiche le menu
                mobileMenu.classList.remove('hidden');
                setTimeout(() => mobileMenu.classList.add('active'), 10);
            }

            // Alterne entre les icônes burger et croix
            burgerIcon.classList.toggle('hidden');
            crossIcon.classList.toggle('hidden');
        };

        // Gestion du clic sur le bouton pour ouvrir/fermer le menu
        menuToggle.addEventListener('click', toggleMenu);

        // Gestion du clic sur un lien du menu pour fermer le menu
        menuLinks.forEach(link => {
            link.addEventListener('click', () => {
                if (mobileMenu.classList.contains('active')) {
                    toggleMenu();
                }
            });
        });
    });
</script>
