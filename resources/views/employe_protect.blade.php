<!DOCTYPE html>
<html lang="fr" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accès Entreprise - EM-Manager</title>
    <link rel="shortcut icon" href="/images/management.png" type="image/x-icon">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
        
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #f3f4f6 0%, #e5e7eb 100%);
        }
        
        .error-card {
            background: linear-gradient(145deg, #0f172a 0%, #1e293b 100%);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.2), 0 10px 10px -5px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
        }
        
        .warning-icon {
            background: linear-gradient(135deg, #f59e0b 0%, #ef4444 100%);
            box-shadow: 0 0 15px rgba(239, 68, 68, 0.4);
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #3b82f6 0%, #6366f1 100%);
            transition: all 0.3s ease;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(59, 130, 246, 0.3);
        }
        
        .btn-secondary {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            transition: all 0.3s ease;
        }
        
        .btn-secondary:hover {
            background: rgba(255, 255, 255, 0.2);
            transform: translateY(-2px);
        }
        
        .glow {
            animation: glow 2s infinite alternate;
        }
        
        @keyframes glow {
            from {
                box-shadow: 0 0 10px rgba(239, 68, 68, 0.5);
            }
            to {
                box-shadow: 0 0 20px rgba(239, 68, 68, 0.8);
            }
        }
    </style>
</head>
<body class="h-full flex items-center justify-center p-4">
    <div class="error-card rounded-xl p-8 max-w-md w-full mx-4 text-center">
        <!-- Icône animée -->
        <div class=" w-16 h-16 rounded-full flex items-center justify-center text-white text-2xl mx-auto mb-6 glow">
            <i class="fas fa-exclamation"></i>
        </div>
        
        <h1 class="text-2xl md:text-3xl font-bold text-white mb-4">Accès réservé aux employés</h1>
        
        <p class="text-slate-300 mb-8">
            Cette section est exclusivement réservée aux comptes employés. 
            Veuillez vous connecter avec un compte autorisé ou retourner à la page précédente.
        </p>
        
        <div class="flex flex-col sm:flex-row justify-center gap-4">
            <a href="javascript:history.back()" class="btn-secondary text-white font-medium py-3 px-6 rounded-lg">
                <i class="fas fa-arrow-left mr-2"></i> Retour
            </a>
            <a href="{{route('login')}}" class="bg-slate-900 hover:bg-slate-950 text-white font-medium py-3 px-6 rounded-lg">
                <i class="fas fa-sign-in-alt mr-2"></i> Connexion Employé
            </a>
        </div>
        
    </div>

    <!-- Effets décoratifs -->
    <div class="fixed -bottom-32 -left-32 w-64 h-64 bg-blue-500 rounded-full mix-blend-multiply filter blur-3xl opacity-10 z-[-1]"></div>
    <div class="fixed -top-32 -right-32 w-64 h-64 bg-purple-500 rounded-full mix-blend-multiply filter blur-3xl opacity-10 z-[-1]"></div>
</body>
</html>