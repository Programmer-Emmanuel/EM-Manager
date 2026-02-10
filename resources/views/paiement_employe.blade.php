@extends('dashboard_base')

@section('main')
<main class="flex-1 bg-slate-900 mt-15">
    <div class="p-4">
        <div class="max-w-6xl mx-auto space-y-6">
            <!-- En-tête simple -->
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-2xl font-bold text-white">Paiement des salaires</h1>
                    <p class="text-slate-400">Payez vos employés via KkiaPay</p>
                </div>
                <a href="{{ route('paiement.historique') }}" class="text-blue-400 hover:text-blue-300">
                    <i class="fas fa-history mr-2"></i>Historique
                </a>
            </div>

            <!-- Solde -->
            <div class="bg-slate-800 p-4 rounded-lg">
                <p class="text-slate-400 mb-1">Solde disponible</p>
                <p class="text-3xl font-bold text-green-400">
                    {{ number_format($compte->montant, 0, ',', ' ') }} FCFA
                </p>
                <p class="text-slate-500 text-sm mt-2">
                    <i class="fas fa-info-circle mr-1"></i>
                    Mode test: MTN 61000000 | MOOV 68000000
                </p>
            </div>

            <!-- Tableau simplifié -->
            @if($employes->isNotEmpty())
            <div class="bg-slate-800 rounded-lg overflow-hidden">
                <table class="w-full">
                    <thead class="bg-slate-900">
                        <tr>
                            <th class="py-3 px-4 text-left text-slate-400">Employé</th>
                            <th class="py-3 px-4 text-left text-slate-400">Salaire</th>
                            <th class="py-3 px-4 text-left text-slate-400">Statut</th>
                            <th class="py-3 px-4 text-left text-slate-400">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($employes as $employe)
                        <tr class="border-t border-slate-700 hover:bg-slate-700/30">
                            <td class="py-3 px-4">
                                <div>
                                    <p class="font-medium text-white">{{ $employe->prenom_employe }} {{ $employe->nom_employe }}</p>
                                    <p class="text-sm text-slate-500">{{ $employe->poste }}</p>
                                </div>
                            </td>
                            <td class="py-3 px-4">
                                <p class="text-green-400 font-medium">
                                    {{ number_format($employe->salaire, 0, ',', ' ') }} FCFA
                                </p>
                            </td>
                            <td class="py-3 px-4">
                                @if($employe->deja_paye_ce_mois)
                                <span class="text-green-400 text-sm">
                                    <i class="fas fa-check-circle mr-1"></i>Payé
                                </span>
                                @else
                                <span class="text-yellow-400 text-sm">
                                    <i class="fas fa-clock mr-1"></i>À payer
                                </span>
                                @endif
                            </td>
                            <td class="py-3 px-4">
                                <form class="paiement-form inline-block" data-employe-id="{{ $employe->id }}">
                                    @csrf
                                    <input type="hidden" name="montant" value="{{ $employe->salaire }}">
                                </form>
                                <button type="button"
                                        onclick="initierPaiement('{{ $employe->id }}')"
                                        class="px-4 py-2 bg-blue-600 hover:bg-blue-700 rounded text-sm
                                               disabled:opacity-50 disabled:cursor-not-allowed paiement-btn"
                                        data-employe-id="{{ $employe->id }}"
                                        @if($employe->deja_paye_ce_mois) disabled @endif>
                                    <i class="fas fa-credit-card mr-2"></i>Payer
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <div class="text-center py-12">
                <div class="bg-slate-800/50 rounded-lg p-8">
                    <i class="fas fa-user-check text-4xl text-green-500 mb-4"></i>
                    <h3 class="text-lg font-bold text-white mb-2">Tous les salaires sont payés</h3>
                    <p class="text-slate-400">Aucun employé à payer ce mois-ci.</p>
                </div>
            </div>
            @endif
        </div>
    </div>

    <!-- Modal avec la logique complète -->
    <div id="confirmationModal" class="fixed inset-0 bg-black/80 hidden z-50 overflow-y-auto modal-container mt-15">
        <div class="min-h-full flex items-center justify-center p-4">
            <div class="bg-slate-800 rounded-2xl w-full max-w-md mx-auto border border-slate-700 
                        transform transition-all duration-300 scale-95 opacity-0
                        modal-content max-h-[90vh] overflow-hidden flex flex-col">
                <div class="flex-shrink-0 p-2 border-b border-slate-700/50 bg-slate-800/90">
                    <div class="text-center">
                        <div class="w-16 h-16 bg-blue-900/30 rounded-full flex items-center justify-center mx-auto">
                            <i class="fas fa-credit-card text-2xl text-blue-400"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-white mb-2">Confirmer le paiement</h3>
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

<!-- Script KkiaPay - IMPORTANT: Doit être placé avant la fermeture de </body> -->
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
                            <p class="text-lg font-bold text-green-400">${data.data.montant.toLocaleString()} FCFA</p>
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

// Fonction CORRIGÉE pour ouvrir KkiaPay selon la documentation
function ouvrirKkiaPay() {
    if (!paiementData) return;
    
    const btn = document.getElementById('confirmPaiementBtn');
    const btnText = document.getElementById('btnText');
    
    // Désactiver temporairement le bouton
    btn.disabled = true;
    btnText.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Ouverture...';
    
    // Fermer le modal
    fermerModal();
    
    // Configurer les listeners AVANT d'ouvrir le widget
    try {
        // Vérifier si la fonction openKkiapayWidget existe (selon la documentation)
        if (typeof openKkiapayWidget === 'undefined') {
            showNotification('Erreur: SDK KkiaPay non chargé', 'error');
            btn.disabled = false;
            btnText.innerHTML = '<i class="fas fa-check mr-2"></i> Confirmer et payer';
            return;
        }
        
        // Configurer les listeners d'événements
        if (typeof addSuccessListener !== 'undefined') {
            addSuccessListener(function(response) {
                console.log('Paiement réussi:', response);
                showNotification('Paiement effectué avec succès !', 'success');
                traiterPaiementReussi(response);
            });
        }
        
        if (typeof addFailedListener !== 'undefined') {
            addFailedListener(function(error) {
                console.log('Paiement échoué:', error);
                showNotification('Le paiement a échoué', 'error');
                
                // Réactiver le bouton de paiement
                const btnElement = document.querySelector(`.paiement-btn[data-employe-id="${employeEnCours}"]`);
                if (btnElement) {
                    btnElement.disabled = false;
                    btnElement.innerHTML = `
                        <i class="fas fa-credit-card mr-2"></i>Payer
                    `;
                }
            });
        }
        
        // Ouvrir le widget KkiaPay avec les paramètres CORRECTS selon la documentation
        openKkiapayWidget({
            amount: paiementData.montant.toString(),
            key: paiementData.public_key,
            position: "right",
            sandbox: true,
            name: paiementData.employe.nom + " " + paiementData.employe.prenom,
            email: paiementData.employe.email || "",
            phone: paiementData.employe.telephone || "",
            callback: paiementData.callback,
            data: JSON.stringify({
                reference: paiementData.reference,
                employe_id: paiementData.employe.id,
                type: "salaire"
            }),
            theme: "#0095ff" // Optionnel: couleur du widget
        });
        
    } catch (error) {
        console.error('Erreur KkiaPay:', error);
        showNotification('Erreur lors de l\'ouverture du paiement', 'error');
        
        // Réactiver le bouton
        btn.disabled = false;
        btnText.innerHTML = '<i class="fas fa-check mr-2"></i> Confirmer et payer';
    }
}

// Fonction pour traiter un paiement réussi
function traiterPaiementReussi(response) {
    console.log('Transaction ID:', response.transactionId || response.id);
    
    // Mettre à jour l'interface utilisateur
    const employeElement = document.querySelector(`.paiement-btn[data-employe-id="${employeEnCours}"]`);
    if (employeElement) {
        employeElement.innerHTML = `
            <i class="fas fa-check-circle mr-2"></i>Payé
        `;
        employeElement.classList.remove('bg-blue-600', 'hover:bg-blue-700');
        employeElement.classList.add('bg-green-600');
        employeElement.disabled = true;
    }
    
    // Vérifier le statut de la transaction côté serveur
    if (response.transactionId) {
        verifierStatutTransaction(response.transactionId);
    } else {
        // Rafraîchir la page après 3 secondes si pas d'ID de transaction
        setTimeout(() => location.reload(), 3000);
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
            if (data.status === 'success' || data.status === 'SUCCESS') {
                clearInterval(checkInterval);
                showNotification('Paiement confirmé avec succès !', 'success');
                
                // Rafraîchir la page après 3 secondes
                setTimeout(() => location.reload(), 3000);
            } else if (data.status === 'FAILED' || data.status === 'failed') {
                clearInterval(checkInterval);
                showNotification('Le paiement a échoué.', 'error');
                
                const employeElement = document.querySelector(`.paiement-btn[data-employe-id="${employeEnCours}"]`);
                if (employeElement) {
                    employeElement.disabled = false;
                    employeElement.innerHTML = `
                        <i class="fas fa-credit-card mr-2"></i>Payer
                    `;
                    employeElement.classList.remove('bg-green-600');
                    employeElement.classList.add('bg-blue-600', 'hover:bg-blue-700');
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
        btnText.innerHTML = 'Confirmer et payer';
        paiementData = null;
        employeEnCours = null;
    }, 300);
}

function showNotification(message, type) {
    const notification = document.createElement('div');
    notification.className = `fixed top-6 right-6 z-50 px-6 py-4 rounded-xl shadow-2xl mt-15
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
        .modal-container { -webkit-overflow-scrolling: touch; }
        .modal-content { max-height: calc(100vh - 2rem); }
        
        @media (max-width: 640px) {
            .modal-content { max-height: calc(100vh - 1rem); margin: 0.5rem; }
        }
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
@endsection