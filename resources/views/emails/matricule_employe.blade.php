<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenue - {{ $employe->prenom_employe }} {{ $employe->nom_employe }}</title>
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
            --bg-accent: var(--slate-700);
            
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
            background: linear-gradient(145deg, var(--bg-primary) 0%, var(--bg-highlight) 100%);
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

        /* Effet de fond avec particules */
        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: 
                radial-gradient(circle at 30% 40%, var(--shadow-glow) 0%, transparent 30%),
                radial-gradient(circle at 70% 60%, var(--shadow-glow) 0%, transparent 30%),
                radial-gradient(circle at 10% 80%, var(--shadow-glow) 0%, transparent 20%);
            pointer-events: none;
            z-index: 0;
        }

        /* Conteneur principal */
        .welcome-container {
            max-width: 650px;
            width: 100%;
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: 2rem;
            padding: 3rem;
            box-shadow: 
                0 30px 60px -15px var(--shadow-color),
                inset 0 1px 2px rgba(255, 255, 255, 0.05);
            position: relative;
            z-index: 1;
            backdrop-filter: blur(10px);
            animation: containerAppear 0.7s cubic-bezier(0.2, 0.9, 0.3, 1);
        }

        /* Décoration de coin */
        .welcome-container::after {
            content: '';
            position: absolute;
            top: 1rem;
            right: 1rem;
            width: 50px;
            height: 50px;
            border-top: 2px solid var(--border-light);
            border-right: 2px solid var(--border-light);
            opacity: 0.2;
            border-radius: 0 1rem 0 0;
        }

        /* En-tête avec avatar */
        .welcome-header {
            text-align: center;
            margin-bottom: 2.5rem;
            position: relative;
        }

        .avatar {
            width: 100px;
            height: 100px;
            background: linear-gradient(145deg, var(--bg-highlight), var(--bg-accent));
            border: 3px solid var(--border-light);
            border-radius: 50%;
            margin: 0 auto 1.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            animation: avatarAppear 0.8s ease-out 0.2s both;
            box-shadow: 0 10px 20px -5px var(--shadow-color);
        }

        .avatar svg {
            width: 50px;
            height: 50px;
            fill: none;
            stroke: var(--text-primary);
            stroke-width: 1.5;
            stroke-linecap: round;
            stroke-linejoin: round;
        }

        .avatar-status {
            position: absolute;
            bottom: 5px;
            right: 5px;
            width: 16px;
            height: 16px;
            background: #10b981;
            border: 2px solid var(--bg-card);
            border-radius: 50%;
            animation: pulse 2s infinite;
        }

        /* Titre principal */
        h2 {
            font-size: 2.25rem;
            font-weight: 700;
            letter-spacing: -0.025em;
            color: var(--text-primary);
            margin: 0 0 0.5rem;
            line-height: 1.3;
            text-shadow: 0 2px 4px var(--shadow-color);
        }

        h2 .subtitle {
            display: block;
            font-size: 1rem;
            color: var(--text-muted);
            font-weight: 400;
            letter-spacing: 0.05em;
            margin-top: 0.5rem;
            text-transform: uppercase;
        }

        /* Badge de bienvenue */
        .welcome-badge {
            display: inline-block;
            background: var(--bg-highlight);
            border: 1px solid var(--border-color);
            border-radius: 2rem;
            padding: 0.5rem 1.5rem;
            margin-bottom: 2rem;
            font-size: 0.875rem;
            color: var(--text-secondary);
            animation: fadeIn 0.6s ease-out 0.3s both;
        }

        .welcome-badge span {
            color: var(--text-primary);
            font-weight: 600;
            margin-left: 0.25rem;
        }

        /* Grille d'informations */
        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
            margin: 2rem 0;
            animation: slideUp 0.6s ease-out 0.4s both;
        }

        .info-item {
            background: var(--bg-highlight);
            border: 1px solid var(--border-color);
            border-radius: 1.25rem;
            padding: 1.5rem;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .info-item:hover {
            transform: translateY(-4px);
            border-color: var(--text-muted);
            box-shadow: 0 15px 30px -10px var(--shadow-color);
        }

        .info-item::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, 
                transparent, 
                var(--text-muted), 
                transparent);
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .info-item:hover::before {
            opacity: 0.3;
        }

        .info-icon {
            width: 40px;
            height: 40px;
            margin-bottom: 1rem;
            color: var(--text-muted);
        }

        .info-icon svg {
            width: 100%;
            height: 100%;
            stroke: currentColor;
            stroke-width: 1.5;
        }

        .info-label {
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: var(--text-muted);
            margin-bottom: 0.5rem;
            display: block;
        }

        .info-value {
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--text-primary);
            word-break: break-word;
        }

        /* Carte matricule spéciale */
        .matricule-card {
            grid-column: span 2;
            background: linear-gradient(145deg, var(--bg-highlight), var(--bg-accent));
            border: 2px solid var(--border-light);
            border-radius: 1.5rem;
            padding: 1.5rem;
            margin: 1rem 0;
            display: flex;
            align-items: center;
            gap: 1.5rem;
            position: relative;
            animation: glowPulse 3s infinite;
        }

        .matricule-icon {
            width: 60px;
            height: 60px;
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .matricule-icon svg {
            width: 30px;
            height: 30px;
            stroke: var(--text-primary);
        }

        .matricule-content {
            flex: 1;
        }

        .matricule-label {
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            color: var(--text-muted);
            margin-bottom: 0.25rem;
        }

        .matricule-value {
            font-family: 'Fira Code', 'Courier New', monospace;
            font-size: 1.75rem;
            font-weight: 700;
            color: var(--text-primary);
            letter-spacing: 0.1em;
            background: linear-gradient(135deg, var(--text-primary) 0%, var(--text-secondary) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .matricule-copy {
            margin-left: auto;
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: 0.75rem;
            padding: 0.75rem;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .matricule-copy:hover {
            background: var(--bg-accent);
            border-color: var(--text-muted);
        }

        .matricule-copy svg {
            width: 20px;
            height: 20px;
            stroke: var(--text-muted);
        }

        /* Message d'instructions */
        .instructions {
            background: rgba(203, 213, 225, 0.03);
            border: 1px dashed var(--border-color);
            border-radius: 1.25rem;
            padding: 1.5rem;
            margin: 2rem 0 1.5rem;
            display: flex;
            align-items: flex-start;
            gap: 1rem;
            animation: fadeIn 0.6s ease-out 0.5s both;
        }

        .instructions-icon {
            font-size: 1.5rem;
            line-height: 1;
        }

        .instructions-text {
            color: var(--text-secondary);
            font-size: 1rem;
            flex: 1;
        }

        .instructions-text strong {
            color: var(--text-primary);
            font-weight: 600;
        }

        /* Section remerciement */
        .thank-you-section {
            text-align: center;
            margin-top: 2.5rem;
            padding: 2rem 0 0;
            border-top: 1px solid var(--border-color);
            position: relative;
        }

        .thank-you-message {
            font-size: 1.25rem;
            color: var(--text-primary);
            font-weight: 500;
            margin-bottom: 1rem;
            animation: fadeIn 0.6s ease-out 0.6s both;
        }

        .signature {
            font-size: 0.875rem;
            color: var(--text-muted);
            font-style: italic;
        }

        .dots-decoration {
            display: flex;
            justify-content: center;
            gap: 0.5rem;
            margin-bottom: 1rem;
        }

        .dot {
            width: 4px;
            height: 4px;
            background: var(--text-muted);
            border-radius: 50%;
            opacity: 0.3;
        }

        /* Animations */
        @keyframes containerAppear {
            from {
                opacity: 0;
                transform: scale(0.95) translateY(20px);
            }
            to {
                opacity: 1;
                transform: scale(1) translateY(0);
            }
        }

        @keyframes avatarAppear {
            0% {
                opacity: 0;
                transform: scale(0.5) rotate(-10deg);
            }
            50% {
                transform: scale(1.1) rotate(5deg);
            }
            100% {
                opacity: 1;
                transform: scale(1) rotate(0);
            }
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(20px);
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

        @keyframes pulse {
            0%, 100% {
                transform: scale(1);
                opacity: 1;
            }
            50% {
                transform: scale(1.2);
                opacity: 0.7;
            }
        }

        @keyframes glowPulse {
            0%, 100% {
                box-shadow: 0 0 20px rgba(203, 213, 225, 0.05);
            }
            50% {
                box-shadow: 0 0 30px rgba(203, 213, 225, 0.1);
            }
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

            .info-grid {
                grid-template-columns: 1fr;
                gap: 0.75rem;
            }

            .matricule-card {
                grid-column: span 1;
                flex-direction: column;
                text-align: center;
                gap: 1rem;
            }

            .matricule-icon {
                margin: 0 auto;
            }

            .matricule-copy {
                margin: 0 auto;
            }

            .matricule-value {
                font-size: 1.25rem;
            }

            .avatar {
                width: 80px;
                height: 80px;
            }

            .avatar svg {
                width: 40px;
                height: 40px;
            }

            .info-item {
                padding: 1.25rem;
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
            
            .avatar-status {
                animation: none;
            }
            
            .matricule-card {
                animation: none;
            }
        }
    </style>
</head>
<body>
    <div class="welcome-container">
        <div class="welcome-header">
            <div class="avatar">
                <svg viewBox="0 0 24 24">
                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                    <circle cx="12" cy="7" r="4"></circle>
                </svg>
                <div class="avatar-status"></div>
            </div>
            <h2>
                {{ $employe->prenom_employe }} {{ $employe->nom_employe }}
                <span class="subtitle">Nouveau membre de l'équipe</span>
            </h2>
        </div>

        <div class="welcome-badge">
            ✨ Bienvenue dans l'entreprise
            <span>🎉</span>
        </div>

        <!-- Carte matricule mise en avant -->
        <div class="matricule-card">
            <div class="matricule-icon">
                <svg viewBox="0 0 24 24">
                    <rect x="3" y="5" width="18" height="14" rx="2" ry="2"></rect>
                    <line x1="8" y1="9" x2="16" y2="9"></line>
                    <line x1="8" y1="13" x2="12" y2="13"></line>
                </svg>
            </div>
            <div class="matricule-content">
                <div class="matricule-label">Matricule d'identification</div>
                <div class="matricule-value">{{ $employe->matricule_employe }}</div>
            </div>
            <div class="matricule-copy" title="Copier le matricule" onclick="navigator.clipboard?.writeText('{{ $employe->matricule_employe }}')">
                <svg viewBox="0 0 24 24">
                    <rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect>
                    <path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path>
                </svg>
            </div>
        </div>

        <!-- Grille d'informations -->
        <div class="info-grid">
            <div class="info-item">
                <div class="info-icon">
                    <svg viewBox="0 0 24 24">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                        <circle cx="12" cy="7" r="4"></circle>
                    </svg>
                </div>
                <span class="info-label">Prénom</span>
                <div class="info-value">{{ $employe->prenom_employe }}</div>
            </div>

            <div class="info-item">
                <div class="info-icon">
                    <svg viewBox="0 0 24 24">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                        <circle cx="12" cy="7" r="4"></circle>
                    </svg>
                </div>
                <span class="info-label">Nom</span>
                <div class="info-value">{{ $employe->nom_employe }}</div>
            </div>

            <div class="info-item" style="grid-column: span 2;">
                <div class="info-icon">
                    <svg viewBox="0 0 24 24">
                        <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4z"></path>
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                    </svg>
                </div>
                <span class="info-label">Poste occupé</span>
                <div class="info-value">{{ $employe->poste }}</div>
            </div>
        </div>

        <!-- Instructions -->
        <div class="instructions">
            <div class="instructions-icon">🔐</div>
            <div class="instructions-text">
                <strong>Conservez ce matricule</strong> — Il vous sera demandé pour toutes vos connexions futures et communications avec l'entreprise.
            </div>
        </div>

        <!-- Remerciements -->
        <div class="thank-you-section">
            <div class="dots-decoration">
                <span class="dot"></span>
                <span class="dot"></span>
                <span class="dot"></span>
                <span class="dot"></span>
                <span class="dot"></span>
            </div>
            <div class="thank-you-message">
                Merci de faire partie de l'équipe
            </div>
            <div class="signature">
                L'équipe EM-Manager vous souhaite une excellente intégration
            </div>
        </div>
    </div>
</body>
</html>