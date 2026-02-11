@extends('dashboard_base')

@section('main')
<main class="flex-1 overflow-hidden relative bg-slate-900">
    <div class="absolute inset-0 overflow-y-auto hide-scroll p-2">
        <div class="min-h-screen flex items-center justify-center px-4">
            <div class="max-w-6xl w-full space-y-8 animate-fade-in">
                <!-- En-tête avec animation -->
                <div class="flex items-center justify-between" data-aos="fade-right">
                    <div class="flex items-center space-x-4">
                        <div class="p-3 bg-indigo-500/20 rounded-full">
                            <div class="text-indigo-400 text-3xl">
                                <i class="fas fa-robot"></i>
                            </div>
                        </div>
                        <div>
                            <h1 class="text-3xl font-bold text-white">ManagerAI</h1>
                            <p class="text-slate-400">Optimisations basées sur vos données</p>
                        </div>
                    </div>
                    <!-- Bouton pour commencer un chat -->
                    <button id="commencerChatBtn" class="flex items-center space-x-2 bg-gradient-to-r from-yellow-600 to-orange-500 hover:from-orange-700 hover:to-orange-600 text-white px-5 py-3 rounded-lg transition-all duration-300 shadow-lg hover:shadow-xl">
                        <i class="fas fa-comments"></i>
                        <span>Commencer un chat</span>
                        <i class="fas fa-chevron-right ml-1 text-sm"></i>
                    </button>
                </div>

                <!-- Section conseils (par défaut) -->
                <div id="conseilsSection" class="bg-slate-800 backdrop-blur-sm rounded-xl border border-slate-700/50 overflow-hidden" data-aos="fade-up">
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

                    <!-- Contenu des conseils en grille -->
                    <div class="p-6">
                        @if($conseils && $conseils != 'Aucun conseil exploitable n\'a été trouvé.' && $conseils != 'Aucun conseil généré. Veuillez vérifier votre connexion ou votre clé API.' && $conseils != 'Aucun conseil généré. OpenRouter est temporairement indisponible.')
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                @php
                                    // Convertir les conseils en tableau
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

                <!-- Section chat (cachée par défaut) -->
                <div id="chatSection" class="hidden bg-slate-800 backdrop-blur-sm rounded-xl border border-slate-700/50 overflow-hidden" data-aos="fade-up">
                    <!-- En-tête du chat -->
                    <div class="bg-gradient-to-r from-yellow-600/10 to-orange-500/10 p-4 border-b border-slate-700/50 flex justify-between items-center">
                        <div>
                            <h2 class="font-semibold text-white flex items-center">
                                <i class="fas fa-comments mr-2"></i> Discussion avec ManagerAI
                            </h2>
                            <p class="text-slate-400 text-sm">Posez vos questions sur votre entreprise</p>
                        </div>
                        <div class="flex items-center space-x-2">
                            <button id="effacerHistoriqueBtn" class="flex items-center space-x-1 bg-red-600/20 hover:bg-red-600/30 text-red-300 px-3 py-2 rounded-lg transition-colors text-sm">
                                <i class="fas fa-trash-alt"></i>
                                <span class="hidden sm:inline">Effacer l'historique</span>
                            </button>
                            <button id="retourConseilsBtn" class="flex items-center space-x-2 bg-slate-700 hover:bg-slate-600 text-slate-300 px-4 py-2 rounded-lg transition-colors">
                                <i class="fas fa-arrow-left"></i>
                                <span class="hidden sm:inline">Retour aux conseils</span>
                            </button>
                        </div>
                    </div>

                    <!-- Zone de chat -->
                    <div class="flex flex-col h-[500px] sm:h-[600px]">
                        <!-- Zone des messages avec scroll -->
                        <div id="chatMessagesContainer" class="flex-1 overflow-y-auto p-4 space-y-4 chat-scroll-area">
                            <!-- Message de bienvenue -->
                            <div id="welcomeMessage" class="bg-slate-700/50 rounded-xl p-5 max-w-[90%] sm:max-w-[80%]">
                                <div class="flex items-start space-x-3">
                                    <div class="flex-shrink-0 w-10 h-10 bg-gradient-to-r from-yellow-500 to-orange-500 rounded-full flex items-center justify-center shadow-lg">
                                        <i class="fas fa-robot text-white text-sm"></i>
                                    </div>
                                    <div class="flex-1">
                                        <p class="text-white font-semibold text-lg mb-2">ManagerAI</p>
                                        <p class="text-slate-200 mb-3">Bonjour ! Je suis ManagerAI, votre assistant en gestion d'entreprise. Je peux vous aider avec :</p>
                                        <ul class="text-slate-300 text-sm space-y-2 mb-3">
                                            <li class="flex items-center">
                                                <i class="fas fa-chart-line text-green-400 mr-2 w-5"></i>
                                                <span>Analyse de vos transactions financières</span>
                                            </li>
                                            <li class="flex items-center">
                                                <i class="fas fa-users text-blue-400 mr-2 w-5"></i>
                                                <span>Gestion des employés et optimisation des effectifs</span>
                                            </li>
                                            <li class="flex items-center">
                                                <i class="fas fa-calendar-check text-yellow-400 mr-2 w-5"></i>
                                                <span>Suivi des congés et planification des absences</span>
                                            </li>
                                            <li class="flex items-center">
                                                <i class="fas fa-coins text-purple-400 mr-2 w-5"></i>
                                                <span>Conseils financiers et optimisation des coûts</span>
                                            </li>
                                            <li class="flex items-center">
                                                <i class="fas fa-rocket text-indigo-400 mr-2 w-5"></i>
                                                <span>Stratégies de croissance et développement</span>
                                            </li>
                                        </ul>
                                        <p class="text-orange-300 font-medium text-sm">
                                            Posez-moi n'importe quelle question sur votre entreprise, je répondrai en fonction de vos données !
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Indicateur de frappe -->
                        <div id="typingIndicator" class="hidden p-4 border-t border-slate-700 bg-slate-800/50">
                            <div class="flex items-center space-x-3">
                                <div class="flex-shrink-0 w-10 h-10 bg-gradient-to-r from-yellow-500 to-orange-500 rounded-full flex items-center justify-center shadow-lg">
                                    <i class="fas fa-robot text-white text-sm"></i>
                                </div>
                                <div class="typing-indicator">
                                    <span></span>
                                    <span></span>
                                    <span></span>
                                </div>
                                <span class="text-slate-400 text-sm">ManagerAI réfléchit...</span>
                            </div>
                        </div>

                        <!-- Zone de saisie -->
                        <div class="p-4 border-t border-slate-700 bg-slate-800/50">
                            <form id="chatForm" class="flex space-x-3">
                                @csrf
                                <div class="flex-1 relative">
                                    <textarea 
                                        id="messageInput" 
                                        placeholder="Posez votre question sur votre entreprise (ex: Comment réduire mes dépenses ?)" 
                                        class="w-full bg-slate-700 border border-slate-600 rounded-lg py-3 px-4 text-white focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent pr-10 resize-none chat-textarea overflow-y-scroll no-scrollbar"
                                        autocomplete="off"
                                        rows="1"
                                    ></textarea>
                                    <div class="absolute right-3 top-3 text-slate-400">
                                        <i class="fas fa-paper-plane"></i>
                                    </div>
                                </div>
                                <button 
                                    type="submit" 
                                    id="sendBtn" 
                                    class="bg-gradient-to-r from-yellow-600 to-orange-500 hover:from-yellow-700 hover:to-orangeyellow-600 text-white px-4 sm:px-6 py-3 rounded-lg transition-colors flex items-center justify-center min-w-[50px] sm:min-w-[120px] disabled:opacity-50 disabled:cursor-not-allowed"
                                >
                                    <i class="fas fa-paper-plane"></i>
                                    <span class="hidden sm:inline ml-2">Envoyer</span>
                                </button>
                            </form>
                            <div class="flex justify-between items-center mt-3">
                                <p class="text-slate-400 text-xs">
                                    <i class="fas fa-info-circle mr-3"></i>
                                    L'historique est sauvegardé localement
                                </p>
                                <div class="flex items-center space-x-2">
                                    <!-- <span class="text-xs text-slate-500">Powered by</span> -->
                                    <!-- <span class="text-xs bg-gradient-to-r from-green-500 to-emerald-500 text-white px-2 py-1 rounded">OpenRouter AI</span> -->
                                </div>
                            </div>
                        </div>
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
                                <span class="font-semibold text-indigo-300">À propos de ManagerAI :</span> 
                                L'IA analyse vos transactions récentes, vos données d'employés et vos congés pour vous fournir des recommandations personnalisées.
                                Cliquez sur "Commencer un chat" pour une assistance interactive et détaillée.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Effets décoratifs -->
    <div class="absolute -bottom-32 -left-32 w-64 h-64 bg-indigo-500 rounded-full mix-blend-multiply filter blur-3xl opacity-5"></div>
    <div class="absolute -top-32 -right-32 w-64 h-64 bg-purple-500 rounded-full mix-blend-multiply filter blur-3xl opacity-5"></div>
    <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-96 h-96 bg-green-500 rounded-full mix-blend-multiply filter blur-3xl opacity-3"></div>
</main>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Variables globales
    const conseilsSection = document.getElementById('conseilsSection');
    const chatSection = document.getElementById('chatSection');
    const commencerChatBtn = document.getElementById('commencerChatBtn');
    const retourConseilsBtn = document.getElementById('retourConseilsBtn');
    const effacerHistoriqueBtn = document.getElementById('effacerHistoriqueBtn');
    const chatForm = document.getElementById('chatForm');
    const messageInput = document.getElementById('messageInput');
    const chatMessagesContainer = document.getElementById('chatMessagesContainer');
    const sendBtn = document.getElementById('sendBtn');
    const welcomeMessage = document.getElementById('welcomeMessage');
    const typingIndicator = document.getElementById('typingIndicator');
    const genererBtn = document.getElementById('genererConseilsBtn');
    
    // Clé pour le localStorage
    const CHAT_HISTORY_KEY = 'managerai_chat_history_{{ Auth::id() }}';
    
    // Charger l'historique depuis localStorage
    let chatHistory = JSON.parse(localStorage.getItem(CHAT_HISTORY_KEY)) || [];
    
    // Adapter la hauteur du textarea
    function adjustTextareaHeight() {
        messageInput.style.height = 'auto';
        messageInput.style.height = Math.min(messageInput.scrollHeight, 100) + 'px';
    }
    
    // Commencer le chat (remplace les conseils)
    commencerChatBtn.addEventListener('click', function() {
        // Animation de transition
        conseilsSection.style.opacity = '0';
        conseilsSection.style.transform = 'translateY(-10px)';
        
        setTimeout(() => {
            // Cacher les conseils, montrer le chat
            conseilsSection.classList.add('hidden');
            chatSection.classList.remove('hidden');
            
            // Restaurer le bouton
            commencerChatBtn.innerHTML = '<i class="fas fa-comments"></i><span>Chat actif</span><i class="fas fa-check ml-1 text-sm"></i>';
            commencerChatBtn.classList.remove('from-green-600', 'to-emerald-500', 'hover:from-green-700', 'hover:to-emerald-600');
            commencerChatBtn.classList.add('from-blue-600', 'to-cyan-500', 'hover:from-blue-700', 'hover:to-cyan-600');
            
            // Animation d'entrée
            chatSection.style.opacity = '0';
            chatSection.style.transform = 'translateY(10px)';
            
            setTimeout(() => {
                chatSection.style.opacity = '1';
                chatSection.style.transform = 'translateY(0)';
                chatSection.style.transition = 'opacity 0.3s ease, transform 0.3s ease';
            }, 10);
            
            // Charger l'historique
            loadChatHistory();
            
            // Focus sur l'input
            setTimeout(() => {
                messageInput.focus();
            }, 300);
        }, 300);
    });
    
    // Retour aux conseils
    retourConseilsBtn.addEventListener('click', function() {
        // Animation de transition
        chatSection.style.opacity = '0';
        chatSection.style.transform = 'translateY(-10px)';
        
        setTimeout(() => {
            // Cacher le chat, montrer les conseils
            chatSection.classList.add('hidden');
            conseilsSection.classList.remove('hidden');
            
            // Restaurer le bouton de chat
            commencerChatBtn.innerHTML = '<i class="fas fa-comments"></i><span>Commencer un chat</span><i class="fas fa-chevron-right ml-1 text-sm"></i>';
            commencerChatBtn.classList.remove('from-blue-600', 'to-cyan-500', 'hover:from-blue-700', 'hover:to-cyan-600');
            commencerChatBtn.classList.add('from-green-600', 'to-emerald-500', 'hover:from-green-700', 'hover:to-emerald-600');
            
            // Animation d'entrée
            conseilsSection.style.opacity = '0';
            conseilsSection.style.transform = 'translateY(10px)';
            
            setTimeout(() => {
                conseilsSection.style.opacity = '1';
                conseilsSection.style.transform = 'translateY(0)';
            }, 10);
        }, 300);
    });
    
    // Effacer l'historique
    effacerHistoriqueBtn.addEventListener('click', function() {
        if (confirm('Voulez-vous vraiment effacer tout l\'historique de conversation ? Cette action est irréversible.')) {
            // Effacer l'historique du localStorage
            localStorage.removeItem(CHAT_HISTORY_KEY);
            chatHistory = [];
            
            // Réinitialiser le chat
            resetChat();
            
            // Notification
            showNotification('Historique effacé avec succès', 'success');
        }
    });
    
    // Soumission du formulaire
    chatForm.addEventListener('submit', async function(e) {
        e.preventDefault();
        
        const message = messageInput.value.trim();
        if (!message) return;
        
        // Ajouter le message utilisateur
        addMessageToChat('user', message);
        
        // Sauvegarder dans l'historique
        chatHistory.push({
            role: 'user',
            content: message,
            timestamp: new Date().toISOString()
        });
        
        // Effacer et réinitialiser l'input
        messageInput.value = '';
        adjustTextareaHeight();
        
        // Désactiver le bouton et afficher l'indicateur de chargement
        sendBtn.disabled = true;
        sendBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i>' + (window.innerWidth >= 640 ? '<span class="ml-2">Envoi...</span>' : '');
        
        // Afficher l'indicateur de frappe
        typingIndicator.classList.remove('hidden');
        scrollToBottom();
        
        try {
            // Envoyer à l'API
            const response = await fetch('{{ route("chat.ai") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ message: message })
            });
            
            const data = await response.json();
            
            // Cacher l'indicateur de frappe
            typingIndicator.classList.add('hidden');
            
            if (data.status === 'success') {
                // Ajouter la réponse de l'IA
                addMessageToChat('assistant', data.response);
                
                // Sauvegarder la réponse dans l'historique
                chatHistory.push({
                    role: 'assistant',
                    content: data.response,
                    timestamp: new Date().toISOString()
                });
                
                // Sauvegarder dans localStorage
                localStorage.setItem(CHAT_HISTORY_KEY, JSON.stringify(chatHistory));
            } else {
                throw new Error(data.message || 'Erreur inconnue');
            }
            
        } catch (error) {
            console.error('Erreur:', error);
            typingIndicator.classList.add('hidden');
            addMessageToChat('assistant', 'Désolé, une erreur est survenue. Veuillez réessayer plus tard.');
        } finally {
            // Réactiver le bouton
            sendBtn.disabled = false;
            sendBtn.innerHTML = '<i class="fas fa-paper-plane"></i>' + (window.innerWidth >= 640 ? '<span class="ml-2">Envoyer</span>' : '');
        }
    });
    
    // Ajouter un message au chat
    function addMessageToChat(role, content) {
        const messageDiv = document.createElement('div');
        const isUser = role === 'user';
        const icon = isUser ? 'fa-user' : 'fa-robot';
        const bgColor = isUser ? 'bg-gradient-to-r from-purple-500 to-pink-500' : 'bg-gradient-to-r from-green-500 to-emerald-500';
        const name = isUser ? 'Vous' : 'ManagerAI';
        const alignment = isUser ? 'ml-auto' : '';
        const textAlign = isUser ? 'text-right' : '';
        
        messageDiv.className = `bg-slate-700/50 rounded-xl p-4 sm:p-5 max-w-[90%] sm:max-w-[80%] ${alignment} animate-message-in`;
        
        // Formater le contenu (éviter les phrases barrées)
        const formattedContent = formatMessageContent(content);
        
        messageDiv.innerHTML = `
            <div class="flex items-start space-x-3 ${isUser ? 'flex-row-reverse space-x-reverse' : ''}">
                <div class="flex-shrink-0 w-8 h-8 sm:w-10 sm:h-10 ${bgColor} rounded-full flex items-center justify-center shadow-lg">
                    <i class="fas ${icon} text-white text-xs sm:text-sm"></i>
                </div>
                <div class="flex-1 ${textAlign}">
                    <p class="text-white font-semibold text-sm mb-1 sm:mb-2">${name}</p>
                    <div class="text-slate-200 text-sm leading-relaxed prose prose-invert max-w-none chat-message-content">
                        ${formattedContent}
                    </div>
                    <p class="text-slate-400 text-xs mt-2 sm:mt-3">${new Date().toLocaleTimeString('fr-FR', {hour: '2-digit', minute:'2-digit'})}</p>
                </div>
            </div>
        `;
        
        // Cacher le message de bienvenue si c'est la première interaction
        if (welcomeMessage && chatHistory.length > 0) {
            welcomeMessage.style.display = 'none';
        }
        
        chatMessagesContainer.appendChild(messageDiv);
        scrollToBottom();
    }
    
    // Formater le contenu du message (sans phrases barrées)
    function formatMessageContent(content) {
        // Remplacer les retours à la ligne par des balises <br>
        let formatted = content.replace(/\n/g, '<br>');
        
        // Éviter les phrases barrées (~~texte~~) en les supprimant
        formatted = formatted.replace(/~~(.*?)~~/g, '$1');
        
        // Ajouter des styles pour gras et italique
        formatted = formatted.replace(/\*\*(.*?)\*\*/g, '<strong class="text-white font-semibold">$1</strong>');
        formatted = formatted.replace(/\*(.*?)\*/g, '<em class="text-slate-300 italic">$1</em>');
        
        // Formater les listes numérotées
        formatted = formatted.replace(/^(\d+)\.\s+(.*)$/gm, '<div class="flex items-start my-1"><span class="text-green-400 font-semibold mr-2 flex-shrink-0">$1.</span><span>$2</span></div>');
        
        // Formater les listes à puces
        formatted = formatted.replace(/^-\s+(.*)$/gm, '<div class="flex items-start my-1"><span class="text-blue-400 mr-2 flex-shrink-0">•</span><span>$1</span></div>');
        
        // Formater les titres (sans phrases barrées)
        formatted = formatted.replace(/^([^:]+:)\s*$/gm, '<div class="text-green-300 font-semibold mt-3 mb-2 text-sm sm:text-base">$1</div>');
        
        return formatted;
    }
    
    // Charger l'historique
    function loadChatHistory() {
        // Effacer les messages existants (sauf le message de bienvenue)
        while (chatMessagesContainer.firstChild) {
            chatMessagesContainer.removeChild(chatMessagesContainer.firstChild);
        }
        
        // Réafficher le message de bienvenue
        if (welcomeMessage) {
            welcomeMessage.style.display = 'block';
            chatMessagesContainer.appendChild(welcomeMessage);
        }
        
        // Afficher l'historique
        chatHistory.forEach(item => {
            addMessageToChat(item.role, item.content);
        });
        
        scrollToBottom();
    }
    
    // Réinitialiser le chat
    function resetChat() {
        // Effacer les messages
        while (chatMessagesContainer.firstChild) {
            chatMessagesContainer.removeChild(chatMessagesContainer.firstChild);
        }
        
        // Réafficher le message de bienvenue
        if (welcomeMessage) {
            welcomeMessage.style.display = 'block';
            chatMessagesContainer.appendChild(welcomeMessage);
        }
        
        // Réinitialiser l'input
        messageInput.value = '';
        adjustTextareaHeight();
        
        scrollToBottom();
    }
    
    // Défiler vers le bas
    function scrollToBottom() {
        setTimeout(() => {
            chatMessagesContainer.scrollTop = chatMessagesContainer.scrollHeight;
        }, 100);
    }
    
    // Gestion des touches dans le textarea
    messageInput.addEventListener('keydown', function(e) {
        if (e.key === 'Enter' && !e.shiftKey) {
            e.preventDefault();
            chatForm.dispatchEvent(new Event('submit'));
        }
    });
    
    // Auto-ajustement de la hauteur du textarea
    messageInput.addEventListener('input', adjustTextareaHeight);
    
    // Gestion du bouton de génération de conseils
    if(genererBtn) {
        genererBtn.addEventListener('click', function() {
            // Ajout d'un indicateur de chargement
            genererBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Génération en cours...';
            genererBtn.disabled = true;
            
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
                genererBtn.innerHTML = '<i class="fas fa-exclamation-triangle mr-2"></i> Erreur';
                setTimeout(() => {
                    genererBtn.innerHTML = '<i class="fas fa-sync-alt mr-2"></i> Réessayer';
                    genererBtn.disabled = false;
                }, 1500);
            });
        });
    }
    
    // Fonction de notification
    function showNotification(message, type = 'info') {
        // Supprimer les notifications existantes
        const existingNotifications = document.querySelectorAll('.notification-toast');
        existingNotifications.forEach(n => n.remove());
        
        const notification = document.createElement('div');
        const bgColor = type === 'success' ? 'bg-green-600' : 
                       type === 'error' ? 'bg-red-600' : 
                       'bg-blue-600';
        
        notification.className = `notification-toast fixed top-4 right-4 ${bgColor} text-white px-4 py-3 rounded-lg shadow-xl z-50 transform translate-x-full animate-notification-in`;
        notification.innerHTML = `
            <div class="flex items-center">
                <i class="fas ${type === 'success' ? 'fa-check-circle' : type === 'error' ? 'fa-exclamation-circle' : 'fa-info-circle'} mr-2"></i>
                <span class="text-sm">${message}</span>
            </div>
        `;
        
        document.body.appendChild(notification);
        
        setTimeout(() => {
            notification.classList.add('animate-notification-out');
            setTimeout(() => {
                notification.remove();
            }, 300);
        }, 3000);
    }
    
    // Gérer le scroll sur mobile (éviter le défilement de la page)
    chatMessagesContainer.addEventListener('touchstart', function(e) {
        this.style.overflow = 'auto';
    });
    
    chatMessagesContainer.addEventListener('touchmove', function(e) {
        e.stopPropagation();
    });
    
    chatMessagesContainer.addEventListener('touchend', function(e) {
        this.style.overflow = 'auto';
    });
    
    // Initialiser le chat si l'historique existe
    if (chatHistory.length > 0) {
        loadChatHistory();
    }
    
    // Initialiser la hauteur du textarea
    adjustTextareaHeight();
});

function showLoadingAndRedirect(event, url) {
    event.preventDefault();
    // Vous pouvez ajouter un indicateur de chargement ici si nécessaire
    setTimeout(() => {
        window.location.href = url;
    }, 100);
}
</script>

<style>

    .no-scrollbar::-webkit-scrollbar {
        display: none;
    }

    .no-scrollbar {
        -ms-overflow-style: none;
        scrollbar-width: none;
    }

    /* Animations de base */
    .animate-fade-in {
        animation: fadeIn 0.5s ease-out;
    }
    
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    /* Animation pour l'apparition des cartes conseils */
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
    .grid > div:nth-child(10) { animation-delay: 1.0s; }
    
    @keyframes cardSlideIn {
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    /* Animation pour les messages */
    @keyframes message-in {
        from {
            opacity: 0;
            transform: translateY(10px) scale(0.95);
        }
        to {
            opacity: 1;
            transform: translateY(0) scale(1);
        }
    }
    
    .animate-message-in {
        animation: message-in 0.3s ease-out;
    }
    
    /* Animation de frappe */
    .typing-indicator {
        display: flex;
        align-items: center;
        gap: 6px;
        padding: 8px 16px;
    }
    
    .typing-indicator span {
        width: 8px;
        height: 8px;
        background: linear-gradient(to right, #10b981, #34d399);
        border-radius: 50%;
        animation: typing 1.4s infinite;
    }
    
    .typing-indicator span:nth-child(2) {
        animation-delay: 0.2s;
    }
    
    .typing-indicator span:nth-child(3) {
        animation-delay: 0.4s;
    }
    
    @keyframes typing {
        0%, 60%, 100% {
            transform: translateY(0);
            opacity: 0.6;
        }
        30% {
            transform: translateY(-6px);
            opacity: 1;
        }
    }
    
    /* Animation de notification */
    @keyframes notification-in {
        from {
            transform: translateX(100%);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }
    
    @keyframes notification-out {
        from {
            transform: translateX(0);
            opacity: 1;
        }
        to {
            transform: translateX(100%);
            opacity: 0;
        }
    }
    
    .animate-notification-in {
        animation: notification-in 0.3s ease-out forwards;
    }
    
    .animate-notification-out {
        animation: notification-out 0.3s ease-out forwards;
    }
    
    /* Styles pour le scrollbar de la zone de chat */
    .chat-scroll-area {
        scrollbar-width: thin;
        scrollbar-color: rgba(16, 185, 129, 0.5) rgba(30, 41, 59, 0.3);
        -webkit-overflow-scrolling: touch; /* Pour le scroll fluide sur iOS */
        overscroll-behavior: contain; /* Empêche le scroll sur le parent */
    }
    
    .chat-scroll-area::-webkit-scrollbar {
        width: 6px;
    }
    
    .chat-scroll-area::-webkit-scrollbar-track {
        background: rgba(30, 41, 59, 0.3);
        border-radius: 3px;
    }
    
    .chat-scroll-area::-webkit-scrollbar-thumb {
        background: linear-gradient(to bottom, rgba(16, 185, 129, 0.7), rgba(52, 211, 153, 0.7));
        border-radius: 3px;
    }
    
    .chat-scroll-area::-webkit-scrollbar-thumb:hover {
        background: linear-gradient(to bottom, rgba(16, 185, 129, 0.9), rgba(52, 211, 153, 0.9));
    }
    
    /* Styles pour le textarea du chat */
    .chat-textarea {
        min-height: 44px; /* Taille minimale pour le touch */
        max-height: 100px; /* Hauteur maximale */
        line-height: 1.5;
        transition: height 0.2s ease;
    }
    
    .chat-textarea:focus {
        box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.2);
    }
    
    /* Styles pour le contenu des messages */
    .chat-message-content {
        word-break: break-word;
        overflow-wrap: break-word;
    }
    
    .chat-message-content br {
        content: '';
        display: block;
        margin-bottom: 0.5em;
    }
    
    /* Styles responsive */
    @media (max-width: 640px) {
        #chatSection {
            margin-left: -0.5rem;
            margin-right: -0.5rem;
            border-radius: 0.75rem 0.75rem 0 0;
        }
        
        #chatSection .flex-col {
            height: calc(100vh - 200px);
            max-height: 500px;
        }
        
        .chat-scroll-area {
            max-height: 300px;
        }
        
        #commencerChatBtn span:not(:first-child) {
            display: none;
        }
        
        #commencerChatBtn {
            padding-left: 1rem;
            padding-right: 1rem;
        }
        
        /* Amélioration du scroll sur mobile */
        .chat-scroll-area {
            touch-action: pan-y;
        }
    }
    
    @media (max-width: 768px) {
        .header-content {
            flex-direction: column;
            align-items: flex-start;
            gap: 1rem;
        }
        
        #commencerChatBtn {
            align-self: flex-end;
            margin-top: -3rem;
        }
    }
    
    /* Hide scroll class */
    .hide-scroll {
        scrollbar-width: none;
        -ms-overflow-style: none;
    }
    
    .hide-scroll::-webkit-scrollbar {
        display: none;
    }
    
    /* Transition pour le changement de section */
    #conseilsSection, #chatSection {
        transition: opacity 0.3s ease, transform 0.3s ease;
    }
    
    /* Améliorations pour le contenu des messages */
    .prose-invert {
        color: #e2e8f0;
    }
    
    .prose-invert strong {
        color: #ffffff;
        font-weight: 600;
    }
    
    .prose-invert em {
        color: #cbd5e1;
        font-style: italic;
    }
</style>
@endsection