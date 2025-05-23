@extends('dashboard_base')

@section('main')
<main class="flex-1 overflow-hidden relative bg-gradient-to-br from-slate-900 to-slate-800">
    <div class="absolute inset-0 overflow-y-auto hide-scroll p-2">
        <div class="min-h-screen flex items-center justify-center px-4">
            <div class="max-w-4xl w-full space-y-8 animate-fade-in">
                <!-- En-tête avec animation -->
                <div class="flex items-center space-x-4" data-aos="fade-right">
                    <div class="p-3 bg-indigo-500/20 rounded-full">
                        <div class="text-indigo-400 text-3xl">
                            <i class="fas fa-robot"></i>
                        </div>
                    </div>
                    <div>
                        <h1 class="text-3xl font-bold text-white">ManagerAI, l’IA qui vous guide dans la gestion de votre entreprise.</h1>
                        <p class="text-slate-400">Optimisations basées sur vos données</p>
                    </div>
                </div>

                <!-- Carte des conseils -->
                <div class="bg-slate-800/50 backdrop-blur-sm rounded-xl border border-slate-700/50 overflow-hidden shadow-2xl" data-aos="fade-up">
                    <!-- En-tête de la carte -->
                    <div class="bg-gradient-to-r from-indigo-500/10 to-purple-500/10 p-4 border-b border-slate-700/50">
                        <div class="flex items-center justify-between">
                            <h2 class="font-semibold text-indigo-300 flex items-center">
                                <i class="fas fa-lightbulb mr-2"></i> Recommandations intelligentes
                            </h2>
                            <span class="text-xs bg-slate-700/50 text-slate-300 px-2 py-1 rounded-full">
                                Mis à jour : {{ now()->format('d/m/Y H:i') }}
                            </span>
                        </div>
                    </div>

                    <!-- Contenu des conseils -->
                    <div class="p-6">
                        @if($conseils)
                            <div class="prose prose-invert max-w-none">
                                <div class="text-slate-300 whitespace-pre-line leading-relaxed space-y-4">
                                    {!! preg_replace('/\n+/', "\n", $conseils) !!}
                                </div>
                            </div>
                        @else
                            <div class="text-center py-12">
                                <div class="text-slate-500 mb-4 text-5xl">
                                    <i class="fas fa-comment-slash"></i>
                                </div>
                                <p class="text-slate-400">Aucun conseil généré pour le moment.</p>
                                <button id="genererConseilsBtn" class="mt-4 px-6 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg transition-colors flex items-center mx-auto">
                                    <i class="fas fa-sync-alt mr-2"></i> Générer des conseils
                                </button>
                            </div>
                        @endif
                    </div>

                    <!-- Pied de carte -->
                    <div class="bg-slate-800/50 p-4 border-t border-slate-700/50 text-right">
                        <button class="text-xs bg-indigo-600/20 hover:bg-indigo-600/30 text-indigo-300 px-3 py-1 rounded-full transition-colors flex items-center ml-auto">
                            @php
                                $url = route('analyse_conseils');
                            @endphp

                            <a href="{{ $url }}" onclick="showLoadingAndRedirect(event, '{{ $url }}')">
                                <i class="fas fa-sync-alt mr-1 text-xs"></i> Actualiser les conseils
                            </a>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Effets décoratifs -->
    <div class="absolute -bottom-32 -left-32 w-64 h-64 bg-indigo-500 rounded-full mix-blend-multiply filter blur-3xl opacity-5"></div>
    <div class="absolute -top-32 -right-32 w-64 h-64 bg-purple-500 rounded-full mix-blend-multiply filter blur-3xl opacity-5"></div>
</main>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Animation du bouton de génération
    const genererBtn = document.getElementById('genererConseilsBtn');
    if(genererBtn) {
        genererBtn.addEventListener('click', function() {
            // Ajout d'un indicateur de chargement
            genererBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Génération en cours...';
            genererBtn.disabled = true;
            
            fetch('/generer-conseils', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({})
            })
            .then(response => response.json())
            .then(data => {
                // Animation de remplacement du contenu
                const container = document.querySelector('.prose-invert');
                if(container) {
                    container.innerHTML = `<div class="text-slate-300 whitespace-pre-line leading-relaxed space-y-4">${data.conseils}</div>`;
                }
                
                // Notification visuelle
                const notification = document.createElement('div');
                notification.className = 'fixed bottom-4 right-4 bg-indigo-600 text-white px-4 py-2 rounded-lg shadow-lg animate-fade-in';
                notification.innerHTML = '<i class="fas fa-check-circle mr-2"></i> Conseils actualisés avec succès';
                document.body.appendChild(notification);
                
                // Disparition après 3s
                setTimeout(() => {
                    notification.classList.add('opacity-0', 'transition-opacity', 'duration-300');
                    setTimeout(() => notification.remove(), 300);
                }, 3000);
            })
            .catch(error => {
                console.error('Erreur:', error);
                genererBtn.innerHTML = '<i class="fas fa-exclamation-triangle mr-2"></i> Erreur';
                setTimeout(() => {
                    genererBtn.innerHTML = '<i class="fas fa-sync-alt mr-2"></i> Réessayer';
                    genererBtn.disabled = false;
                }, 1500);
            });
        });
    }
    
    // Animation pour le bouton d'actualisation
    const refreshBtn = document.querySelector('[aria-label="Actualiser"]');
    if(refreshBtn) {
        refreshBtn.addEventListener('click', function() {
            this.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
            setTimeout(() => {
                this.innerHTML = '<i class="fas fa-sync-alt"></i>';
            }, 1000);
        });
    }
});
function showLoadingAndRedirect(event, url) {
    event.preventDefault();
    const loadingElement = document.getElementById("loading");
    if (loadingElement) {
        
    }
    setTimeout(() => {
        window.location.href = url;
    }, 100); // délai court pour afficher l'effet
}
</script>

<style>
    .prose-invert a {
        color: #818cf8;
        text-decoration: underline;
        text-decoration-color: #4f46e5;
        text-underline-offset: 2px;
    }
    
    .prose-invert ul {
        list-style-type: disc;
        padding-left: 1.5rem;
        margin-top: 0.5rem;
        margin-bottom: 0.5rem;
    }
    
    .prose-invert ol {
        list-style-type: decimal;
        padding-left: 1.5rem;
        margin-top: 0.5rem;
        margin-bottom: 0.5rem;
    }
    
    .animate-fade-in {
        animation: fadeIn 0.5s ease-out;
    }
    
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>
@endsection