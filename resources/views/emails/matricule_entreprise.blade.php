<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenue - {{ $entreprise->nom_entreprise }}</title>
    <style>
        /* Réinitialisation et styles de base */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            /* Palette slate-900 */
            --slate-50: #f8fafc;
            --slate-100: #f1f5f9;
            --slate-200: #e2e8f0;
            --slate-300: #cbd5e1;
            --slate-400: #94a3b8;
            --slate-500: #64748b;
            --slate-600: #475569;
            --slate-700: #334155;
            --slate-800: #1e293b;
            --slate-900: #0f172a;
            --slate-950: #020617;

            /* Thème principal */
            --bg-primary: var(--slate-900);
            --bg-secondary: var(--slate-800);
            --bg-card: var(--slate-800);
            --bg-highlight: var(--slate-950);
            
            --text-primary: var(--slate-50);
            --text-secondary: var(--slate-300);
            --text-muted: var(--slate-400);
            --text-accent: var(--slate-200);
            
            --border-color: var(--slate-700);
            --border-light: var(--slate-600);
            
            --shadow-color: rgba(2, 6, 23, 0.6);
            --shadow-glow: rgba(203, 213, 225, 0.05);
        }

        body {
            background: linear-gradient(135deg, var(--bg-primary) 0%, var(--bg-highlight) 100%);
            color: var(--text-primary);
            font-family: 'Inter', system-ui, -apple-system, 'Segoe UI', Roboto, sans-serif;
            line-height: 1.6;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
            margin: 0;
            position: relative;
        }

        /* Effet de fond subtil */
        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: 
                radial-gradient(circle at 20% 20%, var(--shadow-glow) 0%, transparent 25%),
                radial-gradient(circle at 80% 80%, var(--shadow-glow) 0%, transparent 25%);
            pointer-events: none;
            z-index: 0;
        }

        /* Conteneur principal */
        .welcome-container {
            max-width: 600px;
            width: 100%;
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: 2rem;
            padding: 3rem;
            box-shadow: 
                0 25px 50px -12px var(--shadow-color),
                inset 0 1px 2px rgba(255, 255, 255, 0.05);
            position: relative;
            z-index: 1;
            backdrop-filter: blur(10px);
            animation: slideUp 0.6s ease-out;
        }

        /* Décoration géométrique */
        .welcome-container::before {
            content: '';
            position: absolute;
            top: -1px;
            left: -1px;
            right: -1px;
            height: 6px;
            background: linear-gradient(90deg, 
                transparent 0%, 
                var(--text-muted) 20%, 
                var(--text-primary) 50%, 
                var(--text-muted) 80%, 
                transparent 100%);
            border-radius: 2rem 2rem 0 0;
            opacity: 0.3;
        }

        /* En-tête avec icône */
        .welcome-header {
            text-align: center;
            margin-bottom: 2.5rem;
            position: relative;
        }

        .welcome-icon {
            width: 80px;
            height: 80px;
            background: var(--bg-highlight);
            border: 2px solid var(--border-color);
            border-radius: 50%;
            margin: 0 auto 1.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            animation: pulseIn 0.8s ease-out 0.2s both;
        }

        .welcome-icon svg {
            width: 40px;
            height: 40px;
            fill: none;
            stroke: var(--text-primary);
            stroke-width: 2;
            stroke-linecap: round;
            stroke-linejoin: round;
        }

        .welcome-icon::after {
            content: '';
            position: absolute;
            top: -4px;
            left: -4px;
            right: -4px;
            bottom: -4px;
            border: 1px solid var(--border-light);
            border-radius: 50%;
            opacity: 0.3;
            animation: ripple 2s infinite;
        }

        /* Titre principal */
        h2 {
            font-size: 2.25rem;
            font-weight: 700;
            letter-spacing: -0.025em;
            color: var(--text-primary);
            margin: 0 0 0.75rem;
            line-height: 1.2;
            text-shadow: 0 2px 4px var(--shadow-color);
        }

        h2 span {
            display: block;
            font-size: 1rem;
            color: var(--text-muted);
            font-weight: 400;
            letter-spacing: normal;
            margin-top: 0.5rem;
        }

        /* Texte de bienvenue */
        .welcome-text {
            font-size: 1.125rem;
            color: var(--text-secondary);
            margin-bottom: 2rem;
            padding: 1rem;
            background: var(--bg-highlight);
            border-radius: 1rem;
            border: 1px solid var(--border-color);
            text-align: center;
            position: relative;
            animation: fadeIn 0.6s ease-out 0.3s both;
        }

        .welcome-text::before {
            content: '"';
            position: absolute;
            top: -10px;
            left: 10px;
            font-size: 3rem;
            color: var(--text-muted);
            opacity: 0.2;
            font-family: serif;
        }

        .welcome-text::after {
            content: '"';
            position: absolute;
            bottom: -20px;
            right: 10px;
            font-size: 3rem;
            color: var(--text-muted);
            opacity: 0.2;
            font-family: serif;
        }

        /* Carte d'information */
        .info-card {
            background: var(--bg-highlight);
            border: 1px solid var(--border-color);
            border-radius: 1.5rem;
            padding: 2rem;
            margin: 2rem 0;
            position: relative;
            overflow: hidden;
            animation: slideIn 0.6s ease-out 0.4s both;
        }

        .info-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, 
                var(--text-muted), 
                var(--text-primary), 
                var(--text-muted));
            opacity: 0.2;
        }

        .info-label {
            font-size: 0.875rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: var(--text-muted);
            margin-bottom: 0.5rem;
            display: block;
        }

        .matricule {
            background: var(--bg-card);
            border: 2px solid var(--border-light);
            border-radius: 1rem;
            padding: 1.5rem;
            margin: 1rem 0 0;
            text-align: center;
            position: relative;
        }

        .matricule strong {
            display: block;
            font-size: 0.875rem;
            color: var(--text-muted);
            font-weight: 500;
            margin-bottom: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .matricule-value {
            font-family: 'Fira Code', 'Courier New', monospace;
            font-size: 2rem;
            font-weight: 700;
            color: var(--text-primary);
            background: linear-gradient(135deg, var(--text-primary) 0%, var(--text-secondary) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            letter-spacing: 0.1em;
            text-shadow: 0 2px 4px var(--shadow-color);
        }

        /* Message d'importance */
        .important-message {
            background: rgba(203, 213, 225, 0.05);
            border-left: 4px solid var(--text-muted);
            padding: 1.25rem;
            border-radius: 0.75rem;
            margin: 2rem 0;
            font-size: 1rem;
            color: var(--text-secondary);
            animation: fadeIn 0.6s ease-out 0.5s both;
        }

        .important-message::before {
            content: 'ℹ️';
            margin-right: 0.75rem;
            opacity: 0.7;
        }

        /* Message de remerciement */
        .thank-you {
            text-align: center;
            margin-top: 2.5rem;
            padding-top: 2rem;
            border-top: 1px solid var(--border-color);
            font-size: 1.125rem;
            color: var(--text-primary);
            font-weight: 500;
            animation: fadeIn 0.6s ease-out 0.6s both;
            position: relative;
        }

        .thank-you::before {
            content: '✨';
            margin-right: 0.5rem;
            opacity: 0.7;
        }

        .thank-you::after {
            content: '✨';
            margin-left: 0.5rem;
            opacity: 0.7;
        }

        /* Animations */
        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateX(-20px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes pulseIn {
            0% {
                opacity: 0;
                transform: scale(0.8);
            }
            50% {
                transform: scale(1.1);
            }
            100% {
                opacity: 1;
                transform: scale(1);
            }
        }

        @keyframes ripple {
            0% {
                transform: scale(1);
                opacity: 0.3;
            }
            50% {
                transform: scale(1.1);
                opacity: 0.1;
            }
            100% {
                transform: scale(1);
                opacity: 0.3;
            }
        }

        /* Effet de survol sur le matricule */
        .matricule:hover {
            border-color: var(--text-muted);
            box-shadow: 0 10px 25px -5px var(--shadow-color);
            transition: all 0.3s ease;
        }

        .matricule:hover .matricule-value {
            background: linear-gradient(135deg, var(--text-primary) 0%, var(--slate-200) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        /* Responsive */
        @media (max-width: 640px) {
            body {
                padding: 1rem;
            }

            .welcome-container {
                padding: 2rem 1.5rem;
                border-radius: 1.5rem;
            }

            h2 {
                font-size: 1.75rem;
            }

            .matricule-value {
                font-size: 1.5rem;
            }

            .welcome-icon {
                width: 60px;
                height: 60px;
            }

            .welcome-icon svg {
                width: 30px;
                height: 30px;
            }
        }

        /* Mode sombre renforcé */
        @media (prefers-color-scheme: dark) {
            :root {
                --bg-primary: var(--slate-950);
                --bg-card: var(--slate-900);
            }
        }

        /* Accessibilité */
        @media (prefers-reduced-motion: reduce) {
            * {
                animation-duration: 0.01ms !important;
                animation-iteration-count: 1 !important;
                transition-duration: 0.01ms !important;
            }
        }
    </style>
</head>
<body>
    <div class="welcome-container">
        <div class="welcome-header">
            <div class="welcome-icon">
                <svg viewBox="0 0 24 24">
                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                    <circle cx="12" cy="7" r="4"></circle>
                </svg>
            </div>
            <h2>
                Bienvenue {{ $entreprise->nom_entreprise }}
                <span>Votre espace professionnel est prêt</span>
            </h2>
        </div>

        <div class="welcome-text">
            Votre entreprise a été enregistrée avec succès dans notre système.
        </div>

        <div class="info-card">
            <span class="info-label">Identifiant unique</span>
            <div class="matricule">
                <strong>Matricule d'identification</strong>
                <div class="matricule-value">{{ $entreprise->matricule_entreprise }}</div>
            </div>
        </div>

        <div class="important-message">
            Conservez précieusement ce matricule pour toutes vos futures opérations et communications avec nos services.
        </div>

        <div class="thank-you">
            Merci de votre confiance | L’equipe EM-Manager
        </div>
    </div>
</body>
</html>