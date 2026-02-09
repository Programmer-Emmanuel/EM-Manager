<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Dashboard Entreprise - EM-Manager</title>
    <link rel="shortcut icon" href="/images/management.png" type="image/x-icon" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet" />
    @vite('resources/css/app.css')

    <!-- Animation AOS.js -->
    @include('aos')

    <style>
        .eye-icon {
            cursor: pointer;
            margin-left: 10px;
            font-size: 1.2rem;
        }
        #matricule {
            letter-spacing: 3px;
        }
        .hide-scroll {
            scrollbar-width: none; /* Firefox */
            -ms-overflow-style: none; /* IE */
        }
        .hide-scroll::-webkit-scrollbar {
            display: none; /* Chrome, Safari, Opera */
        }
        html, body {
            height: 100%;
        }
        .outline-icon {
            -webkit-text-fill-color: transparent;
            -webkit-text-stroke: 1px currentColor;
        }
        
        /* Classes pour éléments actifs */
        .active-nav {
            background-color: #374151; /* bg-gray-700 */
        }
        
        /* ManagerAI spécial */
        .manager-ai-nav {
            background: linear-gradient(to right, #fbbf24, #d97706); /* from-amber-400 to-amber-600 */
            color: #1f2937; /* text-slate-900 */
        }
        
        .manager-ai-nav:hover {
            background: linear-gradient(to right, #f59e0b, #b45309); /* from-amber-500 to-amber-700 */
        }
        
        /* Menu mobile */
        @media (max-width: 1023px) {
            .mobile-bottom-nav {
                position: fixed;
                bottom: 0;
                left: 0;
                right: 0;
                z-index: 1000;
                background-color: #1f2937; /* bg-gray-800 */
                display: flex;
                justify-content: space-around;
                padding: 0.5rem 0;
                border-top: 1px solid #374151; /* border-gray-700 */
            }
            
            .mobile-bottom-nav a {
                flex: 1;
                display: flex;
                flex-direction: column;
                align-items: center;
                padding: 0.5rem;
                color: #d1d5db; /* text-gray-300 */
                font-size: 0.75rem;
                text-decoration: none;
            }
            
            .mobile-bottom-nav a.active {
                color: white;
                font-weight: 600;
            }
            
            .mobile-bottom-nav a span {
                margin-top: 0.25rem;
            }
            
            .mobile-manager-ai {
                background-color: #d97706; /* bg-amber-600 */
                color: #1f2937;
                border-radius: 0.375rem;
            }
            
            .desktop-sidebar {
                display: none;
            }
            
            .main-content {
                margin-bottom: 4rem; /* Espace pour le menu mobile */
                width: 100%;
            }
        }
        
        @media (min-width: 1024px) {
            .mobile-bottom-nav {
                display: none;
            }
            
            .desktop-sidebar {
                display: block;
            }
            
            .main-content {
                flex: 1;
            }
        }
    </style>
</head>
<body class="bg-gray-100 overflow-hidden">
    <!-- Navigation -->
    @include('nav')

    <div class="flex flex-col lg:flex-row border-t-[2px] min-h-[calc(100vh-4rem)] bg-slate-900 pb-[100px] md:pb-0">
        <!-- Sidebar Desktop -->
        <aside class="desktop-sidebar w-20 sm:w-72 bg-slate-900 text-white lg:h-[calc(100vh-4rem)] border-r-[2px] border-gray-50">
            <div class="p-4 text-lg font-bold border-b border-gray-700">
                <span class="hidden sm:inline">{{ $entrepriseDetails->nom_entreprise }}</span>
                <p class="flex sm:flex-row flex-col items-center justify-center sm:justify-start mt-2 sm:mt-0 italic">
                    <span id="matricule">••••••••••</span>
                    <i class="fas fa-eye-slash eye-icon text-base sm:text-lg" id="toggleEye"></i>
                </p>
            </div>

            <nav class="p-4 space-y-2">
                <!-- Accueil -->
                <a href="{{ route('dashboard_entreprise') }}" 
                   class="flex items-center px-4 py-2 rounded hover:bg-gray-700 {{ request()->routeIs('dashboard_entreprise') ? 'active-nav' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25"/>
                    </svg>
                    <span class="ml-3 hidden sm:block">Accueil</span>
                </a>

                <!-- Employés -->
                <a href="{{ route('liste_employe') }}" 
                   class="flex items-center px-4 py-2 rounded hover:bg-gray-700 {{ request()->routeIs('liste_employe') ? 'active-nav' : '' }}">
                    <i class="fas fa-users sm:text-lg text-xs text-slate-300 outline-icon"></i>
                    <span class="ml-3 hidden sm:block">Gestion des employés</span>
                </a>

                <a href="{{ route('liste_produits') }}" 
                   class="flex items-center px-4 py-2 rounded hover:bg-gray-700 {{ request()->routeIs('liste_produits') ? 'active-nav' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-package-search-icon lucide-package-search"><path d="M21 10V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l2-1.14"/><path d="m7.5 4.27 9 5.15"/><polyline points="3.29 7 12 12 20.71 7"/><line x1="12" x2="12" y1="22" y2="12"/><circle cx="18.5" cy="15.5" r="2.5"/><path d="M20.27 17.27 22 19"/></svg>
                    <span class="ml-3 hidden sm:block">Gestion des produits</span>
                </a>

                <!-- Congés -->
                <a href="{{ route('gestion_conge') }}" 
                   class="flex items-center px-4 py-2 rounded hover:bg-gray-700 {{ request()->routeIs('gestion_conge') ? 'active-nav' : '' }}">
                    <svg class="w-5 h-5 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    <span class="ml-3 hidden sm:block">Gestion des congés</span>
                    @if ($count_conge!=0)
                        <p class="bg-white text-slate-900 rounded-full min-w-[24px] h-[24px] px-2 text-sm flex items-center justify-center m-2">{{ $count_conge}}</p>
                    @endif
                </a>

                <!-- Comptes -->
                <a href="{{ route('comptes') }}" 
                   class="flex items-center px-4 py-2 rounded hover:bg-gray-700 {{ request()->routeIs('comptes') ? 'active-nav' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span class="ml-3 hidden sm:block">Comptes et revenus</span>
                </a>

                <!-- Performances -->
                <a href="{{ route('paiement.employe') }}" class="flex items-center px-4 py-2 rounded hover:bg-gray-700">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0 1 15.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 0 1 3 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 0 0-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 0 1-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 0 0 3 15h-.75M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm3 0h.008v.008H18V10.5Zm-12 0h.008v.008H6V10.5Z" />
                    </svg>
                    <span class="ml-3 hidden sm:block">Salaire des Employés</span>
                </a>

                <!-- Conseils IA -->
                @php
                    $url = route('analyse_conseils');
                @endphp

                <a href="{{ $url }}" 
                   onclick="showLoadingAndRedirect(event, '{{ $url }}')"
                   class="flex items-center px-4 py-2 rounded manager-ai-nav {{ request()->routeIs('analyse_conseils') ? 'manager-ai-nav' : '' }}">
                    <i class="fas fa-robot"></i>
                    <span class="ml-3 hidden sm:block">ManagerAI</span>
                </a>

                <!-- Tableaux -->
                <a href="{{ route('dashboard_entreprise') }}#performanceChart" 
                   class="flex items-center px-4 py-2 rounded hover:bg-gray-700">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7.5 14.25v2.25m3-4.5v4.5m3-6.75v6.75m3-9v9M6 20.25h12A2.25 2.25 0 0020.25 18V6A2.25 2.25 0 0018 3.75H6A2.25 2.25 0 003.75 6v12A2.25 2.25 0 006 20.25Z"/>
                    </svg>
                    <span class="ml-3 hidden sm:block">Tableaux analytiques</span>
                </a>
            </nav>
        </aside>

        <!-- Contenu principal -->
        @yield('main')

        <!-- Menu Mobile -->
        <nav class="mobile-bottom-nav lg:hidden">
            <!-- Accueil -->
            <a href="{{ route('dashboard_entreprise') }}" 
               class="flex flex-col items-center {{ request()->routeIs('dashboard_entreprise') ? 'active' : '' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25"/>
                </svg>
                <span>Accueil</span>
            </a>
            
            <!-- Employés -->
            <a href="{{ route('liste_employe') }}" 
               class="flex flex-col items-center {{ request()->routeIs('liste_employe') ? 'active' : '' }}">
                <i class="fas fa-users text-slate-300 h-6"></i>
                <span>Employés</span>
            </a>

            <!-- Congés -->
            <a href="{{ route('gestion_conge') }}" 
               class="flex flex-col items-center {{ request()->routeIs('gestion_conge') ? 'active' : '' }}">
                <svg class="w-6 h-6 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                <span>Congés</span>
            </a>

            <!-- Comptes -->
            <a href="{{ route('comptes') }}" 
               class="flex flex-col items-center {{ request()->routeIs('comptes') ? 'active' : '' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>Comptes</span>
            </a>

            <!-- ManagerAI -->
            <a href="{{ $url }}" 
               onclick="showLoadingAndRedirect(event, '{{ $url }}')" 
               class="flex flex-col items-center mobile-manager-ai {{ request()->routeIs('analyse_conseils') ? 'mobile-manager-ai active' : '' }}">
                <i class="fas fa-robot h-6"></i>
                <span>ManagerAI</span>
            </a>
        </nav>
    </div>

    <!-- Loader -->
    @include('loading')

    <!-- Script pour afficher/masquer le matricule -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const matriculeElement = document.getElementById('matricule');
            const toggleEyeElement = document.getElementById('toggleEye');
            let isHidden = true;
            const matricule = "{{ $entrepriseDetails->matricule_entreprise }}";

            toggleEyeElement.addEventListener('click', () => {
                isHidden = !isHidden;
                matriculeElement.textContent = isHidden ? "••••••••••" : matricule;
                toggleEyeElement.classList.toggle('fa-eye');
                toggleEyeElement.classList.toggle('fa-eye-slash');
            });
            
            // Ajouter la classe active pour la navigation mobile en fonction de l'URL actuelle
            const currentPath = window.location.pathname;
            const mobileLinks = document.querySelectorAll('.mobile-bottom-nav a');
            
            mobileLinks.forEach(link => {
                if (link.getAttribute('href') === currentPath || 
                    (link.getAttribute('href') && currentPath.includes(link.getAttribute('href')))) {
                    link.classList.add('active');
                }
            });
        });
        
        function showLoadingAndRedirect(event, url) {
            event.preventDefault();
            const loadingElement = document.getElementById("loading");
            if (loadingElement) {
                loadingElement.style.display = "flex";
            }
            setTimeout(() => {
                window.location.href = url;
            }, 100);
        }
    </script>
</body>
</html>