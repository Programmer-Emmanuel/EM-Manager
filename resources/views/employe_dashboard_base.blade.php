<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Employe - EM-Manager</title>
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
    </style>
</head>
<body class="bg-gray-100">
    <!-- Barre de navigation : nav.blade.php -->
    @include('nav')

    <div class="flex border-t-[2px] h-full">
        <!-- Menu latéral -->
        <aside class="w-20 sm:w-72 bg-gray-800 text-white h-screen-full border-r-[2px] border-gray-50">
    <div class="p-4 text-lg font-bold border-b border-gray-700">
        <span class="hidden sm:inline">{{$employeDetails->nom_employe}} {{$employeDetails->prenom_employe}}</span><br>
        <p class="flex sm:flex-row flex-col items-center justify-center sm:justify-start mt-2 sm:mt-0 italic">
            <span id="matricule">••••••••••</span>
            <i class="fas fa-eye-slash eye-icon text-base sm:text-lg" id="toggleEye"></i>
        </p>


    </div>
    <nav class="p-4 space-y-2 sm:static">
        <!-- Gestion des employés -->

        <a href="{{ route('employe_dashboard')}}" class="flex items-center px-4 py-2 rounded hover:bg-gray-700">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
            </svg>
            <span class="ml-3 hidden sm:block">Acceuil</span>
        </a>

        <!-- Mes infos -->
        <a href="{{route('employe_compte')}}" class="flex items-center px-4 py-2 rounded hover:bg-gray-700">
            <svg class="w-5 h-5 text-gray-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87M12 11a4 4 0 100-8 4 4 0 000 8zm0 2c4.28 0 8 2.03 8 5v1H4v-1c0-2.97 3.72-5 8-5z" />
            </svg>
            <span class="ml-3 hidden sm:block">Mon compte</span>
        </a>

        <!-- Gestion des congés -->
        <a href="{{ route('employe_conge') }}" class="flex items-center px-4 py-2 rounded hover:bg-gray-700">
            <svg class="w-5 h-5 text-gray-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>
            <span class="ml-3 hidden sm:block">Demande de congés</span>
        </a>

        <!-- Suivi des présences -->
        <a href="" class="flex items-center px-4 py-2 rounded hover:bg-gray-700">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
            </svg>
            <span class="ml-3 hidden sm:block">Mes présences</span>
        </a>

        <!-- Traitement des paies -->
        <a href="" class="flex items-center px-4 py-2 rounded hover:bg-gray-700">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 0 0 2.25-2.25V6.75A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25v10.5A2.25 2.25 0 0 0 4.5 19.5Z" />
            </svg>
            <span class="ml-3 hidden sm:block">Historique des paies</span>
        </a>

        <!--Changer mot de passe -->
        <a href="{{route('update_password')}}" class="flex items-center px-4 py-2 rounded hover:bg-gray-700">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.343 3.94c.09-.542.56-.94 1.11-.94h1.093c.55 0 1.02.398 1.11.94l.149.894c.07.424.384.764.78.93.398.164.855.142 1.205-.108l.737-.527a1.125 1.125 0 0 1 1.45.12l.773.774c.39.389.44 1.002.12 1.45l-.527.737c-.25.35-.272.806-.107 1.204.165.397.505.71.93.78l.893.15c.543.09.94.559.94 1.109v1.094c0 .55-.397 1.02-.94 1.11l-.894.149c-.424.07-.764.383-.929.78-.165.398-.143.854.107 1.204l.527.738c.32.447.269 1.06-.12 1.45l-.774.773a1.125 1.125 0 0 1-1.449.12l-.738-.527c-.35-.25-.806-.272-1.203-.107-.398.165-.71.505-.781.929l-.149.894c-.09.542-.56.94-1.11.94h-1.094c-.55 0-1.019-.398-1.11-.94l-.148-.894c-.071-.424-.384-.764-.781-.93-.398-.164-.854-.142-1.204.108l-.738.527c-.447.32-1.06.269-1.45-.12l-.773-.774a1.125 1.125 0 0 1-.12-1.45l.527-.737c.25-.35.272-.806.108-1.204-.165-.397-.506-.71-.93-.78l-.894-.15c-.542-.09-.94-.56-.94-1.109v-1.094c0-.55.398-1.02.94-1.11l.894-.149c.424-.07.765-.383.93-.78.165-.398.143-.854-.108-1.204l-.526-.738a1.125 1.125 0 0 1 .12-1.45l.773-.773a1.125 1.125 0 0 1 1.45-.12l.737.527c.35.25.807.272 1.204.107.397-.165.71-.505.78-.929l.15-.894Z" />
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
            </svg>

            <span class="ml-3 hidden sm:block">Changer mon mot de passe</span>
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
            const matricule = "{{ $employeDetails->matricule_employe }}";

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
