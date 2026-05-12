@extends('dashboard_base')

@section('main')
<main class="flex-1 p-6 bg-slate-900 text-white overflow-hidden relative">
    <div class="absolute inset-0 overflow-y-auto hide-scroll p-2">
        <!-- Header avec titre -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 p-4 bg-slate-800 rounded-xl shadow-lg">
            <div>
                <h1 class="text-2xl font-bold text-white">Profil de l'entreprise</h1>
                <p class="text-slate-400 text-sm mt-1">Gérez les informations de votre entreprise</p>
            </div>
            <div class="mt-4 md:mt-0 flex gap-3">
                <button onclick="openEditModal()" 
                        id="openEditBtn"
                        class="bg-slate-700 hover:bg-slate-600 text-white px-4 py-2 rounded-lg flex items-center gap-2 transition-all duration-200">
                    <i class="fas fa-edit text-slate-300"></i>
                    <span>Modifier</span>
                </button>
                <button onclick="openPasswordModal()" 
                        id="openPasswordBtn"
                        class="bg-slate-700 hover:bg-slate-600 text-white px-4 py-2 rounded-lg flex items-center gap-2 transition-all duration-200">
                    <i class="fas fa-key text-slate-300"></i>
                    <span>Mot de passe</span>
                </button>
            </div>
        </div>

        <!-- Grille principale -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 p-4">
            <!-- Colonne gauche - Informations générales -->
            <div class="lg:col-span-2">
                <div class="bg-slate-800 rounded-xl shadow-lg overflow-hidden border border-slate-700">
                    <div class="px-6 py-4 border-b border-slate-700">
                        <h2 class="text-lg font-semibold text-white flex items-center gap-2">
                            <i class="fas fa-building text-slate-400"></i>
                            Informations générales
                        </h2>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-1">
                                <label class="block text-xs font-medium text-slate-400 uppercase tracking-wider">Nom de l'entreprise</label>
                                <p class="text-white font-medium" id="display_nom_entreprise">{{ $entrepriseDetails->nom_entreprise }}</p>
                            </div>
                            <div class="space-y-1">
                                <label class="block text-xs font-medium text-slate-400 uppercase tracking-wider">Matricule</label>
                                <div class="flex items-center gap-2">
                                    <p class="text-white font-mono text-sm">{{ $entrepriseDetails->matricule_entreprise }}</p>
                                    <button onclick="copyToClipboard('{{ $entrepriseDetails->matricule_entreprise }}')" 
                                            class="text-slate-500 hover:text-slate-300 transition-colors">
                                        <i class="fas fa-copy text-xs"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="space-y-1">
                                <label class="block text-xs font-medium text-slate-400 uppercase tracking-wider">Email</label>
                                <p class="text-white" id="display_email_entreprise">{{ $entrepriseDetails->email_entreprise }}</p>
                            </div>
                            <div class="space-y-1">
                                <label class="block text-xs font-medium text-slate-400 uppercase tracking-wider">Téléphone</label>
                                <p class="text-white" id="display_telephone_entreprise">{{ $entrepriseDetails->telephone_entreprise }}</p>
                            </div>
                            <div class="space-y-1">
                                <label class="block text-xs font-medium text-slate-400 uppercase tracking-wider">Directeur</label>
                                <p class="text-white" id="display_nom_directeur">{{ $entrepriseDetails->prenom_directeur }} {{ $entrepriseDetails->nom_directeur }}</p>
                            </div>
                            <div class="space-y-1">
                                <label class="block text-xs font-medium text-slate-400 uppercase tracking-wider">Date d'inscription</label>
                                <p class="text-white">{{ \Carbon\Carbon::parse($entrepriseDetails->created_at)->format('d/m/Y') }}</p>
                            </div>
                            <!-- <div class="space-y-1">
                                <label class="block text-xs font-medium text-slate-400 uppercase tracking-wider">Statut</label>
                                <span class="inline-flex items-center px-2 py-1 rounded-lg text-xs font-medium
                                    {{ $entrepriseDetails->is_active ? 'bg-slate-700 text-slate-300' : 'bg-slate-700/50 text-slate-500' }}">
                                    <i class="fas fa-circle text-[6px] mr-2"></i>
                                    {{ $entrepriseDetails->is_active ? 'Actif' : 'Inactif' }}
                                </span>
                            </div> -->
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Colonne droite - Carte abonnement -->
            <div>
                <div class="bg-slate-800 rounded-xl shadow-lg overflow-hidden border border-slate-700">
                    <div class="px-6 py-4 border-b border-slate-700">
                        <h3 class="text-lg font-semibold text-white flex items-center gap-2">
                            <i class="fas fa-calendar-alt text-slate-400"></i>
                            Abonnement
                        </h3>
                    </div>
                    <div class="p-6">
                        @if($entrepriseDetails->fin_abonnement)
                            @php
                                $finAbonnement = \Carbon\Carbon::parse($entrepriseDetails->fin_abonnement);
                                $aujourdhui = \Carbon\Carbon::now();
                                $estExpire = $finAbonnement->isPast();
                                $joursRestants = $aujourdhui->diffInDays($finAbonnement, false);
                                $joursRestantsAbs = abs($joursRestants);
                            @endphp
                            
                            <div class="text-center">
                                <div class="text-2xl font-bold text-white mb-1">
                                    {{ $finAbonnement->format('d/m/Y') }}
                                </div>
                                <p class="text-slate-500 text-xs uppercase tracking-wider mb-4">Date de fin</p>
                                
                                @if(!$estExpire)
                                    <div class="mt-2 p-3 bg-slate-700/30 rounded-lg">
                                        <p class="text-slate-300 text-sm">
                                            <i class="fas fa-hourglass-half mr-2 text-slate-400"></i>
                                            Encore {{ $joursRestantsAbs }} jour(s)
                                        </p>
                                    </div>
                                @else
                                    <div class="mt-2 p-3 bg-slate-700/30 rounded-lg">
                                        <p class="text-slate-400 text-sm">
                                            <i class="fas fa-clock mr-2"></i>
                                            Expiré depuis {{ $joursRestantsAbs }} jour(s)
                                        </p>
                                    </div>
                                @endif
                            </div>
                        @else
                            <div class="text-center">
                                <i class="fas fa-clock text-3xl text-slate-600 mb-3 block"></i>
                                <p class="text-slate-500 text-sm">Aucun abonnement actif</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<!-- MODALE : Modifier les informations -->
<div id="editModal" class="fixed inset-0 bg-black/80 backdrop-blur-sm flex items-center justify-center z-50 hidden">
    <div class="bg-slate-800 rounded-xl w-full max-w-2xl mx-4 shadow-2xl border border-slate-700">
        <div class="px-6 py-4 border-b border-slate-700 flex justify-between items-center">
            <h2 class="text-lg font-semibold text-white flex items-center gap-2">
                <i class="fas fa-edit text-slate-400"></i>
                Modifier les informations
            </h2>
            <button onclick="closeEditModal()" class="text-slate-400 hover:text-slate-300 transition-colors">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <form id="editForm" method="POST" class="p-6 space-y-5">
            @csrf
            @method('PUT')
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label for="edit_nom_entreprise" class="block text-sm font-medium text-slate-300 mb-2">
                        Nom de l'entreprise
                    </label>
                    <input type="text" id="edit_nom_entreprise" name="nom_entreprise" 
                           value="{{ $entrepriseDetails->nom_entreprise }}"
                           class="w-full px-4 py-2 rounded-lg bg-slate-700 border border-slate-600 text-white focus:ring-2 focus:ring-slate-500 focus:border-transparent">
                </div>
                <div>
                    <label for="edit_email_entreprise" class="block text-sm font-medium text-slate-300 mb-2">
                        Email
                    </label>
                    <input type="email" id="edit_email_entreprise" name="email_entreprise" 
                           value="{{ $entrepriseDetails->email_entreprise }}"
                           class="w-full px-4 py-2 rounded-lg bg-slate-700 border border-slate-600 text-white focus:ring-2 focus:ring-slate-500 focus:border-transparent">
                </div>
                <div>
                    <label for="edit_telephone_entreprise" class="block text-sm font-medium text-slate-300 mb-2">
                        Téléphone
                    </label>
                    <input type="tel" id="edit_telephone_entreprise" name="telephone_entreprise" 
                           value="{{ $entrepriseDetails->telephone_entreprise }}"
                           class="w-full px-4 py-2 rounded-lg bg-slate-700 border border-slate-600 text-white focus:ring-2 focus:ring-slate-500 focus:border-transparent">
                </div>
                <div>
                    <label for="edit_nom_directeur" class="block text-sm font-medium text-slate-300 mb-2">
                        Nom du directeur
                    </label>
                    <input type="text" id="edit_nom_directeur" name="nom_directeur" 
                           value="{{ $entrepriseDetails->nom_directeur }}"
                           class="w-full px-4 py-2 rounded-lg bg-slate-700 border border-slate-600 text-white focus:ring-2 focus:ring-slate-500 focus:border-transparent">
                </div>
                <div>
                    <label for="edit_prenom_directeur" class="block text-sm font-medium text-slate-300 mb-2">
                        Prénom du directeur
                    </label>
                    <input type="text" id="edit_prenom_directeur" name="prenom_directeur" 
                           value="{{ $entrepriseDetails->prenom_directeur }}"
                           class="w-full px-4 py-2 rounded-lg bg-slate-700 border border-slate-600 text-white focus:ring-2 focus:ring-slate-500 focus:border-transparent">
                </div>
            </div>
            <div class="flex justify-end gap-3 pt-4">
                <button type="button" onclick="closeEditModal()" 
                        id="editCancelBtn"
                        class="px-4 py-2 bg-slate-700 hover:bg-slate-600 text-white rounded-lg transition-colors">
                    Annuler
                </button>
                <button type="submit" 
                        id="editSubmitBtn"
                        class="px-6 py-2 bg-slate-600 hover:bg-slate-500 text-white rounded-lg flex items-center gap-2 transition-colors">
                    <i class="fas fa-save"></i>
                    <span>Enregistrer</span>
                </button>
            </div>
        </form>
    </div>
</div>

<!-- MODALE : Changer le mot de passe -->
<div id="passwordModal" class="fixed inset-0 bg-black/80 backdrop-blur-sm flex items-center justify-center z-50 hidden">
    <div class="bg-slate-800 rounded-xl w-full max-w-md mx-4 shadow-2xl border border-slate-700">
        <div class="px-6 py-4 border-b border-slate-700 flex justify-between items-center">
            <h2 class="text-lg font-semibold text-white flex items-center gap-2">
                <i class="fas fa-key text-slate-400"></i>
                Changer le mot de passe
            </h2>
            <button onclick="closePasswordModal()" class="text-slate-400 hover:text-slate-300 transition-colors">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <form id="passwordForm" method="POST" class="p-6 space-y-5">
            @csrf
            @method('PUT')
            <div>
                <label for="current_password" class="block text-sm font-medium text-slate-300 mb-2">
                    Mot de passe actuel
                </label>
                <input type="password" id="current_password" name="current_password" 
                       class="w-full px-4 py-2 rounded-lg bg-slate-700 border border-slate-600 text-white focus:ring-2 focus:ring-slate-500 focus:border-transparent">
            </div>
            <div>
                <label for="new_password" class="block text-sm font-medium text-slate-300 mb-2">
                    Nouveau mot de passe
                </label>
                <input type="password" id="new_password" name="new_password" 
                       class="w-full px-4 py-2 rounded-lg bg-slate-700 border border-slate-600 text-white focus:ring-2 focus:ring-slate-500 focus:border-transparent">
                <p class="text-xs text-slate-500 mt-1">Minimum 6 caractères</p>
            </div>
            <div>
                <label for="new_password_confirmation" class="block text-sm font-medium text-slate-300 mb-2">
                    Confirmer le nouveau mot de passe
                </label>
                <input type="password" id="new_password_confirmation" name="new_password_confirmation" 
                       class="w-full px-4 py-2 rounded-lg bg-slate-700 border border-slate-600 text-white focus:ring-2 focus:ring-slate-500 focus:border-transparent">
            </div>
            <div class="flex justify-end gap-3 pt-4">
                <button type="button" onclick="closePasswordModal()" 
                        id="passwordCancelBtn"
                        class="px-4 py-2 bg-slate-700 hover:bg-slate-600 text-white rounded-lg transition-colors">
                    Annuler
                </button>
                <button type="submit" 
                        id="passwordSubmitBtn"
                        class="px-6 py-2 bg-slate-600 hover:bg-slate-500 text-white rounded-lg flex items-center gap-2 transition-colors">
                    <i class="fas fa-lock"></i>
                    <span>Modifier</span>
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    // Variables pour suivre l'état des requêtes
    let isEditSubmitting = false;
    let isPasswordSubmitting = false;
    
    // Fonctions pour fermer les modales avec rechargement
    function forceCloseEditModalAndReload() {
        document.getElementById('editModal').classList.add('hidden');
        document.getElementById('editForm').reset();
        // Recharger la page
        window.location.reload();
    }
    
    function forceClosePasswordModalAndReload() {
        document.getElementById('passwordModal').classList.add('hidden');
        document.getElementById('passwordForm').reset();
        // Recharger la page
        window.location.reload();
    }
    
    function forceCloseEditModal() {
        document.getElementById('editModal').classList.add('hidden');
        document.getElementById('editForm').reset();
    }
    
    function forceClosePasswordModal() {
        document.getElementById('passwordModal').classList.add('hidden');
        document.getElementById('passwordForm').reset();
    }
    
    // Fonctions publiques avec vérification
    function closeEditModal() {
        if (!isEditSubmitting) {
            forceCloseEditModal();
        }
    }
    
    function closePasswordModal() {
        if (!isPasswordSubmitting) {
            forceClosePasswordModal();
        }
    }
    
    function openEditModal() {
        if (!isEditSubmitting) {
            document.getElementById('editModal').classList.remove('hidden');
        }
    }
    
    function openPasswordModal() {
        if (!isPasswordSubmitting) {
            document.getElementById('passwordModal').classList.remove('hidden');
        }
    }
    
    // Fermer les modales en cliquant à l'extérieur
    document.getElementById('editModal').addEventListener('click', function(e) {
        if (e.target === this && !isEditSubmitting) forceCloseEditModal();
    });
    
    document.getElementById('passwordModal').addEventListener('click', function(e) {
        if (e.target === this && !isPasswordSubmitting) forceClosePasswordModal();
    });
    
    // Copier le matricule
    function copyToClipboard(text) {
        navigator.clipboard.writeText(text).then(function() {
            const btn = event.target.closest('button');
            const originalIcon = btn.innerHTML;
            btn.innerHTML = '<i class="fas fa-check text-slate-400"></i>';
            setTimeout(() => {
                btn.innerHTML = originalIcon;
            }, 2000);
        });
    }
    
    // Fonction pour afficher l'état de chargement sur un bouton
    function setButtonLoading(button, isLoading, originalText, originalIcon) {
        if (isLoading) {
            button.disabled = true;
            button.innerHTML = `
                <svg class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                </svg>
                <span>${originalText}...</span>
            `;
            button.classList.add('opacity-70', 'cursor-not-allowed');
        } else {
            button.disabled = false;
            button.innerHTML = `${originalIcon}<span>${originalText}</span>`;
            button.classList.remove('opacity-70', 'cursor-not-allowed');
        }
    }
    
    // Soumission du formulaire de modification
    document.getElementById('editForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        if (isEditSubmitting) return false;
        
        const submitBtn = document.getElementById('editSubmitBtn');
        const cancelBtn = document.getElementById('editCancelBtn');
        const originalBtnText = 'Enregistrer';
        const originalBtnIcon = '<i class="fas fa-save"></i>';
        
        isEditSubmitting = true;
        setButtonLoading(submitBtn, true, originalBtnText, originalBtnIcon);
        cancelBtn.disabled = true;
        cancelBtn.classList.add('opacity-50', 'cursor-not-allowed');
        
        const form = this;
        const formData = new FormData(form);
        
        fetch('{{ route("entreprise.update_profil") }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Fermer la modale et recharger la page
                forceCloseEditModalAndReload();
            } else {
                showNotification(data.message, 'error');
                isEditSubmitting = false;
                setButtonLoading(submitBtn, false, originalBtnText, originalBtnIcon);
                cancelBtn.disabled = false;
                cancelBtn.classList.remove('opacity-50', 'cursor-not-allowed');
            }
        })
        .catch(error => {
            showNotification('Une erreur est survenue', 'error');
            isEditSubmitting = false;
            setButtonLoading(submitBtn, false, originalBtnText, originalBtnIcon);
            cancelBtn.disabled = false;
            cancelBtn.classList.remove('opacity-50', 'cursor-not-allowed');
        });
    });
    
    // Soumission du formulaire de mot de passe
    document.getElementById('passwordForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        if (isPasswordSubmitting) return false;
        
        const submitBtn = document.getElementById('passwordSubmitBtn');
        const cancelBtn = document.getElementById('passwordCancelBtn');
        const originalBtnText = 'Modifier';
        const originalBtnIcon = '<i class="fas fa-lock"></i>';
        
        isPasswordSubmitting = true;
        setButtonLoading(submitBtn, true, originalBtnText, originalBtnIcon);
        cancelBtn.disabled = true;
        cancelBtn.classList.add('opacity-50', 'cursor-not-allowed');
        
        const form = this;
        const formData = new FormData(form);
        
        fetch('{{ route("entreprise.update_password") }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Fermer la modale et recharger la page
                forceClosePasswordModalAndReload();
            } else {
                showNotification(data.message, 'error');
                isPasswordSubmitting = false;
                setButtonLoading(submitBtn, false, originalBtnText, originalBtnIcon);
                cancelBtn.disabled = false;
                cancelBtn.classList.remove('opacity-50', 'cursor-not-allowed');
            }
        })
        .catch(error => {
            showNotification('Une erreur est survenue', 'error');
            isPasswordSubmitting = false;
            setButtonLoading(submitBtn, false, originalBtnText, originalBtnIcon);
            cancelBtn.disabled = false;
            cancelBtn.classList.remove('opacity-50', 'cursor-not-allowed');
        });
    });
    
    // Afficher une notification
    function showNotification(message, type) {
        const notification = document.createElement('div');
        notification.className = `fixed bottom-4 right-4 z-50 px-4 py-3 rounded-lg shadow-lg transition-all duration-300 bg-slate-700 text-slate-300 flex items-center gap-2 border border-slate-600`;
        notification.innerHTML = `
            <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-circle'} text-slate-400"></i>
            <span class="text-sm">${message}</span>
        `;
        document.body.appendChild(notification);
        
        setTimeout(() => {
            notification.style.opacity = '0';
            setTimeout(() => notification.remove(), 300);
        }, 3000);
    }
    
    // Empêcher la fermeture de la modale pendant le chargement
    window.addEventListener('beforeunload', function() {
        if (isEditSubmitting || isPasswordSubmitting) {
            return 'Une action est en cours. Voulez-vous vraiment quitter ?';
        }
    });
</script>
@endsection