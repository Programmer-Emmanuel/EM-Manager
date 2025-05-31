<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Dashboard Entreprise - EM-Manager</title>
    <link rel="shortcut icon" href="/images/management.png" type="image/x-icon" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com"></script>

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
        
        /* Nouveaux styles pour le menu mobile */
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
            }
            
            .mobile-bottom-nav a span {
                margin-top: 0.25rem;
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
        <aside class="desktop-sidebar w-20 sm:w-72 bg-gray-800 text-white lg:h-[calc(100vh-4rem)] border-r-[2px] border-gray-50">
            <div class="p-4 text-lg font-bold border-b border-gray-700">
                <span class="hidden sm:inline">{{ $entrepriseDetails->nom_entreprise }}</span>
                <p class="flex sm:flex-row flex-col items-center justify-center sm:justify-start mt-2 sm:mt-0 italic">
                    <span id="matricule">••••••••••</span>
                    <i class="fas fa-eye-slash eye-icon text-base sm:text-lg" id="toggleEye"></i>
                </p>
            </div>

            <nav class="p-4 space-y-2">
                <!-- Accueil -->
                <a href="{{ route('dashboard_entreprise') }}" class="flex items-center px-4 py-2 rounded hover:bg-gray-700">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25"/>
                    </svg>
                    <span class="ml-3 hidden sm:block">Accueil</span>
                </a>

                <!-- Employés -->
                <a href="{{ route('liste_employe') }}" class="flex items-center px-4 py-2 rounded hover:bg-gray-700">
                    <i class="fas fa-users sm:text-lg text-xs text-slate-300 outline-icon"></i>
                    <span class="ml-3 hidden sm:block">Gestion des employés</span>
                </a>

                <!-- Congés -->
                <a href="{{ route('gestion_conge') }}" class="flex items-center px-4 py-2 rounded hover:bg-gray-700">
                    <svg class="w-5 h-5 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    <span class="ml-3 hidden sm:block">Gestion des congés</span>
                    <p class="bg-white text-slate-900 rounded-full min-w-[24px] h-[24px] px-2 text-sm flex items-center justify-center m-2">{{ $count_conge}}</p>

                </a>

                <!-- Comptes -->
                <a href="{{ route('comptes') }}" class="flex items-center px-4 py-2 rounded hover:bg-gray-700">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span class="ml-3 hidden sm:block">Comptes et revenus</span>
                </a>

                <!-- Performances -->
                <a href="#" class="flex items-center px-4 py-2 rounded hover:bg-gray-700">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="m4.5 19.5 15-15m0 0H8.25m11.25 0v11.25"/>
                    </svg>
                    <span class="ml-3 hidden sm:block">Évaluation des performances</span>
                </a>

                <!-- Conseils IA -->
                @php
                    $url = route('analyse_conseils');
                @endphp

                <a href="{{ $url }}" onclick="showLoadingAndRedirect(event, '{{ $url }}')"class="flex items-center px-4 py-2 rounded bg-gradient-to-r from-amber-400 to-amber-600 hover:from-amber-500 hover:to-amber-700 transition-all duration-300 text-slate-900 hover:bg-amber-600 rounded-full text-slate-900">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 64" id="lamp" width="27" height="27">
                        <g id="katman_2">
                            <g id="icons">
                            <path d="M23 51v-4.56M43.87 40.83A7.26 7.26 0 0 0 41 46.44M35 54.46V57a2 2 0 0 1-2 2h-2a2 2 0 0 1-2-2v-2.54a4 4 0 0 0 2 .54h2a4 4 0 0 0 2-.54z" style="fill:none;stroke:#0f172a;stroke-linecap:round;stroke-linejoin:round;stroke-width:2px"></path>
                            <path d="M37 47v4a4 4 0 0 1-4 4h-2a4 4 0 0 1-4-4v-4zM47 25.82a15 15 0 0 1-5.63 11.89A11.24 11.24 0 0 0 37 46.44V47H27v-.56a10.65 10.65 0 0 0-4.08-8.5A15 15 0 1 1 47 25.82zM30 47V35M34 47V35M30 35l-6-6M34 35l6-6" style="fill:none;stroke:#0f172a;stroke-linecap:round;stroke-linejoin:round;stroke-width:2px"></path>
                            <path d="M26 15.61A11.94 11.94 0 0 1 32 14M20 26a12 12 0 0 1 2.57-7.42M32 8V4M19.27 13.27l-2.83-2.83M14 26h-4M50 26h4M44.73 13.27l2.83-2.83M27 50h10" style="fill:none;stroke:#0f172a;stroke-linecap:round;stroke-linejoin:round;stroke-width:2px"></path>
                            <path d="M0 0h64v64H0z" style="fill:none"></path>
                            </g>
                        </g>
                    </svg>
                    <span class="ml-3 hidden sm:block">ManagerAI</span>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" strokeWidth={1.5} stroke="currentColor" class=" ml-1 h-5">
                        <path strokeLinecap="round" strokeLinejoin="round" d="M9.813 15.904 9 18.75l-.813-2.846a4.5 4.5 0 0 0-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 0 0 3.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 0 0 3.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 0 0-3.09 3.09ZM18.259 8.715 18 9.75l-.259-1.035a3.375 3.375 0 0 0-2.455-2.456L14.25 6l1.036-.259a3.375 3.375 0 0 0 2.455-2.456L18 2.25l.259 1.035a3.375 3.375 0 0 0 2.456 2.456L21.75 6l-1.035.259a3.375 3.375 0 0 0-2.456 2.456ZM16.894 20.567 16.5 21.75l-.394-1.183a2.25 2.25 0 0 0-1.423-1.423L13.5 18.75l1.183-.394a2.25 2.25 0 0 0 1.423-1.423l.394-1.183.394 1.183a2.25 2.25 0 0 0 1.423 1.423l1.183.394-1.183.394a2.25 2.25 0 0 0-1.423 1.423Z" />
                    </svg>
                </a>

                <!-- Tableaux -->
                <a href="{{ route('dashboard_entreprise') }}#rapport_performance" class="flex items-center px-4 py-2 rounded hover:bg-gray-700">
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
            <a href="{{ route('dashboard_entreprise') }}" class="flex flex-col items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25"/>
                </svg>
                <span>Accueil</span>
            </a>
            

            <!-- Employés -->
            <a href="{{ route('liste_employe') }}" class="flex flex-col items-center">
                <i class="fas fa-users text-slate-300 h-6"></i>
                <span>Employés</span>
            </a>

            <!-- Congés -->
            <a href="{{ route('gestion_conge') }}" class="flex flex-col items-center">
                <svg class="w-6 h-6 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                <span>Congés</span>
            </a>

            <!-- Comptes -->
            <a href="{{ route('comptes') }}" class="flex flex-col items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>Comptes</span>
            </a>

            <!-- ManagerAI -->
            <a href="{{ $url }}" onclick="showLoadingAndRedirect(event, '{{ $url }}')" class="flex flex-col items-center bg-amber-600 rounded">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 64" id="lamp" width="24" height="24">
                    <g id="katman_2">
                        <g id="icons">
                        <path d="M23 51v-4.56M43.87 40.83A7.26 7.26 0 0 0 41 46.44M35 54.46V57a2 2 0 0 1-2 2h-2a2 2 0 0 1-2-2v-2.54a4 4 0 0 0 2 .54h2a4 4 0 0 0 2-.54z" style="fill:none;stroke:#d1d5db;stroke-linecap:round;stroke-linejoin:round;stroke-width:2px"></path>
                        <path d="M37 47v4a4 4 0 0 1-4 4h-2a4 4 0 0 1-4-4v-4zM47 25.82a15 15 0 0 1-5.63 11.89A11.24 11.24 0 0 0 37 46.44V47H27v-.56a10.65 10.65 0 0 0-4.08-8.5A15 15 0 1 1 47 25.82zM30 47V35M34 47V35M30 35l-6-6M34 35l6-6" style="fill:none;stroke:#d1d5db;stroke-linecap:round;stroke-linejoin:round;stroke-width:2px"></path>
                        <path d="M26 15.61A11.94 11.94 0 0 1 32 14M20 26a12 12 0 0 1 2.57-7.42M32 8V4M19.27 13.27l-2.83-2.83M14 26h-4M50 26h4M44.73 13.27l2.83-2.83M27 50h10" style="fill:none;stroke:#d1d5db;stroke-linecap:round;stroke-linejoin:round;stroke-width:2px"></path>
                        <path d="M0 0h64v64H0z" style="fill:none"></path>
                        </g>
                    </g>
                </svg>
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
        });
        function showLoadingAndRedirect(event, url) {
            event.preventDefault();
            const loadingElement = document.getElementById("loading");
            if (loadingElement) {
            loadingElement.style.display = "flex";
            }
            setTimeout(() => {
            window.location.href = url;
            }, 100); // délai court pour afficher l'effet
        }
    </script>
</body>
</html>