<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Entreprise - EM-Manager</title>
    <link rel="shortcut icon" href="/images/management.png" type="image/x-icon">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
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
            -ms-overflow-style: none; /* Internet Explorer 10+ */
        }
        .hide-scroll::-webkit-scrollbar {
            display: none; /* Chrome, Safari, Opera */
        }
        html, body {
            height: 100%;
        }
        .outline-icon {
            -webkit-text-fill-color: transparent; /* Retire le remplissage */
            -webkit-text-stroke: 1px currentColor; /* Ajoute un contour */
        }
    </style>
</head>
<body class="bg-gray-100">
    <!-- Barre de navigation : nav.blade.php -->
    @include('nav')

    <div class="flex border-t-[2px]">
        <!-- Menu latéral -->
        <aside class="w-20 sm:w-72 bg-gray-800 text-white h-screen-full border-r-[2px] border-gray-50">
    <div class="p-4 text-lg font-bold border-b border-gray-700">
        <span class="hidden sm:inline">{{$entrepriseDetails->nom_entreprise}}</span><br>
        <p class="flex sm:flex-row flex-col items-center justify-center sm:justify-start mt-2 sm:mt-0 italic">
            <span id="matricule">••••••••••</span>
            <i class="fas fa-eye-slash eye-icon text-base sm:text-lg" id="toggleEye"></i>
        </p>


    </div>
    <nav class="p-4 space-y-2 sm:static">
        <!-- Gestion des employés -->

        <a href="{{ route('dashboard_entreprise')}}" class="flex items-center px-4 py-2 rounded hover:bg-gray-700">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
            </svg>
            <span class="ml-3 hidden sm:block">Acceuil</span>
        </a>

        <a href="{{ route('liste_employe')}}" class="flex items-center px-4 py-2 rounded hover:bg-gray-700">
        <i class="fas fa-users sm:text-lg text-xs text-slate-300 outline-icon"></i>
            <span class="ml-3 hidden sm:block">Gestion des employés</span>
        </a>

        <!-- Gestion des congés -->
        <a href="{{ route('gestion_conge') }}" class="flex items-center px-4 py-2 rounded hover:bg-gray-700">
            <svg class="w-5 h-5 text-gray-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>
            <span class="ml-3 hidden sm:block">Gestion des congés</span>
        </a>

        <!-- Suivi des présences -->
        <a href="" class="flex items-center px-4 py-2 rounded hover:bg-gray-700">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
            </svg>
            <span class="ml-3 hidden sm:block">Suivi des présences</span>
        </a>

        <!-- Traitement des paies -->
        <a href="" class="flex items-center px-4 py-2 rounded hover:bg-gray-700">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 0 0 2.25-2.25V6.75A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25v10.5A2.25 2.25 0 0 0 4.5 19.5Z" />
            </svg>
            <span class="ml-3 hidden sm:block">Traitement des paies</span>
        </a>

        <!-- Evaluation des performances -->
        <a href="" class="flex items-center px-4 py-2 rounded hover:bg-gray-700">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 19.5 15-15m0 0H8.25m11.25 0v11.25" />
            </svg>
            <span class="ml-3 hidden sm:block">Evaluation des performances</span>
        </a>

        <!-- Tableaux Analytiques -->
        <a href="{{ route('dashboard_entreprise')}}" class="flex items-center px-4 py-2 rounded hover:bg-gray-700">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 14.25v2.25m3-4.5v4.5m3-6.75v6.75m3-9v9M6 20.25h12A2.25 2.25 0 0 0 20.25 18V6A2.25 2.25 0 0 0 18 3.75H6A2.25 2.25 0 0 0 3.75 6v12A2.25 2.25 0 0 0 6 20.25Z" />
            </svg>
            <span class="ml-3 hidden sm:block">Tableaux Analytiques</span>
        </a>
    </nav>
</aside>




        <!-- Contenu principal -->

        @yield('main')


    </div>


    <!--Footer-->
    @include('footer')


    <!-- Chargement de la page avec loading spinner -->
    @include('loading')


    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const matriculeElement = document.getElementById('matricule');
            const toggleEyeElement = document.getElementById('toggleEye');
            let isHidden = true;

            // Matricule réel (en récupérant depuis le backend)
            const matricule = "{{ $entrepriseDetails->matricule_entreprise }}";

            // Ajouter un gestionnaire de clic pour l'icône
            toggleEyeElement.addEventListener('click', function () {
                if (isHidden) {
                    // Afficher le matricule
                    matriculeElement.textContent = matricule;
                    toggleEyeElement.classList.remove('fa-eye-slash');
                    toggleEyeElement.classList.add('fa-eye');
                } else {
                    // Masquer le matricule
                    matriculeElement.textContent = "••••••••••";
                    toggleEyeElement.classList.remove('fa-eye');
                    toggleEyeElement.classList.add('fa-eye-slash');
                }
                isHidden = !isHidden; // Basculer l'état
            });
        });
    </script>
</body>
</html>
