<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="/images/management.png" type="image/x-icon">
    <title>404 Entreprise - EM-Manager</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex justify-center items-center h-screen">

    <div class="bg-slate-900 text-white p-8 rounded-lg shadow-lg max-w-md w-full mx-[15px]">
        <div class="flex items-center mb-4">
            <!-- Icône d'attention -->
            <div class="bg-slate-400 text-slate-900 p-2 rounded-full mr-3">
                <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M21 12l-9-9-9 9h18z"/>
                </svg>
            </div>
            <h2 class="text-2xl font-semibold">Cette page est destinée uniquement à l'entreprise</h2>
        </div>
        <p class="mb-6">Si vous n'êtes pas une entreprise, connectez vous ou veuillez revenir à la page précédente.</p>
        
        <div class="flex justify-center m-auto flex-row float-end flex-wrap gap-5">
            <a href="javascript:history.back()" class="bg-slate-800 hover:bg-slate-700 text-white py-2 px-4 rounded-md transition duration-300">Revenir en arrière</a>
            <a href="{{route('login')}}" class="bg-slate-600 hover:bg-slate-700 text-white py-2 px-4 rounded-md transition duration-300">Se connecter</a>
        </div>
    </div>

</body>
</html>
