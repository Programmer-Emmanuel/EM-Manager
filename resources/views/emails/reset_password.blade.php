<!DOCTYPE html>
<html>
<head>
    <title>Réinitialisation du mot de passe</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background-color: #0f172a; /* slate-900 */
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
        }

        .container {
            max-width: 448px;
            width: 100%;
        }

        .card {
            background-color: #1e293b; /* slate-800 */
            border-radius: 1rem;
            border: 1px solid #334155; /* slate-700 */
            padding: 2rem;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
        }

        /* En-tête */
        .header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .icon-wrapper {
            display: inline-flex;
            padding: 0.75rem;
            background-color: rgba(59, 130, 246, 0.1); /* blue-500/10 */
            border-radius: 9999px;
            margin-bottom: 1rem;
        }

        .icon {
            width: 2rem;
            height: 2rem;
            color: #60a5fa; /* blue-400 */
        }

        h1 {
            font-size: 1.875rem;
            font-weight: 700;
            color: white;
            margin-bottom: 0.5rem;
        }

        .subtitle {
            color: #94a3b8; /* slate-400 */
        }

        /* Messages */
        .welcome-box {
            background-color: rgba(15, 23, 42, 0.5); /* slate-900/50 */
            border-radius: 0.75rem;
            border: 1px solid #334155; /* slate-700 */
            padding: 1rem;
            margin-bottom: 1.5rem;
        }

        h2 {
            font-size: 1.25rem;
            font-weight: 600;
            color: white;
            margin-bottom: 0.5rem;
        }

        .name-highlight {
            color: #60a5fa; /* blue-400 */
        }

        .text-slate {
            color: #cbd5e1; /* slate-300 */
        }

        /* Mot de passe */
        .password-box {
            background-color: #0f172a; /* slate-900 */
            border-radius: 0.75rem;
            border: 2px solid rgba(59, 130, 246, 0.3); /* blue-500/30 */
            padding: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .password-label {
            color: #94a3b8; /* slate-400 */
            font-size: 0.875rem;
            margin-bottom: 0.5rem;
        }

        .password-content {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .password-code {
            font-size: 1.5rem;
            font-family: 'SF Mono', 'Monaco', 'Inconsolata', 'Fira Mono', monospace;
            font-weight: 700;
            color: #60a5fa; /* blue-400 */
        }

        .badge {
            padding: 0.25rem 0.75rem;
            background-color: rgba(59, 130, 246, 0.2); /* blue-500/20 */
            color: #60a5fa; /* blue-400 */
            font-size: 0.75rem;
            font-weight: 600;
            border-radius: 9999px;
            border: 1px solid rgba(59, 130, 246, 0.3); /* blue-500/30 */
        }

        /* Instructions */
        .alert-box {
            background-color: rgba(234, 179, 8, 0.1); /* yellow-500/10 */
            border-radius: 0.75rem;
            border: 1px solid rgba(234, 179, 8, 0.2); /* yellow-500/20 */
            padding: 1rem;
            margin-bottom: 2rem;
        }

        .alert-content {
            display: flex;
            gap: 0.75rem;
        }

        .alert-icon {
            width: 1.25rem;
            height: 1.25rem;
            color: #fbbf24; /* yellow-400 */
            flex-shrink: 0;
            margin-top: 0.125rem;
        }

        .alert-text {
            color: #fef08a; /* yellow-200 */
            font-size: 0.875rem;
            line-height: 1.5;
        }

        /* Bouton */
        .btn {
            display: block;
            width: 100%;
            padding: 0.75rem 1rem;
            background-color: #2563eb; /* blue-600 */
            color: white;
            text-decoration: none;
            font-weight: 600;
            border-radius: 0.75rem;
            border: 1px solid rgba(96, 165, 250, 0.3); /* blue-400/30 */
            text-align: center;
            transition: all 0.2s;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.3);
            margin-bottom: 2rem;
        }

        .btn:hover {
            background-color: #1d4ed8; /* blue-700 */
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.4);
        }

        /* Footer */
        .footer {
            padding-top: 1.5rem;
            border-top: 1px solid #334155; /* slate-700 */
            text-align: center;
        }

        .footer-text {
            color: #64748b; /* slate-500 */
            font-size: 0.75rem;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <!-- En-tête avec icône -->
            <div class="header">
                <div class="icon-wrapper">
                    <svg class="icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                </div>
                <h1>Réinitialisation</h1>
                <p class="subtitle">de votre mot de passe</p>
            </div>

            <!-- Message de bienvenue -->
            <div class="welcome-box">
                <h2>
                    Bonjour <span class="name-highlight">{{ $userName }}</span>,
                </h2>
                <p class="text-slate">
                    Votre mot de passe a été réinitialisé avec succès.
                </p>
            </div>

            <!-- Nouveau mot de passe -->
            <div class="password-box">
                <div class="password-label">Nouveau mot de passe :</div>
                <div class="password-content">
                    <code class="password-code">{{ $password }}</code>
                    <span class="badge">À conserver</span>
                </div>
            </div>

            <!-- Instructions -->
            <div class="alert-box">
                <div class="alert-content">
                    <svg class="alert-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <p class="alert-text">
                        Merci de vous connecter et de le changer après votre première connexion.
                    </p>
                </div>
            </div>

            <!-- Bouton -->
            <a href="#" class="btn">
                Se connecter
            </a>

            <!-- Footer -->
            <div class="footer">
                <p class="footer-text">
                    Cet email a été envoyé automatiquement, merci de ne pas y répondre.
                </p>
            </div>
        </div>
    </div>
</body>
</html>