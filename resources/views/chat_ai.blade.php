@extends('dashboard_base')

@section('main')
<main class="flex-1 overflow-hidden relative bg-slate-900">
    <div class="absolute inset-0 overflow-y-auto hide-scroll p-2">
        <div class="min-h-screen px-4">
            <div class="max-w-5xl mx-auto space-y-6 animate-fade-in">
                <!-- Zone de chat -->
                <div class="bg-slate-800/50 backdrop-blur-sm rounded-xl overflow-hidden relative border border-slate-700">
                    <!-- Bouton effacer en position absolute -->
                    <div class="flex justify-center gap-2 absolute top-4 right-4 z-10">
                        @php
                            $url = route('analyse_conseils');
                        @endphp
                        <a href="{{ $url }}" 
                            onclick="showLoadingAndRedirect(event, '{{ $url }}')"
                        class="flex items-center space-x-2 bg-slate-700 hover:bg-slate-600 text-white px-3 sm:px-5 py-2 sm:py-3 rounded-lg transition-all duration-300 text-sm sm:text-base">
                            <i class="fas fa-lightbulb text-sm sm:text-base"></i>
                            <span class="hidden xs:inline">Conseils financiers</span>
                            <span class="xs:hidden">Conseils</span>
                        </a>
                        <button id="effacerHistoriqueBtn" class="flex items-center space-x-1 bg-red-600/80 hover:bg-red-600 text-white px-2 sm:px-3 py-2 rounded-lg transition-colors text-xs sm:text-sm shadow-lg backdrop-blur-sm">
                            <i class="fas fa-trash-alt text-xs sm:text-sm"></i>
                            <span class="hidden sm:inline">Effacer l'historique</span>
                        </button>
                    </div>

                    <div class="p-3 sm:p-4">
                        <div>
                            <h2 class="font-semibold text-white flex items-center text-sm sm:text-base">
                                <i class="fas fa-comments mr-2"></i> Discussion avec ManagerAI
                            </h2>
                            <p class="text-slate-400 text-xs sm:text-sm">Posez vos questions sur votre entreprise</p>
                        </div>
                    </div>

                    <!-- Zone de chat agrandie -->
                    <div class="flex flex-col h-[450px] sm:h-[550px] md:h-[600px] mobile-full-height">
                        <!-- Zone des messages -->
                        <div id="chatMessagesContainer" class="flex-1 overflow-y-auto p-3 sm:p-4 space-y-3 sm:space-y-4 chat-scroll-area">
                            <div id="welcomeMessage" class="bg-slate-700/50 rounded-xl p-4 sm:p-5 max-w-[95%] sm:max-w-[90%] md:max-w-[80%]">
                                <div class="flex items-start space-x-2 sm:space-x-3">
                                    <div class="flex-shrink-0 w-8 h-8 sm:w-10 sm:h-10 bg-slate-600 rounded-full flex items-center justify-center shadow-lg">
                                        <i class="fas fa-robot text-white text-xs sm:text-sm"></i>
                                    </div>
                                    <div class="flex-1">
                                        <div class="flex items-center gap-2">
                                            <p class="text-white font-semibold text-base sm:text-lg mb-1 sm:mb-2">ManagerAI</p>
                                        </div>
                                        <p class="text-slate-200 text-sm sm:text-base mb-2 sm:mb-3">Bonjour ! Je suis ManagerAI, votre assistant en gestion d'entreprise.</p>
                                        <p class="text-slate-300 font-medium text-xs sm:text-sm">Posez-moi n'importe quelle question sur votre entreprise !</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Indicateur de frappe -->
                        <div id="typingIndicator" class="hidden p-3 sm:p-4 bg-slate-800">
                            <div class="flex items-center space-x-2 sm:space-x-3">
                                <div class="flex-shrink-0 w-8 h-8 sm:w-10 sm:h-10 bg-slate-600 rounded-full flex items-center justify-center shadow-lg">
                                    <i class="fas fa-robot text-white text-xs sm:text-sm"></i>
                                </div>
                                <div class="typing-indicator">
                                    <span></span>
                                    <span></span>
                                    <span></span>
                                </div>
                                <span class="text-slate-400 text-xs sm:text-sm">ManagerAI réfléchit...</span>
                            </div>
                        </div>

                        <!-- Zone de saisie -->
                        <div class="p-3 sm:p-4 bg-slate-850">
                            <form id="chatForm" class="flex space-x-2 sm:space-x-3">
                                @csrf
                                <div class="flex-1 relative">
                                    <textarea 
                                        id="messageInput" 
                                        placeholder="Ecrivez votre question ou utilisez le mode Live..." 
                                        class="w-full bg-slate-700 border border-slate-600 rounded-lg py-2 sm:py-3 px-3 sm:px-4 text-white text-sm sm:text-base focus:outline-none focus:ring-2 focus:ring-slate-500 focus:border-transparent resize-none chat-textarea no-scrollbar"
                                        rows="1"
                                    ></textarea>
                                </div>
                                
                                <!-- Bouton Microphone -->
                                <button 
                                    type="button"
                                    id="voiceRecordBtn" 
                                    class="bg-slate-700 hover:bg-slate-600 text-white px-3 sm:px-4 py-2 sm:py-3 rounded-lg transition-all duration-300 flex items-center justify-center min-w-[40px] sm:min-w-[50px] relative"
                                    title="Enregistrer vocalement">
                                    <i class="fas fa-microphone text-sm sm:text-lg"></i>
                                </button>
                                
                                <!-- Bouton Live Mode -->
                                <button 
                                    type="button"
                                    id="liveModeBtn" 
                                    class="bg-slate-700 hover:bg-slate-600 text-white px-3 sm:px-4 py-2 sm:py-3 rounded-lg transition-all duration-300 flex items-center justify-center min-w-[40px] sm:min-w-[50px] relative"
                                    title="Mode Live - Discuter en temps reel">
                                    <span class="hidden sm:inline text-sm mr-2">Live Mode</span> 
                                    <i class="fas fa-circle text-slate-400 text-xs sm:text-sm"></i>
                                </button>
                                
                                <button type="submit" id="sendBtn" class="bg-slate-600 hover:bg-slate-500 text-white px-3 sm:px-6 py-2 sm:py-3 rounded-lg transition-colors flex items-center justify-center min-w-[40px] sm:min-w-[100px] disabled:opacity-50 disabled:cursor-not-allowed text-sm sm:text-base">
                                    <i class="fas fa-paper-plane text-sm sm:text-base"></i>
                                    <span class="hidden sm:inline ml-2">Envoyer</span>
                                </button>
                            </form>
                            
                            <!-- Indicateur d'enregistrement vocal -->
                            <div id="recordingIndicator" class="hidden mt-3 flex flex-wrap items-center justify-center gap-2">
                                <div class="flex items-center space-x-1">
                                    <div class="w-1.5 h-1.5 sm:w-2 sm:h-2 bg-red-500 rounded-full animate-pulse"></div>
                                    <div class="w-1.5 h-1.5 sm:w-2 sm:h-2 bg-red-500 rounded-full animate-pulse animation-delay-200"></div>
                                    <div class="w-1.5 h-1.5 sm:w-2 sm:h-2 bg-red-500 rounded-full animate-pulse animation-delay-400"></div>
                                </div>
                                <span class="text-red-400 text-xs sm:text-sm">Enregistrement en cours... Parlez maintenant</span>
                                <button type="button" id="stopRecordingBtn" class="ml-0 sm:ml-2 bg-red-600 hover:bg-red-700 text-white px-2 sm:px-3 py-1 rounded-lg text-xs sm:text-sm">
                                    <i class="fas fa-stop"></i> Arreter
                                </button>
                            </div>
                            
                            <!-- Indicateur Live Mode -->
                            <div id="liveModeIndicator" class="hidden mt-3 flex flex-wrap items-center justify-center gap-2">
                                <div class="flex items-center space-x-1">
                                    <div class="w-1.5 h-1.5 sm:w-2 sm:h-2 bg-green-500 rounded-full animate-pulse"></div>
                                    <div class="w-1.5 h-1.5 sm:w-2 sm:h-2 bg-green-500 rounded-full animate-pulse animation-delay-200"></div>
                                    <div class="w-1.5 h-1.5 sm:w-2 sm:h-2 bg-green-500 rounded-full animate-pulse animation-delay-400"></div>
                                </div>
                                <span id="liveModeStatus" class="text-green-400 text-xs sm:text-sm font-semibold">Mode Live actif - Je vous écoute...</span>
                                <button type="button" id="stopLiveModeBtn" class="ml-0 sm:ml-2 bg-red-600 hover:bg-red-700 text-white px-2 sm:px-3 py-1 rounded-lg text-xs sm:text-sm">
                                    <i class="fas fa-stop"></i> Desactiver
                                </button>
                            </div>
                            
                            <p class="text-slate-500 text-[10px] sm:text-xs mt-3 text-center">
                                <i class="fas fa-info-circle mr-1"></i> 
                                <span class="hidden xs:inline">L'historique est sauvegarde localement | </span>
                                <i class="fas fa-microphone ml-0 sm:ml-2 mr-1"></i>Dictee vocale | 
                                <i class="fas fa-headset ml-0 sm:ml-2 mr-1"></i>Mode Live : Parlez, l'IA repond vocalement
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="absolute -bottom-32 -left-32 w-64 h-64 bg-slate-600 rounded-full mix-blend-multiply filter blur-3xl opacity-5"></div>
    <div class="absolute -top-32 -right-32 w-64 h-64 bg-slate-700 rounded-full mix-blend-multiply filter blur-3xl opacity-5"></div>
</main>

<!-- MODALE DE CONFIRMATION -->
<div id="confirmModal" class="fixed inset-0 bg-black/80 backdrop-blur-sm flex items-center justify-center z-50 hidden">
    <div class="bg-slate-800 rounded-xl w-full max-w-md mx-4 shadow-2xl border border-slate-700 transform transition-all duration-300 scale-95 opacity-0" id="confirmModalContent">
        <div class="px-4 sm:px-6 py-3 sm:py-4 border-b border-slate-700 flex justify-between items-center">
            <h2 class="text-base sm:text-lg font-semibold text-white flex items-center gap-2">
                <i class="fas fa-trash-alt text-red-400"></i>
                Confirmer la suppression
            </h2>
            <button onclick="closeConfirmModal()" class="text-slate-400 hover:text-slate-300 transition-colors">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="p-4 sm:p-6">
            <p class="text-slate-300 text-sm sm:text-base mb-2">Voulez-vous vraiment effacer tout l'historique de conversation ?</p>
            <p class="text-slate-400 text-xs sm:text-sm">Cette action est irreversible.</p>
        </div>
        <div class="flex justify-end gap-3 p-4 sm:p-6 pt-0">
            <button onclick="closeConfirmModal()" class="px-3 sm:px-4 py-2 bg-slate-700 hover:bg-slate-600 text-white rounded-lg transition-colors text-sm sm:text-base">
                Annuler
            </button>
            <button id="confirmEffacerBtn" class="px-3 sm:px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg transition-colors text-sm sm:text-base">
                <i class="fas fa-trash-alt mr-2"></i>Effacer
            </button>
        </div>
    </div>
</div>

<!-- MODALE LIVE MODE PLEIN ECRAN -->
<div id="liveModeFullscreen" class="fixed inset-0 z-[100] hidden">
    <!-- Fond avec animation theme slate -->
    <div class="absolute inset-0 bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900">
        <!-- Effet de fond avec bulles -->
        <div class="absolute inset-0 overflow-hidden">
            <div class="live-bubble" style="position: absolute; bottom: -100px; width: 60px; height: 60px; background: linear-gradient(135deg, #47556920, #64748b40); border-radius: 50%; animation: rise 8s infinite ease-in; pointer-events: none; left: 10%; width: 80px; height: 80px; animation-duration: 12s;"></div>
            <div class="live-bubble" style="position: absolute; bottom: -100px; width: 60px; height: 60px; background: linear-gradient(135deg, #47556920, #64748b40); border-radius: 50%; animation: rise 8s infinite ease-in; pointer-events: none; left: 25%; width: 40px; height: 40px; animation-duration: 8s; animation-delay: 1s;"></div>
            <div class="live-bubble" style="position: absolute; bottom: -100px; width: 60px; height: 60px; background: linear-gradient(135deg, #47556920, #64748b40); border-radius: 50%; animation: rise 8s infinite ease-in; pointer-events: none; left: 45%; width: 100px; height: 100px; animation-duration: 15s; animation-delay: 2s;"></div>
            <div class="live-bubble" style="position: absolute; bottom: -100px; width: 60px; height: 60px; background: linear-gradient(135deg, #47556920, #64748b40); border-radius: 50%; animation: rise 8s infinite ease-in; pointer-events: none; left: 65%; width: 50px; height: 50px; animation-duration: 10s; animation-delay: 0s;"></div>
            <div class="live-bubble" style="position: absolute; bottom: -100px; width: 60px; height: 60px; background: linear-gradient(135deg, #47556920, #64748b40); border-radius: 50%; animation: rise 8s infinite ease-in; pointer-events: none; left: 80%; width: 70px; height: 70px; animation-duration: 14s; animation-delay: 3s;"></div>
            <div class="live-bubble" style="position: absolute; bottom: -100px; width: 60px; height: 60px; background: linear-gradient(135deg, #47556920, #64748b40); border-radius: 50%; animation: rise 8s infinite ease-in; pointer-events: none; left: 35%; width: 30px; height: 30px; animation-duration: 6s; animation-delay: 4s;"></div>
            <div class="live-bubble" style="position: absolute; bottom: -100px; width: 60px; height: 60px; background: linear-gradient(135deg, #47556920, #64748b40); border-radius: 50%; animation: rise 8s infinite ease-in; pointer-events: none; left: 55%; width: 90px; height: 90px; animation-duration: 11s; animation-delay: 1s;"></div>
            <div class="live-bubble" style="position: absolute; bottom: -100px; width: 60px; height: 60px; background: linear-gradient(135deg, #47556920, #64748b40); border-radius: 50%; animation: rise 8s infinite ease-in; pointer-events: none; left: 90%; width: 45px; height: 45px; animation-duration: 9s; animation-delay: 2s;"></div>
        </div>

        <!-- Effet de particules -->
        <div class="absolute inset-0 overflow-hidden">
            <div class="particle" style="position: absolute; width: 4px; height: 4px; background: #64748b; border-radius: 50%; opacity: 0; animation: float 4s infinite ease-in; pointer-events: none; left: 20%; top: 30%; animation-delay: 0s;"></div>
            <div class="particle" style="position: absolute; width: 4px; height: 4px; background: #64748b; border-radius: 50%; opacity: 0; animation: float 4s infinite ease-in; pointer-events: none; left: 50%; top: 20%; animation-delay: 0.5s;"></div>
            <div class="particle" style="position: absolute; width: 4px; height: 4px; background: #64748b; border-radius: 50%; opacity: 0; animation: float 4s infinite ease-in; pointer-events: none; left: 80%; top: 40%; animation-delay: 1s;"></div>
            <div class="particle" style="position: absolute; width: 4px; height: 4px; background: #64748b; border-radius: 50%; opacity: 0; animation: float 4s infinite ease-in; pointer-events: none; left: 15%; top: 70%; animation-delay: 1.5s;"></div>
            <div class="particle" style="position: absolute; width: 4px; height: 4px; background: #64748b; border-radius: 50%; opacity: 0; animation: float 4s infinite ease-in; pointer-events: none; left: 45%; top: 80%; animation-delay: 2s;"></div>
            <div class="particle" style="position: absolute; width: 4px; height: 4px; background: #64748b; border-radius: 50%; opacity: 0; animation: float 4s infinite ease-in; pointer-events: none; left: 70%; top: 60%; animation-delay: 2.5s;"></div>
            <div class="particle" style="position: absolute; width: 4px; height: 4px; background: #64748b; border-radius: 50%; opacity: 0; animation: float 4s infinite ease-in; pointer-events: none; left: 35%; top: 50%; animation-delay: 3s;"></div>
            <div class="particle" style="position: absolute; width: 4px; height: 4px; background: #64748b; border-radius: 50%; opacity: 0; animation: float 4s infinite ease-in; pointer-events: none; left: 85%; top: 25%; animation-delay: 3.5s;"></div>
            <div class="particle" style="position: absolute; width: 4px; height: 4px; background: #64748b; border-radius: 50%; opacity: 0; animation: float 4s infinite ease-in; pointer-events: none; left: 60%; top: 15%; animation-delay: 1.2s;"></div>
            <div class="particle" style="position: absolute; width: 4px; height: 4px; background: #64748b; border-radius: 50%; opacity: 0; animation: float 4s infinite ease-in; pointer-events: none; left: 10%; top: 85%; animation-delay: 2.8s;"></div>
            <div class="particle" style="position: absolute; width: 4px; height: 4px; background: #64748b; border-radius: 50%; opacity: 0; animation: float 4s infinite ease-in; pointer-events: none; left: 75%; top: 75%; animation-delay: 0.8s;"></div>
            <div class="particle" style="position: absolute; width: 4px; height: 4px; background: #64748b; border-radius: 50%; opacity: 0; animation: float 4s infinite ease-in; pointer-events: none; left: 40%; top: 45%; animation-delay: 1.8s;"></div>
            <div class="particle" style="position: absolute; width: 4px; height: 4px; background: #64748b; border-radius: 50%; opacity: 0; animation: float 4s infinite ease-in; pointer-events: none; left: 55%; top: 90%; animation-delay: 3.2s;"></div>
            <div class="particle" style="position: absolute; width: 4px; height: 4px; background: #64748b; border-radius: 50%; opacity: 0; animation: float 4s infinite ease-in; pointer-events: none; left: 25%; top: 55%; animation-delay: 2.2s;"></div>
            <div class="particle" style="position: absolute; width: 4px; height: 4px; background: #64748b; border-radius: 50%; opacity: 0; animation: float 4s infinite ease-in; pointer-events: none; left: 90%; top: 50%; animation-delay: 1.5s;"></div>
        </div>
    </div>

    <!-- Bouton fermer (croix) -->
    <button id="closeLiveModeBtn" class="absolute bottom-4 right-4 text-slate-400 hover:text-slate-200 transition-all duration-300 z-20 hover:scale-110 hover:rotate-90 bg-slate-800/50 backdrop-blur-sm rounded-full p-2 border border-slate-700">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
        </svg>
    </button>

    <!-- Contenu principal -->
    <div class="relative z-10 flex flex-col items-center justify-center min-h-screen">
        <!-- Conteneur de la pyramide -->
        <div class="relative">
            <div class="absolute inset-0 bg-slate-500 rounded-full blur-2xl animate-pulse" id="pyramidGlow" style="opacity: 0.3;"></div>
            <div class="pyramid-container" style="perspective: 600px; width: 120px; height: 120px; margin: 0 auto;">
                <div class="pyramid" id="livePyramid" style="position: relative; width: 100%; height: 100%; transform-style: preserve-3d; transition: transform 0.05s ease-out;">
                    <!-- Face avant -->
                    <div class="face front" style="position: absolute; width: 0; height: 0; border-left: 60px solid transparent; border-right: 60px solid transparent; border-bottom: 104px solid rgba(100, 116, 139, 0.8); transform-origin: bottom; transform: rotateX(0deg) translateY(0); backdrop-filter: blur(5px);">
                        <div class="face-content" style="position: absolute; top: 30px; left: -15px; width: 30px; height: 30px;">
                            <svg class="w-6 h-6 text-white/80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z"></path>
                            </svg>
                        </div>
                    </div>
                    <!-- Face arriere -->
                    <div class="face back" style="position: absolute; width: 0; height: 0; border-left: 60px solid transparent; border-right: 60px solid transparent; border-bottom: 104px solid rgba(71, 85, 105, 0.8); transform-origin: bottom; transform: rotateY(180deg) rotateX(0deg);">
                        <div class="face-content" style="position: absolute; top: 30px; left: -15px; width: 30px; height: 30px;">
                            <svg class="w-6 h-6 text-white/80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                    </div>
                    <!-- Face droite -->
                    <div class="face right" style="position: absolute; width: 0; height: 0; border-left: 60px solid transparent; border-right: 60px solid transparent; border-bottom: 104px solid rgba(51, 65, 85, 0.8); transform-origin: bottom; transform: rotateY(90deg) rotateX(0deg);">
                        <div class="face-content" style="position: absolute; top: 30px; left: -15px; width: 30px; height: 30px;">
                            <svg class="w-6 h-6 text-white/80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                        </div>
                    </div>
                    <!-- Face gauche -->
                    <div class="face left" style="position: absolute; width: 0; height: 0; border-left: 60px solid transparent; border-right: 60px solid transparent; border-bottom: 104px solid rgba(30, 41, 59, 0.8); transform-origin: bottom; transform: rotateY(-90deg) rotateX(0deg);">
                        <div class="face-content" style="position: absolute; top: 30px; left: -15px; width: 30px; height: 30px;">
                            <svg class="w-6 h-6 text-white/80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Visualisation de l'intensite vocale -->
        <div class="mt-8">
            <div class="voice-visualizer-live" style="display: flex; gap: 6px; justify-content: center; align-items: center; height: 60px;">
                <div class="voice-bar-live" style="width: 4px; background: linear-gradient(to top, #64748b, #94a3b8); border-radius: 2px; transition: height 0.05s ease-out; min-height: 4px; height: 10px;"></div>
                <div class="voice-bar-live" style="width: 4px; background: linear-gradient(to top, #64748b, #94a3b8); border-radius: 2px; transition: height 0.05s ease-out; min-height: 4px; height: 15px;"></div>
                <div class="voice-bar-live" style="width: 4px; background: linear-gradient(to top, #64748b, #94a3b8); border-radius: 2px; transition: height 0.05s ease-out; min-height: 4px; height: 20px;"></div>
                <div class="voice-bar-live" style="width: 4px; background: linear-gradient(to top, #64748b, #94a3b8); border-radius: 2px; transition: height 0.05s ease-out; min-height: 4px; height: 25px;"></div>
                <div class="voice-bar-live" style="width: 4px; background: linear-gradient(to top, #64748b, #94a3b8); border-radius: 2px; transition: height 0.05s ease-out; min-height: 4px; height: 30px;"></div>
                <div class="voice-bar-live" style="width: 4px; background: linear-gradient(to top, #64748b, #94a3b8); border-radius: 2px; transition: height 0.05s ease-out; min-height: 4px; height: 25px;"></div>
                <div class="voice-bar-live" style="width: 4px; background: linear-gradient(to top, #64748b, #94a3b8); border-radius: 2px; transition: height 0.05s ease-out; min-height: 4px; height: 20px;"></div>
                <div class="voice-bar-live" style="width: 4px; background: linear-gradient(to top, #64748b, #94a3b8); border-radius: 2px; transition: height 0.05s ease-out; min-height: 4px; height: 15px;"></div>
                <div class="voice-bar-live" style="width: 4px; background: linear-gradient(to top, #64748b, #94a3b8); border-radius: 2px; transition: height 0.05s ease-out; min-height: 4px; height: 10px;"></div>
            </div>
        </div>

        <!-- Indicateur de statut dynamique -->
        <div class="mt-6">
            <div class="inline-flex items-center gap-3 px-6 py-3 bg-slate-800/80 backdrop-blur-sm rounded-full shadow-lg border border-slate-700">
                <div class="relative">
                    <div class="w-3 h-3 rounded-full animate-pulse bg-slate-500" id="liveStatusDot"></div>
                    <div class="absolute inset-0 w-3 h-3 rounded-full animate-ping opacity-75 bg-slate-500" id="liveStatusPing" style="display: none;"></div>
                </div>
                <span class="text-slate-200 font-medium" id="liveStatusText">Mode Live actif</span>
            </div>
            
            <div class="sound-waves-live mt-4" style="display: flex; gap: 8px; justify-content: center; align-items: center;">
                <div class="wave-live" style="width: 4px; background: linear-gradient(to top, #64748b, #94a3b8); border-radius: 2px; transition: height 0.05s ease-out; animation: sound 0.8s ease-in-out infinite; height: 10px;"></div>
                <div class="wave-live" style="width: 4px; background: linear-gradient(to top, #64748b, #94a3b8); border-radius: 2px; transition: height 0.05s ease-out; animation: sound 0.8s ease-in-out infinite 0.1s; height: 15px;"></div>
                <div class="wave-live" style="width: 4px; background: linear-gradient(to top, #64748b, #94a3b8); border-radius: 2px; transition: height 0.05s ease-out; animation: sound 0.8s ease-in-out infinite 0.2s; height: 20px;"></div>
                <div class="wave-live" style="width: 4px; background: linear-gradient(to top, #64748b, #94a3b8); border-radius: 2px; transition: height 0.05s ease-out; animation: sound 0.8s ease-in-out infinite 0.3s; height: 25px;"></div>
                <div class="wave-live" style="width: 4px; background: linear-gradient(to top, #64748b, #94a3b8); border-radius: 2px; transition: height 0.05s ease-out; animation: sound 0.8s ease-in-out infinite 0.4s; height: 30px;"></div>
            </div>
        </div>

        <p class="text-slate-400 text-sm mt-6" id="liveSubText">
            Parlez, l'IA vous repondra immediatement
        </p>
        
        <!-- ZONE DE TEXTE OVERLAY (position absolute en bas à droite) -->
        <div id="liveTextOverlay" class="fixed bottom-6 right-6 max-w-md bg-slate-900/95 backdrop-blur-md rounded-xl border border-slate-700 shadow-2xl transition-all duration-300 z-20" style="display: none;">
            <div class="flex items-center justify-between px-4 py-2 border-b border-slate-700">
                <div class="flex items-center gap-2">
                    <div class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></div>
                    <span class="text-slate-300 text-xs font-medium">Conversation en direct</span>
                </div>
                <button id="minimizeOverlayBtn" class="text-slate-500 hover:text-slate-300 transition-colors">
                    <i class="fas fa-minus text-xs"></i>
                </button>
            </div>
            <div id="liveOverlayContent" class="p-4 max-h-80 overflow-y-auto">
                <!-- Les messages apparaîtront ici -->
                <div id="liveWelcomeMsg" class="text-slate-400 text-sm italic">Assistant prêt...</div>
            </div>
        </div>
    </div>
</div>

<style>
/* Animation des bulles */
@keyframes rise {
    0% {
        bottom: -100px;
        transform: translateX(0) scale(1);
        opacity: 0;
    }
    10% {
        opacity: 0.5;
    }
    90% {
        opacity: 0.5;
    }
    100% {
        bottom: 1080px;
        transform: translateX(-100px) scale(1.5);
        opacity: 0;
    }
}

/* Animation des particules */
@keyframes float {
    0% {
        transform: translateY(0) scale(1);
        opacity: 0;
    }
    50% {
        opacity: 0.6;
    }
    100% {
        transform: translateY(-100px) scale(0);
        opacity: 0;
    }
}

/* Animation du son */
@keyframes sound {
    0%, 100% {
        transform: scaleY(1);
    }
    50% {
        transform: scaleY(1.5);
    }
}

@keyframes rotatePyramid {
    from {
        transform: rotateY(0deg);
    }
    to {
        transform: rotateY(360deg);
    }
}

.pyramid {
    animation: rotatePyramid 10s infinite linear;
}

.pyramid.speaking {
    animation: rotatePyramid 3s infinite linear;
}

/* Animation d'ecriture pour l'overlay */
.typing-cursor {
    display: inline-block;
    width: 2px;
    height: 1em;
    background-color: #94a3b8;
    margin-left: 2px;
    animation: blink 1s step-end infinite;
    vertical-align: middle;
}
@keyframes blink {
    0%, 100% { opacity: 1; }
    50% { opacity: 0; }
}

/* Message entrant dans l'overlay */
.overlay-message-in {
    animation: fadeInUp 0.3s ease-out;
}
@keyframes fadeInUp {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}

/* Scroll overlay */
#liveOverlayContent::-webkit-scrollbar {
    width: 4px;
}
#liveOverlayContent::-webkit-scrollbar-track {
    background: rgba(30, 41, 59, 0.3);
    border-radius: 2px;
}
#liveOverlayContent::-webkit-scrollbar-thumb {
    background: #64748b;
    border-radius: 2px;
}

/* Styles existants */
.animate-fade-in { animation: fadeIn 0.5s ease-out; }
@keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }

.animate-message-in {
    animation: messageIn 0.4s ease-out;
}
@keyframes messageIn {
    from { opacity: 0; transform: translateY(10px) scale(0.95); }
    to { opacity: 1; transform: translateY(0) scale(1); }
}

.typing-indicator { display: flex; align-items: center; gap: 6px; padding: 8px 16px; }
.typing-indicator span { width: 8px; height: 8px; background: linear-gradient(to right, #64748b, #94a3b8); border-radius: 50%; animation: typing 1.4s infinite; }
.typing-indicator span:nth-child(2) { animation-delay: 0.2s; }
.typing-indicator span:nth-child(3) { animation-delay: 0.4s; }
@keyframes typing { 0%, 60%, 100% { transform: translateY(0); opacity: 0.6; } 30% { transform: translateY(-6px); opacity: 1; } }

.chat-scroll-area { scrollbar-width: thin; scrollbar-color: #64748b rgba(30, 41, 59, 0.3); }
.chat-scroll-area::-webkit-scrollbar { width: 6px; }
.chat-scroll-area::-webkit-scrollbar-track { background: rgba(30, 41, 59, 0.3); border-radius: 3px; }
.chat-scroll-area::-webkit-scrollbar-thumb { background: #64748b; border-radius: 3px; }

.chat-textarea { 
    min-height: 44px; 
    max-height: 120px; 
    line-height: 1.5; 
    resize: none;
    overflow-y: hidden;
}

.no-scrollbar {
    -ms-overflow-style: none;
    scrollbar-width: none;
}
.no-scrollbar::-webkit-scrollbar {
    display: none;
}

.chat-message-content { word-break: break-word; overflow-wrap: break-word; }
.hide-scroll { scrollbar-width: none; -ms-overflow-style: none; }
.hide-scroll::-webkit-scrollbar { display: none; }

.speak-btn, .copy-btn {
    transition: all 0.2s ease;
    background: transparent;
    border: none;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 28px;
    height: 28px;
    border-radius: 50%;
    margin: 0 2px;
}

.speak-btn:hover, .copy-btn:hover {
    transform: scale(1.1);
    background: rgba(255, 255, 255, 0.1);
}

.speak-btn:active, .copy-btn:active {
    transform: scale(0.95);
}

/* Animation pour l'enregistrement vocal */
@keyframes pulse {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.5; }
}

.animate-pulse {
    animation: pulse 1.5s cubic-bezier(0.4, 0, 0.6, 1) infinite;
}

.animation-delay-200 {
    animation-delay: 0.2s;
}

.animation-delay-400 {
    animation-delay: 0.4s;
}

/* Position absolute pour le bouton effacer */
.absolute {
    position: absolute;
}

.top-4 {
    top: 1rem;
}

.right-4 {
    right: 1rem;
}

.z-10 {
    z-index: 10;
}

.bg-red-600\/80 {
    background-color: rgba(220, 38, 38, 0.8);
}

.backdrop-blur-sm {
    backdrop-filter: blur(4px);
}

.shadow-lg {
    box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
}

/* Responsive - Mobile plein ecran */
@media (max-width: 640px) {
    .chat-scroll-area { 
        max-height: none;
    }
    
    .mobile-full-height {
        height: calc(100vh - 120px) !important;
        min-height: calc(100vh - 120px);
    }
    
    .p-3.sm\:p-4 {
        padding: 0.75rem;
    }
    
    #messageInput {
        font-size: 16px;
    }
    
    .flex.space-x-2 {
        gap: 0.5rem;
    }
    
    #liveTextOverlay {
        left: 16px;
        right: 16px;
        max-width: none;
        bottom: 16px;
    }
}

/* Animation pour le bouton d'envoi */
#sendBtn {
    transition: all 0.3s ease;
}

#sendBtn.stop-mode {
    background-color: #dc2626;
}

#sendBtn.stop-mode:hover {
    background-color: #b91c1c;
}

/* Ajustement pour la version desktop */
@media (min-width: 641px) {
    .mobile-full-height {
        height: 550px;
    }
}

/* Rapprocher les icones dans les messages */
.message-buttons {
    display: flex;
    align-items: center;
    gap: 4px;
    margin-left: 8px;
}

.flex.items-center.gap-2 {
    gap: 6px;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const chatForm = document.getElementById('chatForm');
    const messageInput = document.getElementById('messageInput');
    const chatMessagesContainer = document.getElementById('chatMessagesContainer');
    const sendBtn = document.getElementById('sendBtn');
    const welcomeMessage = document.getElementById('welcomeMessage');
    const typingIndicator = document.getElementById('typingIndicator');
    const effacerHistoriqueBtn = document.getElementById('effacerHistoriqueBtn');
    const confirmModal = document.getElementById('confirmModal');
    const confirmModalContent = document.getElementById('confirmModalContent');
    const confirmEffacerBtn = document.getElementById('confirmEffacerBtn');
    
    // Elements pour l'enregistrement vocal
    const voiceRecordBtn = document.getElementById('voiceRecordBtn');
    const recordingIndicator = document.getElementById('recordingIndicator');
    const stopRecordingBtn = document.getElementById('stopRecordingBtn');
    
    // Elements pour le Live Mode
    const liveModeBtn = document.getElementById('liveModeBtn');
    const liveModeIndicator = document.getElementById('liveModeIndicator');
    const stopLiveModeBtn = document.getElementById('stopLiveModeBtn');
    const liveModeStatus = document.getElementById('liveModeStatus');
    
    // Elements de la modale plein ecran
    const liveModeFullscreen = document.getElementById('liveModeFullscreen');
    const closeLiveModeBtn = document.getElementById('closeLiveModeBtn');
    const livePyramid = document.getElementById('livePyramid');
    const liveStatusText = document.getElementById('liveStatusText');
    const liveStatusDot = document.getElementById('liveStatusDot');
    const liveStatusPing = document.getElementById('liveStatusPing');
    const liveSubText = document.getElementById('liveSubText');
    const pyramidGlow = document.getElementById('pyramidGlow');
    
    // Elements overlay
    const liveTextOverlay = document.getElementById('liveTextOverlay');
    const liveOverlayContent = document.getElementById('liveOverlayContent');
    const minimizeOverlayBtn = document.getElementById('minimizeOverlayBtn');
    const liveWelcomeMsg = document.getElementById('liveWelcomeMsg');
    
    // Variables pour les barres vocales
    const voiceBars = document.querySelectorAll('.voice-bar-live');
    const waveElements = document.querySelectorAll('.wave-live');
    
    const CHAT_HISTORY_KEY = 'managerai_chat_history_{{ Auth::id() }}';
    let chatHistory = JSON.parse(localStorage.getItem(CHAT_HISTORY_KEY)) || [];
    
    // Variables pour la synthese vocale
    let currentUtterance = null;
    let isPlaying = false;
    let currentPlayingButton = null;
    
    // Variables pour la reconnaissance vocale standard
    let recognition = null;
    let isRecording = false;
    let finalTranscript = '';
    let interimTranscript = '';
    let recordingSilenceTimeout = null;
    let isRecognizing = false;
    const RECORDING_SILENCE_DELAY = 1000;
    
    // Variables pour le Live Mode
    let liveModeActive = false;
    let liveRecognition = null;
    let silenceTimeout = null;
    let isProcessingLiveMessage = false;
    let liveConversationHistory = [];
    let isSpeaking = false;
    let currentLiveUtterance = null;
    let accumulatedTranscript = '';
    let lastProcessedQuestion = '';
    let audioIntensity = 0;
    let animationInterval = null;
    const SILENCE_DELAY = 800;
    let welcomeMessageShown = false;
    
    // Variables pour l'animation d'ecriture dans l'overlay
    let overlayTypingInterval = null;
    let currentOverlayTypingDiv = null;
    let currentOverlayTypingFullText = '';
    let currentOverlayTypingIndex = 0;
    let isOverlayTypingActive = false;
    
    // Variables pour l'animation d'ecriture dans le chat (SANS lecture vocale automatique)
    let currentTypingAnimation = null;
    let currentTypingMessageDiv = null;
    let currentTypingContentDiv = null;
    let currentTypingFullText = '';
    let currentTypingIndex = 0;
    let isTypingActive = false;
    let isAwaitingResponse = false;
    let currentAbortController = null;
    
    // Fonction pour arreter la lecture vocale en cours
    function stopCurrentSpeaking() {
        if (window.speechSynthesis) {
            window.speechSynthesis.cancel();
        }
    }
    
    // Fonction pour parler le texte (UNIQUEMENT sur demande)
    function speakTextManually(text, button) {
        // Si une lecture est en cours, on l'arrete
        if (isPlaying) {
            stopCurrentSpeaking();
            if (currentPlayingButton) {
                currentPlayingButton.innerHTML = '<i class="fas fa-volume-up"></i>';
                currentPlayingButton.classList.remove('text-red-400');
                currentPlayingButton.classList.add('text-slate-400');
            }
            isPlaying = false;
            currentPlayingButton = null;
            return;
        }
        
        const cleanText = text.replace(/<[^>]*>/g, '');
        if (!cleanText) return;
        
        currentUtterance = new SpeechSynthesisUtterance(cleanText);
        currentUtterance.lang = 'fr-FR';
        currentUtterance.rate = 1.5;
        currentUtterance.pitch = 1;
        
        const voices = window.speechSynthesis.getVoices();
        const frenchVoice = voices.find(v => v.lang === 'fr-FR' && (v.name.includes('Google') || v.name.includes('Samantha')));
        if (frenchVoice) {
            currentUtterance.voice = frenchVoice;
        }
        
        button.innerHTML = '<i class="fas fa-stop"></i>';
        button.classList.remove('text-slate-400');
        button.classList.add('text-red-400');
        isPlaying = true;
        currentPlayingButton = button;
        
        currentUtterance.onend = () => {
            if (button) {
                button.innerHTML = '<i class="fas fa-volume-up"></i>';
                button.classList.remove('text-red-400');
                button.classList.add('text-slate-400');
            }
            isPlaying = false;
            currentPlayingButton = null;
            currentUtterance = null;
        };
        
        currentUtterance.onerror = () => {
            if (button) {
                button.innerHTML = '<i class="fas fa-volume-up"></i>';
                button.classList.remove('text-red-400');
                button.classList.add('text-slate-400');
            }
            isPlaying = false;
            currentPlayingButton = null;
            currentUtterance = null;
        };
        
        window.speechSynthesis.speak(currentUtterance);
    }
    
    // Fonction pour arreter l'animation d'ecriture en cours
    function stopTypingAndSave() {
        if (isTypingActive && currentTypingAnimation) {
            clearTimeout(currentTypingAnimation);
            isTypingActive = false;
            currentTypingAnimation = null;
            currentTypingMessageDiv = null;
            currentTypingContentDiv = null;
            currentTypingFullText = '';
            currentTypingIndex = 0;
        }
    }
    
    // Fonction pour demarrer l'animation d'ecriture (SANS lecture vocale)
    async function startTypingAnimation(content, targetElement, messageDiv) {
        stopTypingAndSave();
        
        isTypingActive = true;
        currentTypingFullText = content;
        currentTypingContentDiv = targetElement;
        currentTypingMessageDiv = messageDiv;
        currentTypingIndex = 0;
        targetElement.innerHTML = '';
        
        function addChar() {
            if (!isTypingActive) return;
            
            if (currentTypingIndex < currentTypingFullText.length) {
                const char = currentTypingFullText[currentTypingIndex];
                
                if (char === '\n') {
                    targetElement.innerHTML += '<br>';
                } else {
                    targetElement.innerHTML += char;
                }
                
                currentTypingIndex++;
                
                scrollToBottom();
                currentTypingAnimation = setTimeout(addChar, 20);
            } else {
                isTypingActive = false;
                targetElement.innerHTML = formatMessageContent(currentTypingFullText);
                currentTypingAnimation = null;
                currentTypingMessageDiv = null;
                currentTypingContentDiv = null;
                
                if (messageDiv && messageDiv.dataset.messageId) {
                    const lastMessage = chatHistory[chatHistory.length - 1];
                    if (lastMessage && lastMessage.role === 'assistant') {
                        lastMessage.content = currentTypingFullText;
                        localStorage.setItem(CHAT_HISTORY_KEY, JSON.stringify(chatHistory));
                    }
                }
            }
        }
        
        addChar();
    }
    
    // Fonction pour animer les barres vocales (Live Mode)
    function startAudioAnimation() {
        if (animationInterval) return;
        animationInterval = setInterval(() => {
            if (isSpeaking || (liveModeActive && !isProcessingLiveMessage && !isSpeaking)) {
                audioIntensity = Math.random() * 50 + 20;
                for (let i = 0; i < voiceBars.length; i++) {
                    const height = 10 + (Math.random() * 40);
                    if (voiceBars[i]) voiceBars[i].style.height = height + 'px';
                }
                for (let i = 0; i < waveElements.length; i++) {
                    const height = 10 + (Math.random() * 30);
                    if (waveElements[i]) waveElements[i].style.height = height + 'px';
                }
                
                if (pyramidGlow) {
                    const intensity = audioIntensity / 100;
                    pyramidGlow.style.opacity = 0.3 + intensity * 0.5;
                    pyramidGlow.style.transform = `scale(${1 + intensity * 0.2})`;
                }
            } else {
                for (let i = 0; i < voiceBars.length; i++) {
                    if (voiceBars[i]) voiceBars[i].style.height = '10px';
                }
                for (let i = 0; i < waveElements.length; i++) {
                    if (waveElements[i]) waveElements[i].style.height = '10px';
                }
                if (pyramidGlow) {
                    pyramidGlow.style.opacity = '0.3';
                    pyramidGlow.style.transform = 'scale(1)';
                }
            }
        }, 100);
    }
    
    function stopAudioAnimation() {
        if (animationInterval) {
            clearInterval(animationInterval);
            animationInterval = null;
        }
    }
    
    // Fonction pour arreter l'animation d'ecriture dans l'overlay
    function stopOverlayTyping() {
        if (overlayTypingInterval) {
            clearInterval(overlayTypingInterval);
            overlayTypingInterval = null;
        }
        isOverlayTypingActive = false;
        currentOverlayTypingDiv = null;
        currentOverlayTypingFullText = '';
        currentOverlayTypingIndex = 0;
    }
    
    // Fonction pour ajouter un message dans l'overlay avec animation d'ecriture (Live Mode avec lecture vocale)
    async function addOverlayMessage(role, content, withTypingAnimation = true, speakText = false) {
        return new Promise((resolve) => {
            const isUser = role === 'user';
            
            if (liveWelcomeMsg) {
                liveWelcomeMsg.style.display = 'none';
            }
            
            if (liveTextOverlay && liveTextOverlay.style.display === 'none') {
                liveTextOverlay.style.display = 'block';
            }
            
            const messageDiv = document.createElement('div');
            messageDiv.className = `mb-3 overlay-message-in`;
            
            const bubbleClass = isUser ? 'bg-slate-700/50 rounded-l-xl rounded-tr-xl ml-auto' : 'bg-slate-800/50 rounded-r-xl rounded-tl-xl';
            const textColor = isUser ? 'text-slate-100' : 'text-slate-200';
            
            messageDiv.innerHTML = `
                <div class="${bubbleClass} px-3 py-2 max-w-[90%] ${isUser ? 'text-right' : ''}" style="width: fit-content;">
                    <div class="flex items-center gap-2 mb-1 ${isUser ? 'justify-end' : 'justify-start'}">
                        <i class="fas ${isUser ? 'fa-user' : 'fa-robot'} text-slate-500 text-xs"></i>
                        <span class="text-slate-500 text-xs font-medium">${isUser ? 'Vous' : 'ManagerAI'}</span>
                    </div>
                    <div class="${textColor} text-sm leading-relaxed overlay-message-content"></div>
                </div>
            `;
            
            liveOverlayContent.appendChild(messageDiv);
            const contentDiv = messageDiv.querySelector('.overlay-message-content');
            
            liveOverlayContent.scrollTop = liveOverlayContent.scrollHeight;
            
            if (!withTypingAnimation || isUser) {
                contentDiv.innerHTML = content.replace(/\n/g, '<br>');
                if (speakText && !isUser) {
                    // Pour le Live Mode, la lecture vocale est active
                    const cleanText = content.replace(/<[^>]*>/g, '');
                    if (cleanText) {
                        const utterance = new SpeechSynthesisUtterance(cleanText);
                        utterance.lang = 'fr-FR';
                        utterance.rate = 1.5;
                        utterance.pitch = 1;
                        const voices = window.speechSynthesis.getVoices();
                        const frenchVoice = voices.find(v => v.lang === 'fr-FR' && (v.name.includes('Google') || v.name.includes('Samantha')));
                        if (frenchVoice) utterance.voice = frenchVoice;
                        window.speechSynthesis.speak(utterance);
                    }
                }
                resolve();
            } else {
                if (speakText) {
                    // Pour le Live Mode, la lecture vocale est active
                    const cleanText = content.replace(/<[^>]*>/g, '');
                    if (cleanText) {
                        const utterance = new SpeechSynthesisUtterance(cleanText);
                        utterance.lang = 'fr-FR';
                        utterance.rate = 1.5;
                        utterance.pitch = 1;
                        const voices = window.speechSynthesis.getVoices();
                        const frenchVoice = voices.find(v => v.lang === 'fr-FR' && (v.name.includes('Google') || v.name.includes('Samantha')));
                        if (frenchVoice) utterance.voice = frenchVoice;
                        window.speechSynthesis.speak(utterance);
                    }
                }
                
                isOverlayTypingActive = true;
                currentOverlayTypingDiv = contentDiv;
                currentOverlayTypingFullText = content;
                currentOverlayTypingIndex = 0;
                contentDiv.innerHTML = '';
                
                overlayTypingInterval = setInterval(() => {
                    if (!isOverlayTypingActive || currentOverlayTypingIndex >= currentOverlayTypingFullText.length) {
                        if (currentOverlayTypingIndex >= currentOverlayTypingFullText.length) {
                            clearInterval(overlayTypingInterval);
                            overlayTypingInterval = null;
                            isOverlayTypingActive = false;
                            resolve();
                        }
                        return;
                    }
                    
                    const char = currentOverlayTypingFullText[currentOverlayTypingIndex];
                    if (char === '\n') {
                        contentDiv.innerHTML += '<br>';
                    } else {
                        contentDiv.innerHTML += char;
                    }
                    currentOverlayTypingIndex++;
                    
                    liveOverlayContent.scrollTop = liveOverlayContent.scrollHeight;
                }, 25);
            }
        });
    }
    
    // Fonction pour arreter completement la reponse en cours
    function stopCurrentResponse() {
        stopTypingAndSave();
        
        if (currentAbortController) {
            currentAbortController.abort();
            currentAbortController = null;
        }
        
        if (sendBtn) {
            sendBtn.disabled = false;
            sendBtn.innerHTML = '<i class="fas fa-paper-plane text-sm sm:text-base"></i>' + (window.innerWidth >= 640 ? '<span class="hidden sm:inline ml-2">Envoyer</span>' : '');
            sendBtn.classList.remove('stop-mode');
        }
        
        if (typingIndicator) {
            typingIndicator.classList.add('hidden');
        }
        
        isAwaitingResponse = false;
    }
    
    // Fonction pour copier le texte avec feedback visuel
    async function copyToClipboard(text, button) {
        try {
            await navigator.clipboard.writeText(text);
            
            const originalIcon = button.innerHTML;
            const originalClasses = button.className;
            
            button.innerHTML = '<i class="fas fa-check"></i>';
            button.classList.add('text-green-400');
            button.classList.remove('text-slate-400');
            
            setTimeout(() => {
                button.innerHTML = originalIcon;
                button.className = originalClasses;
            }, 2000);
        } catch (err) {
            console.error('Erreur lors de la copie:', err);
        }
    }
    
    // Initialiser la reconnaissance vocale standard
    function initSpeechRecognition() {
        if (!('webkitSpeechRecognition' in window) && !('SpeechRecognition' in window)) {
            console.warn('La reconnaissance vocale n\'est pas supportee par ce navigateur');
            if (voiceRecordBtn) {
                voiceRecordBtn.style.opacity = '0.5';
                voiceRecordBtn.disabled = true;
                voiceRecordBtn.title = 'Reconnaissance vocale non supportee';
            }
            if (liveModeBtn) {
                liveModeBtn.style.opacity = '0.5';
                liveModeBtn.disabled = true;
                liveModeBtn.title = 'Mode Live non supporte';
            }
            return null;
        }
        
        const SpeechRecognition = window.SpeechRecognition || window.webkitSpeechRecognition;
        const recognitionInstance = new SpeechRecognition();
        
        recognitionInstance.lang = 'fr-FR';
        recognitionInstance.continuous = true;
        recognitionInstance.interimResults = true;
        recognitionInstance.maxAlternatives = 1;
        
        return recognitionInstance;
    }
    
    // Initialiser la reconnaissance pour le Live Mode
    function initLiveRecognition() {
        if (!('webkitSpeechRecognition' in window) && !('SpeechRecognition' in window)) {
            return null;
        }
        
        const SpeechRecognition = window.SpeechRecognition || window.webkitSpeechRecognition;
        const recognitionInstance = new SpeechRecognition();
        
        recognitionInstance.lang = 'fr-FR';
        recognitionInstance.continuous = true;
        recognitionInstance.interimResults = true;
        recognitionInstance.maxAlternatives = 1;
        
        return recognitionInstance;
    }
    
    // Demarrer l'ecoute (microphone)
    function startListening() {
        if (!liveRecognition || !liveModeActive) return;
        if (isSpeaking) return;
        
        try {
            liveRecognition.start();
            console.log('Live Mode - Ecoute demarree');
        } catch (e) {
            console.error('Erreur au demarrage de l\'ecoute:', e);
        }
    }
    
    // Arreter l'ecoute (microphone)
    function stopListening() {
        if (!liveRecognition) return;
        
        try {
            liveRecognition.stop();
            console.log('Live Mode - Ecoute arretée');
        } catch (e) {
            console.error('Erreur a l\'arret de l\'ecoute:', e);
        }
    }
    
    // Fonction pour parler en Live Mode (avec overlay et lecture vocale automatique)
    async function speakTextLive(text, onEndCallback = null) {
        return new Promise(async (resolve) => {
            const cleanText = text.replace(/<[^>]*>/g, '').trim();
            if (!cleanText) {
                if (onEndCallback) onEndCallback();
                resolve();
                return;
            }
            
            if (liveRecognition && liveModeActive) {
                stopListening();
            }
            
            isSpeaking = true;
            
            // Afficher le message de l'IA avec animation et lecture vocale (speakText = true)
            await addOverlayMessage('assistant', cleanText, true, true);
            
            if (liveStatusText) {
                liveStatusText.textContent = 'L\'IA repond...';
            }
            if (liveStatusDot) liveStatusDot.classList.remove('bg-slate-500');
            if (liveStatusDot) liveStatusDot.classList.add('bg-yellow-500');
            if (liveStatusPing) liveStatusPing.style.display = 'none';
            if (liveSubText) liveSubText.textContent = 'L\'assistant vous repond...';
            
            if (livePyramid) {
                livePyramid.classList.add('speaking');
            }
            
            // Attendre que la lecture soit terminee
            const checkSpeaking = setInterval(() => {
                if (!window.speechSynthesis.speaking && !isOverlayTypingActive) {
                    clearInterval(checkSpeaking);
                    isSpeaking = false;
                    
                    if (liveStatusText && liveModeActive) {
                        liveStatusText.textContent = 'Je vous ecoute...';
                    }
                    if (liveStatusDot) liveStatusDot.classList.remove('bg-yellow-500');
                    if (liveStatusDot) liveStatusDot.classList.add('bg-slate-500');
                    if (liveStatusPing && liveModeActive) liveStatusPing.style.display = 'block';
                    if (liveSubText && liveModeActive) liveSubText.textContent = 'Parlez, l\'IA vous repondra immediatement';
                    
                    if (livePyramid) {
                        livePyramid.classList.remove('speaking');
                    }
                    
                    if (onEndCallback) onEndCallback();
                    
                    if (liveModeActive && !isProcessingLiveMessage) {
                        setTimeout(() => {
                            if (liveModeActive && !isSpeaking && !isProcessingLiveMessage) {
                                startListening();
                            }
                        }, 300);
                    }
                    resolve();
                }
            }, 100);
        });
    }
    
    // Fonction pour dire le message d'accueil en Live Mode
    async function speakWelcomeMessage() {
        if (welcomeMessageShown) return;
        
        welcomeMessageShown = true;
        const welcomeText = "Bonjour, je suis ManagerAI, prête à vous aider à gérer au mieux votre entreprise. Comment puis-je vous aider aujourd'hui ?";
        
        await addOverlayMessage('assistant', welcomeText, true, true);
        
        // Attendre la fin de la lecture
        await new Promise((resolve) => {
            const checkInterval = setInterval(() => {
                if (!window.speechSynthesis.speaking && !isOverlayTypingActive) {
                    clearInterval(checkInterval);
                    resolve();
                }
            }, 100);
        });
    }
    
    // Demander la permission du microphone
    async function requestMicrophonePermission() {
        try {
            const stream = await navigator.mediaDevices.getUserMedia({ audio: true });
            stream.getTracks().forEach(track => track.stop());
            return true;
        } catch (error) {
            console.error('Permission microphone refusée:', error);
            showNotification('Veuillez autoriser l\'accès au microphone pour utiliser les fonctionnalités vocales', 'error');
            return false;
        }
    }
    
    // Demarrer le Live Mode (plein ecran)
    async function startLiveMode() {
        if (!liveRecognition) {
            showNotification('Mode Live non supporte par votre navigateur', 'error');
            return;
        }
        
        // Demander la permission du microphone
        const hasPermission = await requestMicrophonePermission();
        if (!hasPermission) return;
        
        if (liveModeActive) return;
        
        liveModeActive = true;
        welcomeMessageShown = false;
        liveConversationHistory = [];
        isSpeaking = false;
        accumulatedTranscript = '';
        lastProcessedQuestion = '';
        
        if (liveTextOverlay) {
            liveTextOverlay.style.display = 'block';
            if (liveOverlayContent) {
                liveOverlayContent.innerHTML = '';
                if (liveWelcomeMsg) {
                    liveWelcomeMsg.style.display = 'block';
                    liveOverlayContent.appendChild(liveWelcomeMsg);
                }
            }
        }
        
        liveModeFullscreen.classList.remove('hidden');
        startAudioAnimation();
        
        if (liveStatusText) liveStatusText.textContent = 'L\'IA parle...';
        if (liveStatusDot) liveStatusDot.classList.remove('bg-slate-500');
        if (liveStatusDot) liveStatusDot.classList.add('bg-yellow-500');
        if (liveStatusPing) liveStatusPing.style.display = 'none';
        if (liveSubText) liveSubText.textContent = 'L\'assistant vous dit bonjour...';
        
        if (livePyramid) {
            livePyramid.style.animation = 'rotatePyramid 10s infinite linear';
            livePyramid.classList.add('speaking');
        }
        
        if (liveModeIndicator) liveModeIndicator.classList.add('hidden');
        if (liveModeBtn) {
            liveModeBtn.classList.add('bg-red-600', 'hover:bg-red-700');
            liveModeBtn.classList.remove('bg-slate-700', 'hover:bg-slate-800');
        }
        
        await speakWelcomeMessage();
        
        if (liveModeActive) {
            if (liveStatusText) liveStatusText.textContent = 'Je vous ecoute...';
            if (liveStatusDot) liveStatusDot.classList.remove('bg-yellow-500');
            if (liveStatusDot) liveStatusDot.classList.add('bg-slate-500');
            if (liveStatusPing) liveStatusPing.style.display = 'block';
            if (liveSubText) liveSubText.textContent = 'Parlez, l\'IA vous repondra immediatement';
            if (livePyramid) {
                livePyramid.classList.remove('speaking');
            }
            startListening();
        }
        
        showNotification('Mode Live active !', 'success');
    }
    
    // Arreter le Live Mode
    function stopLiveMode() {
        if (!liveModeActive) return;
        
        liveModeActive = false;
        welcomeMessageShown = false;
        
        stopAudioAnimation();
        stopOverlayTyping();
        stopCurrentSpeaking();
        
        if (window.speechSynthesis.speaking) {
            window.speechSynthesis.cancel();
        }
        
        stopListening();
        
        if (silenceTimeout) {
            clearTimeout(silenceTimeout);
            silenceTimeout = null;
        }
        
        accumulatedTranscript = '';
        lastProcessedQuestion = '';
        isSpeaking = false;
        currentLiveUtterance = null;
        
        if (liveTextOverlay) {
            liveTextOverlay.style.display = 'none';
        }
        
        liveModeFullscreen.classList.add('hidden');
        
        if (liveStatusText) liveStatusText.textContent = '';
        if (liveStatusDot) liveStatusDot.classList.remove('bg-slate-500', 'bg-yellow-500');
        if (liveStatusPing) liveStatusPing.style.display = 'none';
        
        if (livePyramid) {
            livePyramid.style.animation = '';
            livePyramid.classList.remove('speaking');
        }
        
        if (liveModeIndicator) liveModeIndicator.classList.add('hidden');
        if (liveModeBtn) {
            liveModeBtn.classList.remove('bg-red-600', 'hover:bg-red-700');
            liveModeBtn.classList.add('bg-slate-700', 'hover:bg-slate-800');
        }
        
        if (messageInput) {
            messageInput.placeholder = 'Ecrivez votre question ou utilisez le mode Live...';
        }
        
        isProcessingLiveMessage = false;
        
        showNotification('Mode Live desactive', 'info');
    }
    
    // Traiter un message en Live Mode
    async function processLiveMessage(message) {
        if (!message.trim() || isProcessingLiveMessage) return;
        
        if (message === lastProcessedQuestion) return;
        lastProcessedQuestion = message;
        
        isProcessingLiveMessage = true;
        
        stopListening();
        
        await addOverlayMessage('user', message, false);
        
        if (liveStatusText) {
            liveStatusText.textContent = 'Reflexion en cours...';
        }
        if (liveStatusDot) liveStatusDot.classList.remove('bg-slate-500');
        if (liveStatusDot) liveStatusDot.classList.add('bg-yellow-500');
        if (liveStatusPing) liveStatusPing.style.display = 'none';
        
        liveConversationHistory.push({
            role: 'user',
            content: message,
            timestamp: new Date().toISOString()
        });
        
        try {
            const response = await fetch('{{ route("chat.ai") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ 
                    message: message,
                    historique: liveConversationHistory.slice(-10).map(item => ({
                        role: item.role,
                        content: item.content
                    }))
                })
            });
            
            const data = await response.json();
            
            if (data.status === 'success') {
                const aiResponse = data.response;
                
                liveConversationHistory.push({
                    role: 'assistant',
                    content: aiResponse,
                    timestamp: new Date().toISOString()
                });
                
                await speakTextLive(aiResponse);
                
            } else {
                throw new Error(data.message || 'Erreur inconnue');
            }
        } catch (error) {
            console.error('Erreur Live Mode:', error);
            await speakTextLive('Desole, une erreur est survenue. Veuillez reessayer.');
        } finally {
            isProcessingLiveMessage = false;
            
            accumulatedTranscript = '';
            
            if (liveModeActive && !isSpeaking) {
                setTimeout(() => {
                    if (liveModeActive && !isSpeaking && !isProcessingLiveMessage) {
                        startListening();
                        if (liveStatusText) {
                            liveStatusText.textContent = 'Je vous ecoute...';
                        }
                        if (liveStatusDot) liveStatusDot.classList.remove('bg-yellow-500');
                        if (liveStatusDot) liveStatusDot.classList.add('bg-slate-500');
                        if (liveStatusPing) liveStatusPing.style.display = 'block';
                        if (liveSubText) liveSubText.textContent = 'Parlez, l\'IA vous repondra immediatement';
                    }
                }, 500);
            }
        }
    }
    
    // Configurer les evenements pour le Live Mode
    function setupLiveRecognitionEvents() {
        if (!liveRecognition) return;
        
        liveRecognition.onstart = function() {
            console.log('Live Mode - Ecoute demarree');
            accumulatedTranscript = '';
        };
        
        liveRecognition.onresult = function(event) {
            if (!liveModeActive) return;
            if (isSpeaking) return;
            
            let finalText = '';
            let interimText = '';
            
            for (let i = event.resultIndex; i < event.results.length; i++) {
                const result = event.results[i];
                const transcript = result[0].transcript.trim();
                
                if (result.isFinal) {
                    finalText += transcript;
                } else {
                    interimText += transcript;
                }
            }
            
            if (finalText) {
                if (accumulatedTranscript) {
                    accumulatedTranscript += ' ' + finalText;
                } else {
                    accumulatedTranscript = finalText;
                }
                
                if (silenceTimeout) {
                    clearTimeout(silenceTimeout);
                }
                
                silenceTimeout = setTimeout(() => {
                    if (liveModeActive && accumulatedTranscript && !isProcessingLiveMessage && !isSpeaking) {
                        const cleanQuestion = accumulatedTranscript.trim();
                        if (cleanQuestion.length > 3) {
                            console.log('Envoi de la question:', cleanQuestion);
                            processLiveMessage(cleanQuestion);
                        } else {
                            accumulatedTranscript = '';
                        }
                    }
                }, SILENCE_DELAY);
            }
        };
        
        liveRecognition.onend = function() {
            console.log('Live Mode - Ecoute terminee');
            
            if (liveModeActive && !isSpeaking && !isProcessingLiveMessage && welcomeMessageShown) {
                setTimeout(() => {
                    if (liveModeActive && !isSpeaking && !isProcessingLiveMessage) {
                        try {
                            liveRecognition.start();
                            console.log('Live Mode - Ecoute redemarree');
                        } catch (e) {
                            console.error('Erreur lors du redemarrage:', e);
                        }
                    }
                }, 100);
            }
        };
        
        liveRecognition.onerror = function(event) {
            console.error('Live Mode - Erreur:', event.error);
            
            if (event.error === 'not-allowed') {
                showNotification('Microphone non autorise pour le Mode Live', 'error');
                stopLiveMode();
            } else if (event.error === 'no-speech') {
                if (liveStatusText && !isSpeaking && liveModeActive) {
                    liveStatusText.textContent = 'En attente de votre voix...';
                }
            } else if (liveModeActive && event.error !== 'aborted' && !isSpeaking && welcomeMessageShown) {
                setTimeout(() => {
                    if (liveModeActive && !isSpeaking && !isProcessingLiveMessage) {
                        try {
                            liveRecognition.start();
                        } catch (e) {
                            console.error('Erreur lors du redemarrage:', e);
                        }
                    }
                }, 1000);
            }
        };
    }
    
    // Fonction pour demarrer l'enregistrement standard (avec envoi automatique)
    function startRecording() {
        if (!recognition) {
            showNotification('Reconnaissance vocale non supportee par votre navigateur', 'error');
            return;
        }
        
        if (isRecording) return;
        
        if (liveModeActive) {
            stopLiveMode();
        }
        
        finalTranscript = '';
        interimTranscript = '';
        
        try {
            recognition.start();
            isRecording = true;
            isRecognizing = true;
            
            recordingIndicator.classList.remove('hidden');
            voiceRecordBtn.classList.add('bg-red-600', 'hover:bg-red-700');
            voiceRecordBtn.classList.remove('bg-slate-700', 'hover:bg-slate-800');
            
            messageInput.placeholder = 'Ecoute en cours... Parlez maintenant';
            messageInput.classList.add('border-red-500');
            
            showNotification('Enregistrement demarre, parlez maintenant', 'info');
        } catch (e) {
            console.error('Erreur au demarrage de l\'enregistrement:', e);
            showNotification('Erreur: Impossible de demarrer l\'enregistrement', 'error');
        }
    }
    
    // Fonction pour arreter l'enregistrement standard et envoyer automatiquement
    function stopRecordingAndSend() {
        if (!recognition || !isRecording) return;
        
        try {
            recognition.stop();
        } catch (e) {
            console.error('Erreur a l\'arret de l\'enregistrement:', e);
        }
        
        isRecording = false;
        isRecognizing = false;
        
        if (recordingSilenceTimeout) {
            clearTimeout(recordingSilenceTimeout);
        }
        
        recordingIndicator.classList.add('hidden');
        voiceRecordBtn.classList.remove('bg-red-600', 'hover:bg-red-700');
        voiceRecordBtn.classList.add('bg-slate-700', 'hover:bg-slate-800');
        
        messageInput.placeholder = 'Ecrivez votre question ou utilisez le mode Live...';
        messageInput.classList.remove('border-red-500');
        
        if (finalTranscript.trim()) {
            messageInput.value = finalTranscript.trim();
            adjustTextareaHeight();
            showNotification('Texte reconnu, envoi automatique...', 'success');
            setTimeout(() => autoSendVoiceMessage(), 100);
        } else if (interimTranscript.trim()) {
            messageInput.value = interimTranscript.trim();
            adjustTextareaHeight();
            showNotification('Texte reconnu, envoi automatique...', 'success');
            setTimeout(() => autoSendVoiceMessage(), 100);
        }
    }
    
    function autoSendVoiceMessage() {
        const text = messageInput.value.trim();
        if (text && chatForm && !liveModeActive && !isAwaitingResponse) {
            chatForm.dispatchEvent(new Event('submit'));
        }
    }
    
    // Configurer les evenements de reconnaissance vocale standard
    function setupSpeechRecognitionEvents() {
        if (!recognition) return;
        
        recognition.onstart = function() {
            console.log('Reconnaissance vocale demarree');
            if (recordingSilenceTimeout) {
                clearTimeout(recordingSilenceTimeout);
            }
        };
        
        recognition.onend = function() {
            console.log('Reconnaissance vocale terminee');
            if (recordingSilenceTimeout) {
                clearTimeout(recordingSilenceTimeout);
            }
            if (isRecording) {
                isRecording = false;
                recordingIndicator.classList.add('hidden');
                voiceRecordBtn.classList.remove('bg-red-600', 'hover:bg-red-700');
                voiceRecordBtn.classList.add('bg-slate-700', 'hover:bg-slate-800');
                messageInput.placeholder = 'Ecrivez votre question ou utilisez le mode Live...';
                messageInput.classList.remove('border-red-500');
            }
        };
        
        recognition.onresult = function(event) {
            let interim = '';
            let final = '';
            
            for (let i = event.resultIndex; i < event.results.length; i++) {
                const transcript = event.results[i][0].transcript;
                
                if (event.results[i].isFinal) {
                    final += transcript;
                } else {
                    interim += transcript;
                }
            }
            
            if (final) {
                finalTranscript = final;
                messageInput.value = final;
                adjustTextareaHeight();
                
                if (recordingSilenceTimeout) {
                    clearTimeout(recordingSilenceTimeout);
                }
                recordingSilenceTimeout = setTimeout(() => {
                    if (isRecording && finalTranscript.trim()) {
                        stopRecordingAndSend();
                    }
                }, RECORDING_SILENCE_DELAY);
            } else if (interim) {
                interimTranscript = interim;
                messageInput.value = interim;
                adjustTextareaHeight();
                
                if (recordingSilenceTimeout) {
                    clearTimeout(recordingSilenceTimeout);
                }
                recordingSilenceTimeout = setTimeout(() => {
                    if (isRecording && interimTranscript.trim()) {
                        stopRecordingAndSend();
                    }
                }, RECORDING_SILENCE_DELAY);
            }
        };
        
        recognition.onerror = function(event) {
            console.error('Erreur de reconnaissance vocale:', event.error);
            if (recordingSilenceTimeout) {
                clearTimeout(recordingSilenceTimeout);
            }
            isRecording = false;
            recordingIndicator.classList.add('hidden');
            voiceRecordBtn.classList.remove('bg-red-600', 'hover:bg-red-700');
            voiceRecordBtn.classList.add('bg-slate-700', 'hover:bg-slate-800');
            messageInput.placeholder = 'Ecrivez votre question ou utilisez le mode Live...';
            messageInput.classList.remove('border-red-500');
            
            let errorMessage = 'Erreur de reconnaissance vocale';
            if (event.error === 'not-allowed') {
                errorMessage = 'Microphone non autorise. Veuillez autoriser l\'acces au microphone.';
            } else if (event.error === 'no-speech') {
                errorMessage = 'Aucune parole detectee. Veuillez reessayer.';
            }
            showNotification(errorMessage, 'error');
        };
    }
    
    function initVoice() {
        // Preload voices
        if (window.speechSynthesis) {
            window.speechSynthesis.getVoices();
        }
    }
    
    if (window.speechSynthesis) {
        window.speechSynthesis.onvoiceschanged = initVoice;
        initVoice();
    }
    
    recognition = initSpeechRecognition();
    if (recognition) {
        setupSpeechRecognitionEvents();
    }
    
    liveRecognition = initLiveRecognition();
    if (liveRecognition) {
        setupLiveRecognitionEvents();
    }
    
    if (voiceRecordBtn) {
        voiceRecordBtn.addEventListener('click', async function() {
            if (isRecording) {
                stopRecordingAndSend();
            } else {
                const hasPermission = await requestMicrophonePermission();
                if (hasPermission) {
                    startRecording();
                }
            }
        });
    }
    
    if (stopRecordingBtn) {
        stopRecordingBtn.addEventListener('click', stopRecordingAndSend);
    }
    
    if (liveModeBtn) {
        liveModeBtn.addEventListener('click', function() {
            if (liveModeActive) {
                stopLiveMode();
            } else {
                startLiveMode();
            }
        });
    }
    
    if (stopLiveModeBtn) {
        stopLiveModeBtn.addEventListener('click', stopLiveMode);
    }
    
    if (closeLiveModeBtn) {
        closeLiveModeBtn.addEventListener('click', stopLiveMode);
    }
    
    if (minimizeOverlayBtn) {
        minimizeOverlayBtn.addEventListener('click', function() {
            if (liveTextOverlay) {
                liveTextOverlay.style.display = 'none';
            }
        });
    }
    
    function adjustTextareaHeight() {
        if (messageInput) {
            messageInput.style.height = 'auto';
            messageInput.style.height = Math.min(messageInput.scrollHeight, 120) + 'px';
        }
    }
    
    function formatMessageContent(content) {
        let formatted = content.replace(/\n/g, '<br>');
        formatted = formatted.replace(/\*\*(.*?)\*\*/g, '$1');
        return formatted;
    }
    
    function createMessageElement(role, content) {
        const messageDiv = document.createElement('div');
        const isUser = role === 'user';
        const icon = isUser ? 'fa-user' : 'fa-robot';
        const bgColor = isUser ? 'bg-slate-600/20' : 'bg-slate-600';
        const name = isUser ? 'Vous' : 'ManagerAI';
        const alignment = isUser ? 'ml-auto' : '';
        const messageId = 'msg_' + Date.now() + '_' + Math.random().toString(36).substr(2, 9);
        
        messageDiv.className = `bg-slate-700/50 rounded-xl p-3 sm:p-4 md:p-5 max-w-[90%] sm:max-w-[80%] ${alignment} animate-message-in`;
        messageDiv.dataset.messageId = messageId;
        
        messageDiv.innerHTML = `
            <div class="flex items-start gap-2 sm:gap-3 ${isUser ? 'flex-row-reverse' : ''}">
                <div class="flex-shrink-0 w-7 h-7 sm:w-8 sm:h-8 md:w-10 md:h-10 ${bgColor} rounded-full flex items-center justify-center shadow-lg">
                    <i class="fas ${icon} text-white text-xs sm:text-sm"></i>
                </div>
                <div class="flex-1 ${isUser ? 'text-right' : ''}">
                    <div class="flex items-center gap-2 ${isUser ? 'justify-end' : 'justify-start'}">
                        <p class="text-white font-semibold text-xs sm:text-sm md:text-base mb-1 sm:mb-2">${name}</p>
                        ${!isUser ? `
                        <div class="message-buttons">
                            <button class="speak-btn text-slate-400 hover:text-slate-300 transition-colors text-xs sm:text-sm" title="Lire le message">
                                <i class="fas fa-volume-up"></i>
                            </button>
                            <button class="copy-btn text-slate-400 hover:text-green-400 transition-colors text-xs sm:text-sm" title="Copier le message">
                                <i class="fas fa-copy"></i>
                            </button>
                        </div>
                        ` : `
                        <button class="copy-btn text-slate-400 hover:text-green-400 transition-colors text-xs sm:text-sm" title="Copier le message">
                            <i class="fas fa-copy"></i>
                        </button>
                        `}
                    </div>
                    <div class="text-slate-200 text-xs sm:text-sm leading-relaxed chat-message-content"></div>
                    <p class="text-slate-400 text-[10px] sm:text-xs mt-1 sm:mt-2 timestamp">${new Date().toLocaleTimeString('fr-FR', {hour: '2-digit', minute:'2-digit'})}</p>
                </div>
            </div>
        `;
        
        if (!isUser) {
            const speakBtn = messageDiv.querySelector('.speak-btn');
            if (speakBtn) {
                speakBtn.addEventListener('click', (e) => {
                    e.stopPropagation();
                    const fullText = messageDiv.querySelector('.chat-message-content').innerText;
                    speakTextManually(fullText, speakBtn);
                });
            }
        }
        
        const copyBtn = messageDiv.querySelector('.copy-btn');
        if (copyBtn) {
            copyBtn.addEventListener('click', (e) => {
                e.stopPropagation();
                const fullText = messageDiv.querySelector('.chat-message-content').innerText;
                copyToClipboard(fullText, copyBtn);
            });
        }
        
        return { messageDiv, contentDiv: messageDiv.querySelector('.chat-message-content') };
    }
    
    async function addMessageToChat(role, content, saveToHistory = true) {
        const { messageDiv, contentDiv } = createMessageElement(role, content);
        
        if (welcomeMessage && chatHistory.length > 0 && role === 'user') {
            welcomeMessage.style.display = 'none';
        }
        
        chatMessagesContainer.appendChild(messageDiv);
        scrollToBottom();
        
        if (role === 'assistant') {
            await startTypingAnimation(content, contentDiv, messageDiv);
        } else {
            contentDiv.innerHTML = formatMessageContent(content);
        }
        
        if (saveToHistory) {
            chatHistory.push({
                role: role,
                content: content,
                timestamp: new Date().toISOString()
            });
            localStorage.setItem(CHAT_HISTORY_KEY, JSON.stringify(chatHistory));
        }
        
        scrollToBottom();
        return messageDiv;
    }
    
    function loadChatHistory() {
        if (currentTypingAnimation) {
            clearTimeout(currentTypingAnimation);
            isTypingActive = false;
        }
        
        while (chatMessagesContainer.firstChild) {
            chatMessagesContainer.removeChild(chatMessagesContainer.firstChild);
        }
        
        if (welcomeMessage) {
            welcomeMessage.style.display = 'block';
            chatMessagesContainer.appendChild(welcomeMessage);
        }
        
        chatHistory.forEach(item => {
            const { messageDiv, contentDiv } = createMessageElement(item.role, item.content);
            contentDiv.innerHTML = formatMessageContent(item.content);
            chatMessagesContainer.appendChild(messageDiv);
        });
        
        scrollToBottom();
    }
    
    function scrollToBottom() {
        setTimeout(() => {
            chatMessagesContainer.scrollTop = chatMessagesContainer.scrollHeight;
        }, 50);
    }
    
    function openConfirmModal() {
        confirmModal.classList.remove('hidden');
        setTimeout(() => {
            confirmModalContent.classList.remove('scale-95', 'opacity-0');
            confirmModalContent.classList.add('scale-100', 'opacity-100');
        }, 10);
    }
    
    function closeConfirmModal() {
        confirmModalContent.classList.remove('scale-100', 'opacity-100');
        confirmModalContent.classList.add('scale-95', 'opacity-0');
        setTimeout(() => {
            confirmModal.classList.add('hidden');
        }, 300);
    }
    
    if (confirmModal) {
        confirmModal.addEventListener('click', function(e) {
            if (e.target === confirmModal) closeConfirmModal();
        });
    }
    
    if (effacerHistoriqueBtn) {
        effacerHistoriqueBtn.addEventListener('click', openConfirmModal);
    }
    
    if (confirmEffacerBtn) {
        confirmEffacerBtn.addEventListener('click', function() {
            stopCurrentSpeaking();
            stopCurrentResponse();
            localStorage.removeItem(CHAT_HISTORY_KEY);
            chatHistory = [];
            loadChatHistory();
            closeConfirmModal();
            showNotification('Historique efface avec succes', 'success');
        });
    }
    
    if (chatForm) {
        chatForm.addEventListener('submit', async function(e) {
            e.preventDefault();
            
            if (isAwaitingResponse || isTypingActive) {
                stopCurrentResponse();
                return;
            }
            
            if (liveModeActive) {
                stopLiveMode();
            }
            
            const message = messageInput.value.trim();
            if (!message) return;
            
            if (isRecording) {
                stopRecordingAndSend();
                return;
            }
            
            await addMessageToChat('user', message);
            
            messageInput.value = '';
            adjustTextareaHeight();
            
            sendBtn.disabled = false;
            sendBtn.innerHTML = '<i class="fas fa-stop text-sm sm:text-base"></i>' + (window.innerWidth >= 640 ? '<span class="hidden sm:inline ml-2">Arreter</span>' : '');
            sendBtn.classList.add('stop-mode');
            
            typingIndicator.classList.remove('hidden');
            scrollToBottom();
            
            isAwaitingResponse = true;
            currentAbortController = new AbortController();
            
            const historiqueMessages = chatHistory.slice(-10).map(item => ({
                role: item.role === 'user' ? 'user' : 'assistant',
                content: item.content
            }));
            
            try {
                const response = await fetch('{{ route("chat.ai") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ 
                        message: message,
                        historique: historiqueMessages
                    }),
                    signal: currentAbortController.signal
                });
                
                const data = await response.json();
                typingIndicator.classList.add('hidden');
                
                if (data.status === 'success') {
                    await addMessageToChat('assistant', data.response);
                } else {
                    throw new Error(data.message || 'Erreur inconnue');
                }
            } catch (error) {
                if (error.name === 'AbortError') {
                    console.log('Requete annulee par l\'utilisateur');
                } else {
                    console.error('Erreur:', error);
                    typingIndicator.classList.add('hidden');
                    await addMessageToChat('assistant', 'Desole, une erreur est survenue. Effacer votre historique ou reessayer plus tard.');
                }
            } finally {
                sendBtn.disabled = false;
                sendBtn.innerHTML = '<i class="fas fa-paper-plane text-sm sm:text-base"></i>' + (window.innerWidth >= 640 ? '<span class="hidden sm:inline ml-2">Envoyer</span>' : '');
                sendBtn.classList.remove('stop-mode');
                isAwaitingResponse = false;
                currentAbortController = null;
            }
        });
    }
    
    if (messageInput) {
        messageInput.addEventListener('keydown', function(e) {
            if (e.key === 'Enter' && !e.shiftKey) {
                e.preventDefault();
                if (chatForm && !liveModeActive && !isAwaitingResponse && !isRecording) {
                    chatForm.dispatchEvent(new Event('submit'));
                }
            }
        });
        
        messageInput.addEventListener('input', adjustTextareaHeight);
    }
    
    function showNotification(message, type) {
        const notification = document.createElement('div');
        notification.className = `fixed top-4 right-4 z-50 px-3 sm:px-4 py-2 sm:py-3 rounded-lg shadow-xl transform transition-all duration-300 ${
            type === 'error' ? 'bg-red-600' : type === 'info' ? 'bg-blue-600' : 'bg-green-600'
        } text-white text-xs sm:text-sm`;
        notification.innerHTML = `<div class="flex items-center"><i class="fas ${type === 'error' ? 'fa-exclamation-circle' : type === 'info' ? 'fa-info-circle' : 'fa-check-circle'} mr-2"></i><span>${message}</span></div>`;
        document.body.appendChild(notification);
        setTimeout(() => {
            notification.style.opacity = '0';
            setTimeout(() => notification.remove(), 300);
        }, 3000);
    }
    
    adjustTextareaHeight();
    if (chatHistory.length > 0) loadChatHistory();
    
});

function showLoadingAndRedirect(event, url) {
    event.preventDefault();
    const loadingElement = document.getElementById("loading");
    if (loadingElement) loadingElement.style.display = "flex";
    setTimeout(() => window.location.href = url, 100);
}

// Fonctions globales pour la modale
function closeConfirmModal() {
    const modal = document.getElementById('confirmModal');
    const modalContent = document.getElementById('confirmModalContent');
    if (modal && modalContent) {
        modalContent.classList.remove('scale-100', 'opacity-100');
        modalContent.classList.add('scale-95', 'opacity-0');
        setTimeout(() => {
            if (modal) modal.classList.add('hidden');
        }, 300);
    }
}
</script>
@endsection