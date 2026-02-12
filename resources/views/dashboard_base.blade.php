<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Dashboard Entreprise - EM-Manager</title>
    <link rel="shortcut icon" href="/images/management.png" type="image/x-icon" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet" />
    @include('style')

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
        
        /* Styles pour le menu déroulant RH - Animation slide down */
        .dropdown {
            position: relative;
            width: 100%;
        }
        
        .dropdown-button {
            display: flex;
            align-items: center;
            width: 100%;
            padding: 0.5rem 1rem;
            border-radius: 0.375rem;
            background: transparent;
            border: none;
            color: white;
            cursor: pointer;
            transition: background-color 0.2s;
        }
        
        .dropdown-button:hover {
            background-color: #374151;
        }
        
        .dropdown-button.active {
            background-color: #374151;
        }
        
        .chevron-icon {
            margin-left: auto;
            transition: transform 0.3s ease;
        }
        
        .dropdown.active .chevron-icon {
            transform: rotate(180deg);
        }
        
        /* Menu déroulant avec animation slide down */
        .dropdown-menu-container {
            max-height: 0;
            opacity: 0;
            overflow: hidden;
            transition: max-height 0.5s cubic-bezier(0.4, 0, 0.2, 1), opacity 0.3s ease;
            width: 100%;
            margin-left: 0.5rem;
            border-left: 2px solid #4b5563;
            padding-left: 0.5rem;
        }
        
        .dropdown.active .dropdown-menu-container {
            max-height: 250px;
            opacity: 1;
        }
        
        .dropdown-menu {
            padding: 0.25rem 0;
        }
        
        .dropdown-menu a {
            padding: 0.75rem 1rem;
            display: flex;
            align-items: center;
            color: #d1d5db;
            text-decoration: none;
            transition: background-color 0.2s, transform 0.2s;
            border-radius: 0.375rem;
            margin: 0.25rem 0;
        }
        
        .dropdown-menu a:hover {
            background-color: #374151;
            transform: translateX(5px);
        }
        
        .dropdown-menu a i, .dropdown-menu a svg {
            width: 1.25rem;
            margin-right: 0.75rem;
        }
        
        .dropdown-menu a.active {
            background-color: #4b5563;
        }
        
        /* Menu mobile - DESIGN UI/UX CENTRÉ */
        @media (max-width: 1023px) {
            .mobile-bottom-nav {
                position: fixed;
                bottom: 0;
                left: 0;
                right: 0;
                z-index: 1000;
                background-color: #1a1e2c;
                backdrop-filter: blur(10px);
                display: flex;
                justify-content: space-around;
                align-items: center;
                padding: 0.6rem 0.5rem;
                border-top: 1px solid rgba(55, 65, 81, 0.5);
                box-shadow: 0 -4px 20px rgba(0, 0, 0, 0.3);
            }
            
            .mobile-bottom-nav > a, 
            .mobile-dropdown > a {
                flex: 1;
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                padding: 0.4rem 0.2rem;
                color: #9ca3af;
                font-size: 0.7rem;
                text-decoration: none;
                transition: all 0.2s ease;
                border-radius: 0.5rem;
                margin: 0 0.1rem;
                min-width: 60px;
            }
            
            /* Alignement vertical parfait de l'icône et du titre */
            .mobile-bottom-nav > a i,
            .mobile-bottom-nav > a svg,
            .mobile-dropdown > a i,
            .mobile-dropdown > a svg {
                display: flex;
                align-items: center;
                justify-content: center;
                width: 20px;
                height: 20px;
                margin-bottom: 4px;
            }
            
            .mobile-bottom-nav > a span,
            .mobile-dropdown > a span {
                margin-top: 2px;
                font-weight: 500;
                line-height: 1.2;
                text-align: center;
            }
            
            .mobile-bottom-nav > a.active {
                color: #fff;
            }

            .mobile-bottom-nav > a.active span,
            .mobile-dropdown > a.active span {
                color: #fff;
            }
            
            /* Mobile dropdown */
            .mobile-dropdown {
                position: static;
                flex: 1;
                display: flex;
                flex-direction: column;
                align-items: center;
            }
            
            .mobile-dropdown > a {
                width: 100%;
                color: #9ca3af;
            }
            
            .mobile-dropdown.active > a {
                color: #ffffffff;
                background: rgba(255, 255, 255, 0.15);
            }
            
            /* Menu horizontal centré avec cartes UI/UX */
            .mobile-rh-cards {
                position: absolute;
                bottom: 80px;
                left: 0;
                right: 0;
                display: flex;
                justify-content: center;
                align-items: center;
                gap: 1rem;
                padding: 0.5rem 1rem;
                opacity: 0;
                visibility: hidden;
                transform: translateY(15px);
                transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
                z-index: 1002;
                pointer-events: none;
            }
            
            .mobile-dropdown.active .mobile-rh-cards {
                opacity: 1;
                visibility: visible;
                transform: translateY(0);
                pointer-events: all;
            }
            
            /* Cartes individuelles - Design premium centré */
            .rh-card {
                background: linear-gradient(145deg, #252b3b, #1e2432);
                border-radius: 1.2rem;
                padding: 0.9rem 0.6rem;
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                gap: 0.4rem;
                width: 100px;
                max-width: 110px;
                color: #e5e7eb;
                text-decoration: none;
                transition: all 0.25s cubic-bezier(0.34, 1.56, 0.64, 1);
                border: 1px solid rgba(75, 85, 99, 0.3);
                box-shadow: 0 10px 20px rgba(0, 0, 0, 0.25);
                backdrop-filter: blur(5px);
                position: relative;
                overflow: hidden;
            }
            
            /* Barre supérieure colorée */
            .rh-card::before {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                height: 3px;
                opacity: 0;
                transition: opacity 0.25s ease;
            }
            
            .rh-card.active::before {
                opacity: 1;
            }
            
            /* Effet de survol élégant */
            .rh-card:hover {
                transform: translateY(-6px) scale(1.02);
                box-shadow: 0 16px 28px rgba(251, 191, 36, 0.2);
                background: linear-gradient(145deg, #2d3345, #232835);
            }
            
            .rh-card.active {
                background: linear-gradient(145deg, #2d3345, #252b3b);
                border: 1px solid #ffffffff;
                color: white;
                box-shadow: 0 0 15px rgba(251, 191, 36, 0.3);
            }
            
            /* Icônes dans les cartes */
            .rh-card i, .rh-card svg {
                font-size: 1.7rem;
                width: 1.7rem;
                height: 1.7rem;
                margin-bottom: 0.3rem;
                filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.2));
            }
            
            .rh-card span {
                font-size: 0.7rem;
                font-weight: 600;
                text-align: center;
                line-height: 1.3;
                letter-spacing: 0.3px;
            }
            
            /* Badge pour le compteur de congés */
            .rh-card-badge {
                position: absolute;
                top: 6px;
                right: 6px;
                color: white;
                border-radius: 9999px;
                min-width: 20px;
                height: 20px;
                padding: 0 5px;
                font-size: 0.6rem;
                display: flex;
                align-items: center;
                justify-content: center;
                font-weight: bold;
                border: 1.5px solid white;
                box-shadow: 0 2px 6px rgba(220, 38, 38, 0.4);
            }
            
            /* Overlay élégant */
            .mobile-dropdown.active::after {
                content: '';
                position: fixed;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background: rgba(0, 0, 0, 0.6);
                backdrop-filter: blur(3px);
                z-index: 1001;
                pointer-events: none;
                animation: fadeIn 0.3s ease;
            }
            
            @keyframes fadeIn {
                from { opacity: 0; }
                to { opacity: 1; }
            }
            
            .mobile-manager-ai {
                background: linear-gradient(145deg, #b45309, #d97706);
                color: white !important;
                border-radius: 0.5rem;
            }
            
            .mobile-manager-ai i,
            .mobile-manager-ai svg {
                color: white !important;
            }
            
            .desktop-sidebar {
                display: none;
            }
            
            .main-content {
                margin-bottom: 85px;
                width: 100%;
            }
            
            /* Animation d'entrée séquentielle pour les cartes */
            .mobile-dropdown.active .rh-card {
                animation: slideUpCard 0.5s cubic-bezier(0.34, 1.56, 0.64, 1) forwards;
                opacity: 0;
            }
            
            .mobile-dropdown.active .rh-card:nth-child(1) {
                animation-delay: 0.05s;
            }
            
            .mobile-dropdown.active .rh-card:nth-child(2) {
                animation-delay: 0.1s;
            }
            
            .mobile-dropdown.active .rh-card:nth-child(3) {
                animation-delay: 0.15s;
            }
            
            @keyframes slideUpCard {
                0% {
                    opacity: 0;
                    transform: translateY(25px) scale(0.95);
                }
                100% {
                    opacity: 1;
                    transform: translateY(0) scale(1);
                }
            }
            
            /* Adaptation pour très petits écrans */
            @media (max-width: 380px) {
                .rh-card {
                    width: 85px;
                    padding: 0.7rem 0.4rem;
                }
                
                .rh-card i, .rh-card svg {
                    font-size: 1.5rem;
                    width: 1.5rem;
                    height: 1.5rem;
                }
                
                .rh-card span {
                    font-size: 0.65rem;
                }
                
                .mobile-bottom-nav > a span,
                .mobile-dropdown > a span {
                    font-size: 0.65rem;
                }
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
        
        /* Animation desktop */
        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .dropdown.active .dropdown-menu a {
            animation: slideIn 0.3s ease forwards;
            animation-delay: calc(var(--item-index) * 0.05s);
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

                <!-- Gestionnaire RH (Menu déroulant avec animation slide down) -->
                <div class="dropdown">
                    <button class="dropdown-button {{ 
                        request()->routeIs('liste_employe') || 
                        request()->routeIs('gestion_conge') || 
                        request()->routeIs('paiement.employe') ? 'active' : '' }}" 
                        onclick="toggleDropdown(event)">
                        <i class="fas fa-user-tie sm:text-lg text-xs text-slate-300"></i>
                        <span class="ml-3 hidden sm:block flex-1 text-left">Gestionnaire RH</span>
                        <i class="fas fa-chevron-down chevron-icon text-xs sm:text-sm"></i>
                    </button>
                    
                    <div class="dropdown-menu-container">
                        <div class="dropdown-menu">
                            <a href="{{ route('liste_employe') }}" style="--item-index: 0" class="{{ request()->routeIs('liste_employe') ? 'active' : '' }}">
                                <i class="fas fa-users"></i>
                                <span>Employés</span>
                            </a>
                            <a href="{{ route('gestion_conge') }}" style="--item-index: 1" class="{{ request()->routeIs('gestion_conge') ? 'active' : '' }}">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <span>Congés</span>
                                @if ($count_conge != 0)
                                    <span class="bg-white text-slate-900 rounded-full min-w-[24px] h-[24px] px-2 text-sm flex items-center justify-center ml-2">{{ $count_conge }}</span>
                                @endif
                            </a>
                            <a href="{{ route('paiement.employe') }}" style="--item-index: 2" class="{{ request()->routeIs('paiement.employe') ? 'active' : '' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0 1 15.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 0 1 3 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 0 0-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 0 1-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 0 0 3 15h-.75M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm3 0h.008v.008H18V10.5Zm-12 0h.008v.008H6V10.5Z" />
                                </svg>
                                <span>Salaires</span>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Gestion de stock -->
                <a href="{{ route('liste_produits') }}" 
                   class="flex items-center px-4 py-2 rounded hover:bg-gray-700 {{ request()->routeIs('liste_produits') ? 'active-nav' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M21 10V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l2-1.14"/>
                        <path d="m7.5 4.27 9 5.15"/>
                        <polyline points="3.29 7 12 12 20.71 7"/>
                        <line x1="12" x2="12" y1="22" y2="12"/>
                        <circle cx="18.5" cy="15.5" r="2.5"/>
                        <path d="M20.27 17.27 22 19"/>
                    </svg>
                    <span class="ml-3 hidden sm:block">Gestion de stock</span>
                </a>

                <!-- Comptabilité -->
                <a href="{{ route('comptes') }}" 
                   class="flex items-center px-4 py-2 rounded hover:bg-gray-700 {{ request()->routeIs('comptes') ? 'active-nav' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span class="ml-3 hidden sm:block">Comptabilité</span>
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

        <!-- Menu Mobile - DESIGN CENTRÉ AVEC ALIGNEMENT PARFAIT -->
        <nav class="mobile-bottom-nav lg:hidden">
            <!-- Accueil -->
            <a href="{{ route('dashboard_entreprise') }}" 
               class="flex flex-col items-center {{ request()->routeIs('dashboard_entreprise') ? 'active' : '' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25"/>
                </svg>
                <span>Accueil</span>
            </a>

            <!-- Gestionnaire RH Mobile - Icône alignée verticalement -->
            <div class="mobile-dropdown {{ 
                request()->routeIs('liste_employe') || 
                request()->routeIs('gestion_conge') || 
                request()->routeIs('paiement.employe') ? 'active' : '' }}">
                
                <a href="#" onclick="toggleMobileDropdown(event)" class="flex flex-col items-center justify-center">
                    <i class="fas fa-user-tie"></i>
                    <span>RH</span>
                </a>
                
                <!-- Cartes horizontales centrées -->
                <div class="mobile-rh-cards">
                    <!-- Carte Employés -->
                    <a href="{{ route('liste_employe') }}" class="rh-card {{ request()->routeIs('liste_employe') ? 'active' : '' }}">
                        <i class="fas fa-users"></i>
                        <span>Employés</span>
                    </a>
                    
                    <!-- Carte Congés avec badge -->
                    <a href="{{ route('gestion_conge') }}" class="rh-card {{ request()->routeIs('gestion_conge') ? 'active' : '' }}">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <span>Congés</span>
                        @if ($count_conge != 0)
                            <span class="rh-card-badge">{{ $count_conge }}</span>
                        @endif
                    </a>
                    
                    <!-- Carte Salaire -->
                    <a href="{{ route('paiement.employe') }}" class="rh-card {{ request()->routeIs('paiement.employe') ? 'active' : '' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0 1 15.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 0 1 3 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 0 0-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 0 1-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 0 0 3 15h-.75M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm3 0h.008v.008H18V10.5Zm-12 0h.008v.008H6V10.5Z" />
                        </svg>
                        <span>Salaire</span>
                    </a>
                </div>
            </div>

            <!-- Gestion de stock -->
            <a href="{{ route('liste_produits') }}" 
               class="flex flex-col items-center {{ request()->routeIs('liste_produits') ? 'active' : '' }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M21 10V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l2-1.14"/>
                    <path d="m7.5 4.27 9 5.15"/>
                    <polyline points="3.29 7 12 12 20.71 7"/>
                    <line x1="12" x2="12" y1="22" y2="12"/>
                    <circle cx="18.5" cy="15.5" r="2.5"/>
                    <path d="M20.27 17.27 22 19"/>
                </svg>
                <span>Stock</span>
            </a>

            <!-- Comptabilité -->
            <a href="{{ route('comptes') }}" 
               class="flex flex-col items-center {{ request()->routeIs('comptes') ? 'active' : '' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>Compta</span>
            </a>

            <!-- ManagerAI -->
            <a href="{{ $url }}" 
               onclick="showLoadingAndRedirect(event, '{{ $url }}')" 
               class="flex flex-col items-center mobile-manager-ai {{ request()->routeIs('analyse_conseils') ? 'active' : '' }}">
                <i class="fas fa-robot"></i>
                <span>ManagerAI</span>
            </a>
        </nav>
    </div>

    <!-- Loader -->
    @include('loading')

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Gestion du matricule
            const matriculeElement = document.getElementById('matricule');
            const toggleEyeElement = document.getElementById('toggleEye');
            let isHidden = true;
            const matricule = "{{ $entrepriseDetails->matricule_entreprise }}";

            if (toggleEyeElement) {
                toggleEyeElement.addEventListener('click', () => {
                    isHidden = !isHidden;
                    matriculeElement.textContent = isHidden ? "••••••••••" : matricule;
                    toggleEyeElement.classList.toggle('fa-eye');
                    toggleEyeElement.classList.toggle('fa-eye-slash');
                });
            }
            
            // Fermeture des dropdowns
            document.addEventListener('click', function(event) {
                const dropdowns = document.querySelectorAll('.dropdown');
                dropdowns.forEach(dropdown => {
                    if (!dropdown.contains(event.target)) {
                        dropdown.classList.remove('active');
                    }
                });
                
                const mobileDropdowns = document.querySelectorAll('.mobile-dropdown');
                mobileDropdowns.forEach(dropdown => {
                    const rhCards = dropdown.querySelector('.mobile-rh-cards');
                    if (!dropdown.contains(event.target) && !rhCards?.contains(event.target)) {
                        dropdown.classList.remove('active');
                    }
                });
            });
            
            // Ouverture automatique si page RH active
            const isRhActive = {{ 
                request()->routeIs('liste_employe') || 
                request()->routeIs('gestion_conge') || 
                request()->routeIs('paiement.employe') ? 'true' : 'false' 
            }};
            
            if (isRhActive) {
                const dropdown = document.querySelector('.dropdown');
                if (dropdown) dropdown.classList.add('active');
                
                const mobileDropdown = document.querySelector('.mobile-dropdown');
                if (mobileDropdown) mobileDropdown.classList.add('active');
            }
            
            // Fermeture après clic sur une carte
            const rhCards = document.querySelectorAll('.rh-card');
            rhCards.forEach(card => {
                card.addEventListener('click', function() {
                    setTimeout(() => {
                        const mobileDropdown = document.querySelector('.mobile-dropdown');
                        if (mobileDropdown) mobileDropdown.classList.remove('active');
                    }, 200);
                });
            });
        });
        
        function toggleDropdown(event) {
            event.preventDefault();
            event.stopPropagation();
            const button = event.currentTarget;
            const dropdown = button.closest('.dropdown');
            dropdown.classList.toggle('active');
        }
        
        function toggleMobileDropdown(event) {
            event.preventDefault();
            event.stopPropagation();
            const dropdown = event.currentTarget.closest('.mobile-dropdown');
            
            document.querySelectorAll('.mobile-dropdown').forEach(d => {
                if (d !== dropdown) d.classList.remove('active');
            });
            
            dropdown.classList.toggle('active');
        }
        
        function showLoadingAndRedirect(event, url) {
            event.preventDefault();
            const loadingElement = document.getElementById("loading");
            if (loadingElement) loadingElement.style.display = "flex";
            setTimeout(() => window.location.href = url, 100);
        }
    </script>
</body>
</html>