{{-- resources/views/liste_employe.blade.php --}}
@extends('dashboard_base')

@section('main')
<main class="flex-1 p-6 bg-slate-900 text-white overflow-hidden relative">
    <div class="absolute inset-0 overflow-y-auto hide-scroll p-2">
        <!-- Header avec titre et boutons d'action -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 p-4 bg-slate-800 rounded-lg shadow">
            <div class="mb-4 md:mb-0">
                <h1 class="text-2xl font-bold text-white">Gestion des Employés</h1>
                <p class="text-slate-400">Gérez efficacement votre équipe</p>
            </div>
            <div class="flex flex-col sm:flex-row gap-3 w-full md:w-auto">
                <a href="{{ route('ajout_employe') }}" 
                   class="bg-slate-600 hover:bg-slate-700 text-white px-4 py-2 rounded-lg flex items-center justify-center gap-2 transition-colors">
                    <i class="fas fa-user-plus"></i>
                </a>
                <a href="{{ route('export_employe') }}" 
                   class="bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2 rounded-lg flex items-center justify-center gap-2 transition-colors">
                    <i class="fas fa-file-export"></i>
                </a>
            </div>
        </div>

        <!-- Barre de recherche -->
        <div class="mb-6 mx-6">
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fas fa-search text-slate-400"></i>
                </div>
                <input type="text" 
                       id="searchInput" 
                       placeholder="Rechercher par matricule, nom ou email..." 
                       class="w-full pl-10 pr-4 py-2 bg-slate-700 border border-slate-600 rounded-lg text-white placeholder-slate-400 focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-colors">
            </div>
            <div class="mt-2 text-xs text-slate-400">
                <span id="resultCount">{{ $employes->count() }}</span> employé(s) trouvé(s)
            </div>
        </div>

        <!-- Tableau des employés -->
        <div class="bg-slate-800 rounded-xl shadow-lg overflow-hidden m-6">
            <div class="overflow-x-auto hide-scroll">
                <table class="w-full">
                    <thead class="bg-slate-700 text-slate-300">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Nom complet</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Matricule</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Poste</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Département</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Contact</th>
                            <th class="px-6 py-3 text-right text-xs font-medium uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="employesTableBody" class="divide-y divide-slate-700">
                        @foreach($employes as $employe)
                        <tr class="hover:bg-slate-750 transition-colors cursor-pointer employe-row" data-employe='{{ json_encode($employe) }}'>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10 bg-slate-600 rounded-full flex items-center justify-center">
                                        <span class="text-sm font-medium">{{ substr($employe->prenom_employe, 0, 1) }}{{ substr($employe->nom_employe, 0, 1) }}</span>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium employe-name">{{ $employe->prenom_employe }} {{ $employe->nom_employe }}</div>
                                        <div class="text-xs text-slate-400 employe-email">{{ $employe->email_employe }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm employe-matricule">{{ $employe->matricule_employe }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $employe->poste }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $employe->departement }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <div class="text-sm">{{ $employe->telephone }}</div>
                                <div class="text-xs text-slate-400">{{ $employe->email_employe }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex justify-end space-x-3" onclick="event.stopPropagation()">
                                    <button onclick="showEmployeDetails({{ json_encode($employe) }})" 
                                            class="text-indigo-400 hover:text-indigo-300 transition-colors"
                                            title="Voir détails">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <a href="{{ route('edit_employe', $employe->id) }}" 
                                       class="text-blue-400 hover:text-blue-300 transition-colors"
                                       title="Modifier">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button type="button" 
                                            onclick="openDeleteModal('{{ $employe->id }}', '{{ addslashes($employe->prenom_employe . ' ' . $employe->nom_employe) }}')"
                                            class="text-red-400 hover:text-red-300 transition-colors"
                                            title="Supprimer">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>

<!-- MODALE DÉTAILS EMPLOYÉ -->
<div id="detailsModal" class="fixed inset-0 bg-black/70 backdrop-blur-sm flex items-center justify-center z-50 hidden transition-all duration-300">
    <div class="bg-slate-800 rounded-xl w-full max-w-2xl mx-4 shadow-2xl border border-slate-700 transform transition-all duration-300 scale-95 opacity-0 max-h-[75vh] overflow-hidden flex flex-col" id="detailsModalContent">
        <div class="px-5 py-3 border-b border-slate-700 flex justify-between items-center bg-slate-800/95 sticky top-0 z-10">
            <h2 class="text-lg font-semibold text-white flex items-center gap-2">
                <i class="fas fa-user-circle text-indigo-400"></i>
                Détails de l'employé
            </h2>
            <button onclick="closeDetailsModal()" class="text-slate-400 hover:text-slate-300 transition-colors">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>
        
        <div class="overflow-y-auto p-5" id="detailsModalBody">
            <div id="detailsContent"></div>
        </div>
        
        <div class="px-5 py-3 border-t border-slate-700 flex justify-end gap-3 bg-slate-800/95 sticky bottom-0">
            <a href="#" id="modalEditLink" class="px-4 py-2 bg-blue-700 hover:bg-blue-600 text-white rounded-lg transition-colors text-sm">
                Modifier
            </a>
            <button id="modalDeleteBtn" class="px-4 py-2 bg-red-700 hover:bg-red-600 text-white rounded-lg transition-colors text-sm">
                Supprimer
            </button>
            <button onclick="closeDetailsModal()" class="px-4 py-2 bg-slate-700 hover:bg-slate-600 text-white rounded-lg transition-colors text-sm">
                Fermer
            </button>
        </div>
    </div>
</div>

<!-- MODALE DE CONFIRMATION DE SUPPRESSION -->
<div id="deleteModal" class="fixed inset-0 bg-black/70 backdrop-blur-sm flex items-center justify-center z-50 hidden transition-all duration-300">
    <div class="bg-slate-800 rounded-xl w-full max-w-md mx-4 shadow-2xl border border-slate-700 transform transition-all duration-300 scale-95 opacity-0" id="deleteModalContent">
        <div class="px-5 py-3 border-b border-slate-700 flex justify-between items-center">
            <h2 class="text-base font-semibold text-white flex items-center gap-2">
                <i class="fas fa-trash-alt text-red-400"></i>
                Confirmer la suppression
            </h2>
            <button onclick="closeDeleteModal()" class="text-slate-400 hover:text-slate-300 transition-colors">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="p-5">
            <p class="text-slate-300 text-sm mb-2">
                Êtes-vous sûr de vouloir supprimer l'employé <strong id="employeName" class="text-red-400"></strong> ?
            </p>
            <p class="text-slate-400 text-xs">Cette action est irréversible et supprimera toutes les données associées.</p>
        </div>
        <div class="flex justify-end gap-3 p-5 pt-0">
            <button onclick="closeDeleteModal()" class="px-4 py-2 bg-slate-700 hover:bg-slate-600 text-white rounded-lg transition-colors text-sm">
                Annuler
            </button>
            <form id="deleteForm" method="POST" class="inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg transition-colors text-sm">
                    <i class="fas fa-trash-alt mr-2"></i>Supprimer
                </button>
            </form>
        </div>
    </div>
</div>

<script>
    let currentDeleteId = null;
    let currentDeleteName = null;
    let currentEmployeData = null;

    // Fonction de recherche
    function filterEmployes() {
        const searchTerm = document.getElementById('searchInput').value.toLowerCase().trim();
        const rows = document.querySelectorAll('#employesTableBody .employe-row');
        let visibleCount = 0;
        
        rows.forEach(row => {
            const nomComplet = row.querySelector('.employe-name')?.textContent.toLowerCase() || '';
            const matricule = row.querySelector('.employe-matricule')?.textContent.toLowerCase() || '';
            const email = row.querySelector('.employe-email')?.textContent.toLowerCase() || '';
            
            // Recherche par nom complet, matricule ou email
            const matches = searchTerm === '' || 
                           nomComplet.includes(searchTerm) || 
                           matricule.includes(searchTerm) || 
                           email.includes(searchTerm);
            
            if (matches) {
                row.style.display = '';
                visibleCount++;
            } else {
                row.style.display = 'none';
            }
        });
        
        // Mettre à jour le compteur de résultats
        document.getElementById('resultCount').textContent = visibleCount;
        
        // Afficher un message si aucun résultat
        const tbody = document.getElementById('employesTableBody');
        const existingNoResult = tbody.querySelector('.no-result-row');
        
        if (visibleCount === 0 && searchTerm !== '') {
            if (!existingNoResult) {
                const noResultRow = document.createElement('tr');
                noResultRow.className = 'no-result-row';
                noResultRow.innerHTML = `
                    <td colspan="6" class="px-6 py-8 text-center text-slate-400">
                        <i class="fas fa-search text-3xl mb-2 block"></i>
                        Aucun employé trouvé pour "${escapeHtml(searchTerm)}"
                    </td>
                `;
                tbody.appendChild(noResultRow);
            }
        } else if (existingNoResult) {
            existingNoResult.remove();
        }
    }

    // Afficher les détails de l'employé
    function showEmployeDetails(employe) {
        currentEmployeData = employe;
        
        const modal = document.getElementById('detailsModal');
        const modalContent = document.getElementById('detailsModalContent');
        const detailsContent = document.getElementById('detailsContent');
        
        // Mettre à jour les liens de la modale
        const editLink = document.getElementById('modalEditLink');
        const deleteBtn = document.getElementById('modalDeleteBtn');
        
        if (editLink) {
            editLink.href = "{{ route('edit_employe', $employe->id) }}";
        }
        
        if (deleteBtn) {
            deleteBtn.onclick = function() {
                closeDetailsModal();
                setTimeout(() => {
                    openDeleteModal(employe.id, employe.prenom_employe + ' ' + employe.nom_employe);
                }, 300);
            };
        }
        
        // Générer le HTML des détails
        const documentsHtml = employe.dossiers && employe.dossiers.length > 0 
            ? employe.dossiers.map(doc => `
                <div class="flex items-center justify-between p-2 bg-slate-700/30 rounded-lg border border-slate-700/50">
                    <div class="flex items-center gap-2">
                        <div class="flex-shrink-0">
                            ${doc.type === 'image' ? 
                                '<i class="fas fa-image text-blue-400 text-lg"></i>' : 
                                '<i class="fas fa-file-alt text-green-400 text-lg"></i>'}
                        </div>
                        <div>
                            <p class="text-sm font-medium text-white">${escapeHtml(doc.nom_fichier)}</p>
                            <p class="text-xs text-slate-400">${doc.type}</p>
                        </div>
                    </div>
                    <div class="flex gap-2">
                        ${doc.type === 'image' && doc.chemin ? `
                            <a href="${doc.chemin}" target="_blank" class="text-indigo-400 hover:text-indigo-300 transition-colors" title="Voir">
                                <i class="fas fa-eye text-sm"></i>
                            </a>
                        ` : ''}
                        <a href="${doc.chemin}" download class="text-green-400 hover:text-green-300 transition-colors" title="Télécharger">
                            <i class="fas fa-download text-sm"></i>
                        </a>
                    </div>
                </div>
            `).join('')
            : '<div class="text-center py-4 text-slate-400 text-sm"><i class="fas fa-folder-open mb-1"></i><br>Aucun document</div>';
        
        const salaireFormatted = new Intl.NumberFormat('fr-FR').format(employe.salaire);
        
        detailsContent.innerHTML = `
            <div class="space-y-4 text-white">
                <!-- Infos perso -->
                <div>
                    <h3 class="text-sm font-semibold text-indigo-400 mb-2 flex items-center gap-1">
                        <i class="fas fa-user"></i> Informations personnelles
                    </h3>
                    <div class="grid grid-cols-2 gap-2 text-sm">
                        <div class="bg-slate-700/30 rounded p-2">
                            <div class="text-xs text-slate-400">Nom complet</div>
                            <div class="font-medium">${escapeHtml(employe.prenom_employe)} ${escapeHtml(employe.nom_employe)}</div>
                        </div>
                        <div class="bg-slate-700/30 rounded p-2">
                            <div class="text-xs text-slate-400">Matricule</div>
                            <div class="font-medium">${escapeHtml(employe.matricule_employe)}</div>
                        </div>
                        <div class="bg-slate-700/30 rounded p-2">
                            <div class="text-xs text-slate-400">Email</div>
                            <div class="font-medium text-sm truncate">${escapeHtml(employe.email_employe)}</div>
                        </div>
                        <div class="bg-slate-700/30 rounded p-2">
                            <div class="text-xs text-slate-400">Téléphone</div>
                            <div class="font-medium">${escapeHtml(employe.telephone)}</div>
                        </div>
                        <div class="bg-slate-700/30 rounded p-2 col-span-2">
                            <div class="text-xs text-slate-400">Adresse</div>
                            <div class="font-medium text-sm">${escapeHtml(employe.adresse_employe)}</div>
                        </div>
                        <div class="bg-slate-700/30 rounded p-2">
                            <div class="text-xs text-slate-400">Date d'embauche</div>
                            <div class="font-medium">${employe.date_embauche}</div>
                        </div>
                    </div>
                </div>
                
                <!-- Infos pro -->
                <div>
                    <h3 class="text-sm font-semibold text-indigo-400 mb-2 flex items-center gap-1">
                        <i class="fas fa-briefcase"></i> Informations professionnelles
                    </h3>
                    <div class="grid grid-cols-2 gap-2 text-sm">
                        <div class="bg-slate-700/30 rounded p-2">
                            <div class="text-xs text-slate-400">Poste</div>
                            <div class="font-medium">${escapeHtml(employe.poste)}</div>
                        </div>
                        <div class="bg-slate-700/30 rounded p-2">
                            <div class="text-xs text-slate-400">Département</div>
                            <div class="font-medium">${escapeHtml(employe.departement)}</div>
                        </div>
                        <div class="bg-slate-700/30 rounded p-2 col-span-2">
                            <div class="text-xs text-slate-400">Salaire</div>
                            <div class="font-medium text-emerald-400">${salaireFormatted} FCFA</div>
                        </div>
                    </div>
                </div>
                
                <!-- Documents -->
                <div>
                    <h3 class="text-sm font-semibold text-indigo-400 mb-2 flex items-center gap-1">
                        <i class="fas fa-folder-open"></i> Documents (${employe.dossiers ? employe.dossiers.length : 0})
                    </h3>
                    <div class="space-y-2 max-h-48 overflow-y-auto">
                        ${documentsHtml}
                    </div>
                </div>
            </div>
        `;
        
        // Afficher la modale avec animation
        modal.classList.remove('hidden');
        setTimeout(() => {
            modalContent.classList.remove('scale-95', 'opacity-0');
            modalContent.classList.add('scale-100', 'opacity-100');
        }, 10);
    }
    
    // Fermer la modale des détails
    function closeDetailsModal() {
        const modal = document.getElementById('detailsModal');
        const modalContent = document.getElementById('detailsModalContent');
        
        modalContent.classList.remove('scale-100', 'opacity-100');
        modalContent.classList.add('scale-95', 'opacity-0');
        
        setTimeout(() => {
            modal.classList.add('hidden');
            currentEmployeData = null;
        }, 300);
    }
    
    // Ouvrir la modale de confirmation de suppression
    function openDeleteModal(employeId, employeName) {
        currentDeleteId = employeId;
        currentDeleteName = employeName;
        
        document.getElementById('employeName').textContent = employeName;
        
        const deleteForm = document.getElementById('deleteForm');
        deleteForm.action = "{{ route('destroy_employe', '') }}/" + employeId;
        
        const modal = document.getElementById('deleteModal');
        const modalContent = document.getElementById('deleteModalContent');
        
        modal.classList.remove('hidden');
        setTimeout(() => {
            modalContent.classList.remove('scale-95', 'opacity-0');
            modalContent.classList.add('scale-100', 'opacity-100');
        }, 10);
    }
    
    // Fermer la modale de suppression
    function closeDeleteModal() {
        const modal = document.getElementById('deleteModal');
        const modalContent = document.getElementById('deleteModalContent');
        
        modalContent.classList.remove('scale-100', 'opacity-100');
        modalContent.classList.add('scale-95', 'opacity-0');
        
        setTimeout(() => {
            modal.classList.add('hidden');
            currentDeleteId = null;
            currentDeleteName = null;
        }, 300);
    }
    
    // Fonction utilitaire pour échapper le HTML
    function escapeHtml(text) {
        if (!text) return '';
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }
    
    // Initialisation au chargement de la page
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('searchInput');
        
        // Ajouter l'écouteur d'événement pour la recherche
        if (searchInput) {
            searchInput.addEventListener('input', filterEmployes);
        }
        
        const detailsModal = document.getElementById('detailsModal');
        const deleteModal = document.getElementById('deleteModal');
        
        if (detailsModal) {
            detailsModal.addEventListener('click', function(e) {
                if (e.target === detailsModal) {
                    closeDetailsModal();
                }
            });
        }
        
        if (deleteModal) {
            deleteModal.addEventListener('click', function(e) {
                if (e.target === deleteModal) {
                    closeDeleteModal();
                }
            });
        }
        
        // Gérer le clic sur les lignes du tableau
        document.querySelectorAll('.employe-row').forEach(row => {
            row.addEventListener('click', function(e) {
                // Éviter de déclencher si on clique sur un bouton d'action
                if (e.target.closest('.flex.justify-end')) {
                    return;
                }
                const employeData = this.getAttribute('data-employe');
                if (employeData) {
                    try {
                        const employe = JSON.parse(employeData);
                        showEmployeDetails(employe);
                    } catch(e) {
                        console.error('Erreur lors du parsing des données employé', e);
                    }
                }
            });
        });
        
        // Fermer avec la touche Echap
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                const detailsModalEl = document.getElementById('detailsModal');
                const deleteModalEl = document.getElementById('deleteModal');
                
                if (detailsModalEl && !detailsModalEl.classList.contains('hidden')) {
                    closeDetailsModal();
                }
                if (deleteModalEl && !deleteModalEl.classList.contains('hidden')) {
                    closeDeleteModal();
                }
            }
        });
    });
</script>

<style>
    /* Styles pour les modales */
    .backdrop-blur-sm {
        backdrop-filter: blur(4px);
    }
    
    /* Curseur pointer sur les lignes du tableau */
    tbody tr {
        cursor: pointer;
    }
    
    /* Scrollbar personnalisée */
    .overflow-y-auto::-webkit-scrollbar {
        width: 6px;
    }
    
    .overflow-y-auto::-webkit-scrollbar-track {
        background: #1e293b;
        border-radius: 3px;
    }
    
    .overflow-y-auto::-webkit-scrollbar-thumb {
        background: #475569;
        border-radius: 3px;
    }
    
    .overflow-y-auto::-webkit-scrollbar-thumb:hover {
        background: #64748b;
    }
    
    /* Animation pour la barre de recherche */
    #searchInput {
        transition: all 0.3s ease;
    }
    
    #searchInput:focus {
        box-shadow: 0 0 0 2px rgba(99, 102, 241, 0.2);
    }
    
    /* Responsive */
    @media (max-width: 640px) {
        .hide-scroll {
            scrollbar-width: none;
            -ms-overflow-style: none;
        }
        .hide-scroll::-webkit-scrollbar {
            display: none;
        }
        
        .grid-cols-2 {
            grid-template-columns: 1fr;
        }
    }
</style>
@endsection