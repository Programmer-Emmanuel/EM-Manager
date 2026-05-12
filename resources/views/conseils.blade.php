@extends('dashboard_base')

@section('main')
<main class="flex-1 overflow-hidden relative bg-slate-900">
    <div class="absolute inset-0 overflow-y-auto hide-scroll p-2">
        <div class="min-h-screen px-4 py-8">
            <div class="max-w-6xl mx-auto space-y-8 animate-fade-in">
                <!-- En-tête -->
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4" data-aos="fade-right">

                    <!-- Partie gauche -->
                    <div class="flex items-start md:items-center space-x-3 md:space-x-4">
                        <div class="p-2 md:p-3 bg-indigo-500/20 rounded-full">
                            <div class="text-indigo-400 text-2xl md:text-3xl">
                                <i class="fas fa-lightbulb"></i>
                            </div>
                        </div>

                        <div>
                            <h1 class="text-xl md:text-3xl font-bold text-white">
                                Conseils financiers
                            </h1>
                            <p class="text-sm md:text-base text-slate-400">
                                Recommandations personnalisées basées sur vos transactions
                            </p>
                        </div>
                    </div>

                    <!-- Bouton -->
                    <a href="{{ route('chat.ai.page') }}" 
                    class="w-full md:w-auto flex items-center justify-center md:justify-start space-x-2 
                            bg-gradient-to-r from-yellow-600 to-orange-500 
                            hover:from-orange-700 hover:to-orange-600 
                            text-white px-4 md:px-5 py-2.5 md:py-3 
                            rounded-lg transition-all duration-300 
                            shadow-lg hover:shadow-xl text-sm md:text-base">

                        <i class="fas fa-comments"></i>
                        <span>Assistant IA</span>
                        <i class="fas fa-chevron-right text-sm"></i>
                    </a>

                </div>
                <!-- Section conseils -->
                <div class="bg-slate-800 backdrop-blur-sm rounded-xl border border-slate-700/50 overflow-hidden" data-aos="fade-up">
                    <div class="bg-gradient-to-r from-indigo-500/10 to-purple-500/10 p-4 border-b border-slate-700/50">
                        <div class="flex items-center justify-between">
                            <h2 class="font-semibold text-indigo-300 flex items-center">
                                <i class="fas fa-chart-line mr-2"></i> Recommandations intelligentes
                            </h2>
                            <span class="text-xs bg-slate-700/50 text-slate-300 px-2 py-1 rounded-full">
                                Mis à jour : {{ now()->format('d/m/Y H:i') }}
                            </span>
                        </div>
                    </div>

                    <div class="p-6">
                        @if($conseils && $conseils != 'Aucun conseil généré. OpenRouter est temporairement indisponible.' && $conseils != 'Contenu reçu mais non exploitable.')
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                @php
                                    $conseilsArray = explode("\n\n", $conseils);
                                    $conseilsArray = array_filter($conseilsArray, function($conseil) {
                                        return !empty(trim($conseil));
                                    });
                                @endphp
                                
                                @foreach($conseilsArray as $index => $conseil)
                                    @if(trim($conseil) != '')
                                    <div class="bg-slate-700/30 rounded-lg p-4 border border-slate-600/30 hover:border-indigo-500/30 transition-all duration-300 hover:transform hover:scale-[1.02] group">
                                        <div class="flex items-start space-x-3">
                                            <div class="flex-shrink-0 w-8 h-8 bg-indigo-500/20 rounded-full flex items-center justify-center group-hover:bg-indigo-500/30 transition-colors">
                                                <span class="text-indigo-300 font-bold text-sm">{{ $index + 1 }}</span>
                                            </div>
                                            <div class="flex-1">
                                                <p class="text-slate-200 text-sm leading-relaxed">{{ preg_replace('/^\d+\.\s*/', '', $conseil) }}</p>
                                            </div>
                                        </div>
                                        <div class="mt-3 pt-3 border-t border-slate-600/30 flex justify-end">
                                            <span class="text-xs text-slate-400 bg-slate-800/50 px-2 py-1 rounded-full">
                                                Conseil {{ $index + 1 }}
                                            </span>
                                        </div>
                                    </div>
                                    @endif
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-12">
                                <div class="text-slate-500 mb-4 text-5xl">
                                    <i class="fas fa-chart-simple"></i>
                                </div>
                                <p class="text-slate-400">Aucun conseil généré pour le moment.</p>
                                @php
                                    $url = route('analyse_conseils');
                                @endphp
                                <button 
                                    id="genererConseilsBtn"
                                    onclick="showLoadingAndRedirect(event, '{{ $url }}')"
                                    class="mt-4 px-6 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg transition-colors flex items-center mx-auto">
                                    <i class="fas fa-sync-alt mr-2"></i> Générer des conseils
                                </button>
                            </div>
                        @endif
                    </div>

                    <div class="bg-slate-800/50 p-4 border-t border-slate-700/50 text-right">
                        @php
                            $url = route('analyse_conseils');
                        @endphp
                        <button 
                            id="actualiserConseilsBtn" 
                            onclick="showLoadingAndRedirect(event, '{{ $url }}')"
                            class="text-xs bg-indigo-600/20 hover:bg-indigo-600/30 text-indigo-300 px-3 py-1 rounded-full transition-colors flex items-center ml-auto">
                            <i class="fas fa-sync-alt mr-1 text-xs"></i> Actualiser les conseils
                        </button>
                    </div>
                </div>

                <!-- Section d'information -->
                <div class="bg-slate-800/50 rounded-lg p-4 border border-slate-700/30">
                    <div class="flex items-start space-x-3">
                        <div class="flex-shrink-0 w-10 h-10 bg-indigo-500/20 rounded-full flex items-center justify-center">
                            <i class="fas fa-info-circle text-indigo-400"></i>
                        </div>
                        <div class="flex-1">
                            <p class="text-slate-300 text-sm">
                                <span class="font-semibold text-indigo-300">À propos des conseils :</span> 
                                Ces recommandations sont générées par IA en analysant vos dernières transactions. 
                                Pour des questions plus spécifiques, utilisez l'<a href="{{ route('chat.ai.page') }}" class="text-yellow-400 hover:text-yellow-300">Assistant IA</a>.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="absolute -bottom-32 -left-32 w-64 h-64 bg-indigo-500 rounded-full mix-blend-multiply filter blur-3xl opacity-5"></div>
    <div class="absolute -top-32 -right-32 w-64 h-64 bg-purple-500 rounded-full mix-blend-multiply filter blur-3xl opacity-5"></div>
</main>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const genererBtn = document.getElementById('genererConseilsBtn');
    const actualiserBtn = document.getElementById('actualiserConseilsBtn');
    
    function actualiserConseils() {
        const btn = actualiserBtn || genererBtn;
        if (!btn) return;
        
        const originalHtml = btn.innerHTML;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-1 text-xs"></i> Génération...';
        btn.disabled = true;
        
        fetch('{{ route("analyse_conseils") }}', {
            method: 'GET',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => {
            if (response.ok) {
                window.location.reload();
            } else {
                throw new Error('Erreur de génération');
            }
        })
        .catch(error => {
            console.error('Erreur:', error);
            btn.innerHTML = originalHtml;
            btn.disabled = false;
            showNotification('Erreur lors de la génération des conseils', 'error');
        });
    }
    
    if (genererBtn) {
        genererBtn.addEventListener('click', actualiserConseils);
    }
    
    if (actualiserBtn) {
        actualiserBtn.addEventListener('click', actualiserConseils);
    }
    
    function showNotification(message, type) {
        const notification = document.createElement('div');
        notification.className = `fixed top-4 right-4 z-50 px-4 py-3 rounded-lg shadow-xl transform transition-all duration-300 ${
            type === 'error' ? 'bg-red-600' : 'bg-green-600'
        } text-white`;
        notification.innerHTML = `
            <div class="flex items-center">
                <i class="fas ${type === 'error' ? 'fa-exclamation-circle' : 'fa-check-circle'} mr-2"></i>
                <span class="text-sm">${message}</span>
            </div>
        `;
        document.body.appendChild(notification);
        
        setTimeout(() => {
            notification.style.opacity = '0';
            setTimeout(() => notification.remove(), 300);
        }, 3000);
    }
});


    function showLoadingAndRedirect(event, url) {
        event.preventDefault();
        const loadingElement = document.getElementById("loading");
        if (loadingElement) loadingElement.style.display = "flex";
        setTimeout(() => window.location.href = url, 100);
    }
</script>

<style>
.animate-fade-in {
    animation: fadeIn 0.5s ease-out;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}

.grid > div {
    animation: cardSlideIn 0.6s ease-out forwards;
    opacity: 0;
    transform: translateY(20px);
}

.grid > div:nth-child(1) { animation-delay: 0.1s; }
.grid > div:nth-child(2) { animation-delay: 0.2s; }
.grid > div:nth-child(3) { animation-delay: 0.3s; }
.grid > div:nth-child(4) { animation-delay: 0.4s; }
.grid > div:nth-child(5) { animation-delay: 0.5s; }
.grid > div:nth-child(6) { animation-delay: 0.6s; }
.grid > div:nth-child(7) { animation-delay: 0.7s; }
.grid > div:nth-child(8) { animation-delay: 0.8s; }
.grid > div:nth-child(9) { animation-delay: 0.9s; }

@keyframes cardSlideIn {
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.hide-scroll {
    scrollbar-width: none;
    -ms-overflow-style: none;
}

.hide-scroll::-webkit-scrollbar {
    display: none;
}
</style>
@endsection