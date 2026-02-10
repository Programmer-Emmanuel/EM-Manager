@extends('dashboard_base')

@section('main')
<main class="flex-1 overflow-hidden relative bg-slate-900">
    <div class="absolute inset-0 overflow-y-auto hide-scroll p-2">
        <div class="min-h-screen flex items-center justify-center px-4 py-8">
            <div class="max-w-6xl w-full space-y-8 animate-fade-in">
                <!-- En-tête -->
                <div class="flex items-center justify-between" data-aos="fade-right">
                    <div class="flex items-center space-x-4">
                        <div class="p-3 bg-blue-500/20 rounded-full">
                            <div class="text-blue-400 text-3xl">
                                <i class="fas fa-credit-card"></i>
                            </div>
                        </div>
                        <div>
                            <h1 class="text-3xl font-bold text-white">Salaires des Employés</h1>
                            <p class="text-slate-400">Effectuez les paiements de salaire via KkiaPay</p>
                        </div>
                    </div>
                    <a href="{{ route('paiement.historique') }}" 
                       class="flex items-center space-x-2 bg-gradient-to-r from-slate-700 to-slate-600 hover:from-slate-600 hover:to-slate-500 text-white px-5 py-3 rounded-lg transition-all duration-300 shadow-lg hover:shadow-xl">
                        <i class="fas fa-history"></i>
                        <span>Voir l'historique</span>
                        <i class="fas fa-chevron-right ml-1 text-sm"></i>
                    </a>
                </div>

                <!-- Info solde -->
                <div class="bg-gradient-to-r from-blue-900/20 to-cyan-900/20 backdrop-blur-sm rounded-2xl p-8 border border-slate-700/50" data-aos="fade-up">
                    <div class="flex flex-col md:flex-row justify-between items-center">
                        <div class="text-center md:text-left mb-6 md:mb-0">
                            <h2 class="text-2xl font-semibold text-white mb-4">Solde disponible</h2>
                            <p class="text-5xl font-bold text-green-400">
                                {{ number_format($compte->montant, 0, ',', ' ') }} FCFA
                            </p>
                        </div>
                        <div class="text-center">
                            <p class="text-slate-400 mb-2">Prêt à effectuer vos paiements</p>
                            <div class="flex items-center justify-center gap-2">
                                <i class="fas fa-shield-alt text-green-400"></i>
                                <span class="text-sm text-slate-300">Paiements sécurisés via KkiaPay</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Liste des employés -->
                @if($employes->isNotEmpty())
                <div class="max-w-6xl mx-auto">
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 px-2">
                        @foreach($employes as $employe)
                        <div class="bg-slate-800/70 backdrop-blur-sm rounded-2xl p-6 border border-slate-700/50 
                                    hover:border-blue-500/30 transition-all duration-300
                                    transform hover:-translate-y-1 shadow-xl" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                            <div class="flex flex-col md:flex-row justify-between items-start mb-6">
                                <div class="mb-4 md:mb-0">
                                    <h3 class="text-2xl font-bold text-white mb-3">
                                        {{ $employe->prenom_employe }} {{ $employe->nom_employe }}
                                    </h3>
                                    <div class="space-y-2">
                                        <div class="flex items-center">
                                            <i class="fas fa-briefcase text-slate-400 mr-3 w-5"></i>
                                            <span class="text-slate-300">{{ $employe->poste }}</span>
                                        </div>
                                        <div class="flex items-center">
                                            <i class="fas fa-building text-slate-400 mr-3 w-5"></i>
                                            <span class="text-slate-300">{{ $employe->departement }}</span>
                                        </div>
                                        <div class="flex items-center">
                                            <i class="fas fa-money-bill-wave text-slate-400 mr-3 w-5"></i>
                                            <span class="text-green-400 font-semibold">
                                                {{ number_format($employe->salaire, 0, ',', ' ') }} FCFA
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="flex flex-col items-end">
                                    <span class="px-4 py-2 rounded-full text-sm font-medium mb-2
                                        @if($employe->deja_paye_ce_mois) 
                                            bg-green-900/30 text-green-400 border border-green-800/50
                                        @else 
                                            bg-yellow-900/30 text-yellow-400 border border-yellow-800/50
                                        @endif">
                                        @if($employe->deja_paye_ce_mois) 
                                            <i class="fas fa-check-circle mr-2"></i>Payé ce mois
                                        @else 
                                            <i class="fas fa-clock mr-2"></i>À payer
                                        @endif
                                    </span>
                                    <span class="text-sm text-slate-500">
                                        <i class="far fa-calendar-alt mr-2"></i>
                                        Dernier paiement: 
                                        {{ $employe->date_dernier_paiement ? $employe->date_dernier_paiement->format('d/m/Y') : 'Jamais' }}
                                    </span>
                                </div>
                            </div>

                            <!-- Formulaire de paiement -->
                            <div class="pt-6 border-t border-slate-700/50">
                                <form class="paiement-form" data-employe-id="{{ $employe->id }}">
                                    @csrf
                                    <div class="space-y-4">
                                        <div>
                                            <label class="block text-sm font-medium text-slate-400 mb-3">
                                                <i class="fas fa-coins mr-2"></i>Montant à payer (FCFA)
                                            </label>
                                            <input type="number" 
                                                   name="montant" 
                                                   value="{{ $employe->salaire }}"
                                                   class="w-full px-5 py-3 bg-slate-700/50 border-2 border-slate-600 
                                                          rounded-xl text-white text-lg
                                                          focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20
                                                          transition duration-200"
                                                   min="100" 
                                                   max="{{ $compte->montant }}"
                                                   required>
                                        </div>
                                        
                                        <button type="button"
                                                onclick="initierPaiement('{{ $employe->id }}')"
                                                class="w-full px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 
                                                       hover:from-blue-700 hover:to-blue-800 rounded-xl font-medium
                                                       transition-all duration-300 transform hover:scale-[1.02]
                                                       disabled:opacity-50 disabled:cursor-not-allowed
                                                       flex items-center justify-center gap-3
                                                       paiement-btn"
                                                data-employe-id="{{ $employe->id }}">
                                            <i class="fas fa-credit-card"></i>
                                            <span>Payer maintenant via KkiaPay</span>
                                        </button>
                                    </div>
                                    
                                    <div class="mt-4 text-center text-sm text-slate-500">
                                        <i class="fas fa-shield-alt mr-2"></i>
                                        Paiement sécurisé
                                    </div>
                                </form>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @else
                <div class="max-w-2xl mx-auto text-center py-16" data-aos="fade-up">
                    <div class="bg-slate-800/50 rounded-2xl p-12 border-2 border-dashed border-slate-700">
                        <i class="fas fa-user-check text-6xl text-green-500 mb-6"></i>
                        <h3 class="text-2xl font-bold text-white mb-4">Excellent travail !</h3>
                        <p class="text-slate-400 text-lg mb-8">Tous vos employés ont été payés ce mois-ci.</p>
                        <a href="{{ route('paiement.historique') }}" 
                           class="inline-flex items-center gap-3 px-6 py-3 bg-slate-700 hover:bg-slate-600 
                                  rounded-xl transition">
                            <i class="fas fa-history"></i>
                            Consulter l'historique
                        </a>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Modal confirmation -->
    <div id="confirmationModal" class="fixed inset-0 bg-black/80 hidden z-50 overflow-y-auto modal-container">
        <div class="min-h-full flex items-center justify-center p-4">
            <div class="bg-slate-800 backdrop-blur-sm rounded-2xl w-full max-w-md mx-auto border border-slate-700 
                        transform transition-all duration-300 scale-95 opacity-0
                        modal-content max-h-[90vh] overflow-hidden flex flex-col">
                <div class="flex-shrink-0 p-2 border-b border-slate-700/50 bg-slate-800/90">
                    <div class="text-center">
                        <div class="w-16 h-16 bg-blue-900/30 rounded-full flex items-center justify-center mx-auto">
                            <i class="fas fa-credit-card text-2xl text-blue-400"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-white mb-2">Confirmer le paiement</h3>
                        <p class="text-slate-400 text-sm">Veuillez vérifier les détails avant de continuer</p>
                    </div>
                </div>
                
                <div class="flex-1 overflow-y-auto p-6">
                    <div id="employeDetails" class="p-6 bg-slate-700/30 rounded-xl border border-slate-600">
                        <!-- Les détails seront injectés ici -->
                        <div class="animate-pulse space-y-4">
                            <div class="h-4 bg-slate-700 rounded w-3/4"></div>
                            <div class="h-4 bg-slate-700 rounded w-1/2"></div>
                        </div>
                    </div>
                    
                    <!-- Note info -->
                    <div class="mt-6 p-4 bg-blue-900/20 rounded-lg border border-blue-800/30">
                        <div class="flex items-start gap-3">
                            <i class="fas fa-info-circle text-blue-400 mt-1"></i>
                            <div class="text-sm text-slate-300">
                                <p class="font-medium mb-1">Mode Sandbox activé</p>
                                <p class="text-slate-400">Utilisez les numéros de test : MTN (61000000) ou MOOV (68000000)</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Boutons -->
                <div class="flex-shrink-0 p-6 border-t border-slate-700/50 bg-slate-800/90">
                    <div class="flex flex-col sm:flex-row gap-3 justify-end">
                        <button onclick="fermerModal()" 
                                class="px-5 py-3 bg-slate-700 hover:bg-slate-600 rounded-xl transition
                                       flex-1 sm:flex-none flex items-center justify-center">
                            <i class="fas fa-times mr-2"></i>
                            <span>Annuler</span>
                        </button>
                        <button onclick="ouvrirKkiaPay()" 
                                id="confirmPaiementBtn"
                                class="px-5 py-3 bg-gradient-to-r from-blue-600 to-blue-700 
                                       hover:from-blue-700 hover:to-blue-800 rounded-xl transition
                                       flex-1 sm:flex-none flex items-center justify-center">
                            <i class="fas fa-check mr-2"></i>
                            <span id="btnText">Confirmer et payer</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<!-- Script KkiaPay -->
<script src="https://cdn.kkiapay.me/k.js"></script>

<script>
let paiementData = null;
let employeEnCours = null;

function initierPaiement(employeId) {
    const form = document.querySelector(`form[data-employe-id="${employeId}"]`);
    const montantInput = form.querySelector('input[name="montant"]');
    const montant = parseFloat(montantInput.value);
    
    // Vérifier le montant
    if (montant < 100) {
        showNotification('Le montant minimum est de 100 FCFA', 'error');
        return;
    }
    
    if (montant > {{ $compte->montant }}) {
        showNotification('Solde insuffisant', 'error');
        return;
    }

    // Afficher le modal de confirmation
    fetch('/process-paiement', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            employe_id: employeId,
            montant: montant
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            paiementData = data.data;
            employeEnCours = employeId;
            
            // Mettre à jour le modal
            document.getElementById('employeDetails').innerHTML = `
                <div class="space-y-6">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-blue-900/30 rounded-xl flex items-center justify-center mr-4 flex-shrink-0">
                            <i class="fas fa-user text-blue-400 text-lg"></i>
                        </div>
                        <div class="flex-1">
                            <p class="text-slate-400 text-sm mb-1">Employé</p>
                            <p class="text-white font-semibold text-lg">${data.data.employe.prenom} ${data.data.employe.nom}</p>
                        </div>
                    </div>
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-green-900/30 rounded-xl flex items-center justify-center mr-4 flex-shrink-0">
                            <i class="fas fa-money-bill-wave text-green-400 text-lg"></i>
                        </div>
                        <div class="flex-1">
                            <p class="text-slate-400 text-sm mb-1">Montant</p>
                            <p class="text-3xl font-bold text-green-400">${data.data.montant.toLocaleString()} FCFA</p>
                        </div>
                    </div>
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-slate-700/50 rounded-xl flex items-center justify-center mr-4 flex-shrink-0">
                            <i class="fas fa-hashtag text-slate-300 text-lg"></i>
                        </div>
                        <div class="flex-1">
                            <p class="text-slate-400 text-sm mb-1">Référence</p>
                            <p class="text-white font-mono text-sm break-all">${data.data.reference}</p>
                        </div>
                    </div>
                </div>
            `;
            
            // Afficher le modal
            const modal = document.getElementById('confirmationModal');
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
            document.body.style.height = '100vh';
            
            setTimeout(() => {
                const modalContent = modal.querySelector('.modal-content');
                modalContent.classList.remove('scale-95', 'opacity-0');
                modalContent.classList.add('scale-100', 'opacity-100');
            }, 10);
            
        } else {
            showNotification(data.message || 'Erreur lors de la préparation du paiement', 'error');
        }
    })
    .catch(error => {
        console.error('Erreur:', error);
        showNotification('Une erreur est survenue', 'error');
    });
}

// Fonction simplifiée pour ouvrir KkiaPay
function ouvrirKkiaPay() {
    if (!paiementData) return;
    
    const btn = document.getElementById('confirmPaiementBtn');
    const btnText = document.getElementById('btnText');
    
    // Désactiver temporairement le bouton
    btn.disabled = true;
    btnText.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Ouverture...';
    
    // Fermer le modal
    fermerModal();
    
    // Utiliser la méthode directe de KkiaPay
    try {
        // Vérifier si Kkiapay est disponible
        if (typeof Kkiapay !== 'undefined') {
            Kkiapay.open({
    amount: paiementData.montant,
    key: paiementData.public_key,
    sandbox: true,

    name: "Paiement Salaire",
    description: "Paiement du salaire employé",

    callback: paiementData.callback,

    data: {
        reference: paiementData.reference,
        employe_id: paiementData.employe.id
    },

    position: 'center'
});

        } else {
            // Méthode de secours : rediriger vers une page de paiement
            showNotification('Redirection vers le paiement...', 'info');
            window.location.href = `https://kkiapay.me/pay?key=${paiementData.public_key}&amount=${paiementData.montant}&callback=${encodeURIComponent(paiementData.callback)}&sandbox=true`;
        }
    } catch (error) {
        console.error('Erreur KkiaPay:', error);
        showNotification('Erreur lors de l\'ouverture du paiement', 'error');
    } finally {
        // Réactiver le bouton après un délai
        setTimeout(() => {
            btn.disabled = false;
            btnText.innerHTML = '<i class="fas fa-check mr-2"></i> Confirmer et payer';
        }, 2000);
    }
}

function verifierStatutTransaction(transactionId) {
    // Vérifier toutes les 5 secondes pendant 2 minutes
    let attempts = 0;
    const maxAttempts = 24;
    
    const checkInterval = setInterval(() => {
        attempts++;
        
        fetch('/verifier-transaction', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ transaction_id: transactionId })
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                clearInterval(checkInterval);
                showNotification('Paiement confirmé avec succès !', 'success');
                
                const employeElement = document.querySelector(`.paiement-btn[data-employe-id="${employeEnCours}"]`);
                if (employeElement) {
                    employeElement.innerHTML = `
                        <i class="fas fa-check-circle"></i>
                        <span class="truncate">Payé avec succès</span>
                    `;
                    employeElement.classList.remove('from-blue-600', 'to-blue-700');
                    employeElement.classList.add('from-green-600', 'to-green-700');
                    employeElement.disabled = true;
                }
                
                // Rafraîchir la page après 3 secondes
                setTimeout(() => location.reload(), 3000);
            } else if (data.status === 'FAILED') {
                clearInterval(checkInterval);
                showNotification('Le paiement a échoué.', 'error');
                
                const employeElement = document.querySelector(`.paiement-btn[data-employe-id="${employeEnCours}"]`);
                if (employeElement) {
                    employeElement.disabled = false;
                    employeElement.innerHTML = `
                        <i class="fas fa-credit-card"></i>
                        <span>Payer maintenant via KkiaPay</span>
                    `;
                }
            }
        })
        .catch(error => {
            console.error('Erreur vérification:', error);
        });
        
        if (attempts >= maxAttempts) {
            clearInterval(checkInterval);
            showNotification('Temps de vérification écoulé. Vérifiez manuellement.', 'warning');
        }
    }, 5000); // Toutes les 5 secondes
}

function fermerModal() {
    const modal = document.getElementById('confirmationModal');
    const modalContent = modal.querySelector('.modal-content');
    
    modalContent.classList.remove('scale-100', 'opacity-100');
    modalContent.classList.add('scale-95', 'opacity-0');
    
    setTimeout(() => {
        modal.classList.add('hidden');
        document.body.style.overflow = '';
        document.body.style.height = '';
        
        const btn = document.getElementById('confirmPaiementBtn');
        const btnText = document.getElementById('btnText');
        btn.disabled = false;
        btnText.innerHTML = '<i class="fas fa-check mr-2"></i> Confirmer et payer';
        paiementData = null;
        employeEnCours = null;
    }, 300);
}

function showNotification(message, type) {
    const notification = document.createElement('div');
    notification.className = `fixed top-6 right-6 z-50 px-6 py-4 rounded-xl shadow-2xl 
        transform translate-x-full transition-transform duration-300
        ${type === 'error' ? 'bg-red-900/90 border border-red-700' : 
          type === 'warning' ? 'bg-yellow-900/90 border border-yellow-700' : 'bg-green-900/90 border border-green-700'}`;
    notification.innerHTML = `
        <div class="flex items-center gap-3">
            <i class="fas fa-${type === 'error' ? 'exclamation-circle' : 
                              type === 'warning' ? 'exclamation-triangle' : 'check-circle'} 
               text-${type === 'error' ? 'red' : 
                      type === 'warning' ? 'yellow' : 'green'}-400 text-xl"></i>
            <span class="text-white">${message}</span>
        </div>
    `;
    
    document.body.appendChild(notification);
    
    setTimeout(() => {
        notification.classList.remove('translate-x-full');
        notification.classList.add('translate-x-0');
    }, 10);
    
    setTimeout(() => {
        notification.classList.remove('translate-x-0');
        notification.classList.add('translate-x-full');
        setTimeout(() => notification.remove(), 300);
    }, 5000);
}

// Initialiser
document.addEventListener('DOMContentLoaded', function() {
    const style = document.createElement('style');
    style.textContent = `
        .hide-scroll { -ms-overflow-style: none; scrollbar-width: none; }
        .hide-scroll::-webkit-scrollbar { display: none; }
        
        .modal-container { -webkit-overflow-scrolling: touch; }
        .modal-content { max-height: calc(100vh - 2rem); }
        
        @media (max-width: 640px) {
            .modal-content { max-height: calc(100vh - 1rem); margin: 0.5rem; }
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in { animation: fadeIn 0.5s ease-out; }
    `;
    document.head.appendChild(style);
    
    document.getElementById('confirmationModal').addEventListener('click', function(e) {
        if (e.target === this) {
            fermerModal();
        }
    });
    
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            fermerModal();
        }
    });
});
</script>

<style>
@media (max-width: 640px) {
    .text-3xl { font-size: 1.875rem; }
    .text-5xl { font-size: 2.5rem; }
    button, .paiement-btn { min-height: 48px; }
    input { min-height: 48px; padding: 12px 16px; }
    .p-8 { padding: 1.5rem; }
    .p-6 { padding: 1.25rem; }
}

@supports (-webkit-touch-callout: none) {
    .min-h-screen, .h-screen {
        min-height: -webkit-fill-available;
        height: -webkit-fill-available;
    }
}
</style>
@endsection