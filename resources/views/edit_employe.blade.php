{{-- resources/views/modifier_employe.blade.php --}}
@extends('dashboard_base')

@section('main')
<main class="flex-1 bg-slate-900 text-white overflow-hidden relative">
    <div class="absolute inset-0 overflow-y-auto hide-scroll p-6">
        <!-- En-tête -->
        <div class="mb-8">
            <h1 class="text-2xl font-bold text-white mb-2 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
                Modifier l'Employé
            </h1>
            <p class="text-slate-400">Mettez à jour les informations de {{ $employe->prenom_employe }} {{ $employe->nom_employe }}.</p>
        </div>

        <!-- Indicateur d'étapes -->
        <div class="mb-8">
            <div class="flex items-center justify-center gap-4">
                <div class="flex items-center">
                    <div class="step step-1 w-10 h-10 rounded-full bg-indigo-600 flex items-center justify-center font-semibold text-white">1</div>
                    <div class="ml-2 text-sm font-medium">Informations</div>
                </div>
                <div class="w-20 h-0.5 bg-slate-700"></div>
                <div class="flex items-center">
                    <div class="step step-2 w-10 h-10 rounded-full bg-slate-700 flex items-center justify-center font-semibold text-white">2</div>
                    <div class="ml-2 text-sm font-medium text-slate-400">Documents</div>
                </div>
            </div>
        </div>

        <!-- Messages d'erreur -->
        @if ($errors->any())
        <div class="mb-6 p-4 bg-red-900/30 border border-red-800/50 rounded-lg">
            <div class="flex items-start gap-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-400 mt-0.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <div>
                    <h3 class="font-medium text-red-300">Veuillez corriger les erreurs suivantes :</h3>
                    <ul class="mt-1 text-sm text-red-200 space-y-1">
                        @foreach ($errors->all() as $error)
                            <li class="flex items-start gap-2">
                                <span class="text-red-400">•</span>
                                <span>{{ $error }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        @endif

        <!-- Formulaire -->
        <div class="bg-slate-800/50 backdrop-blur-sm rounded-xl border border-slate-700/50 shadow-xl overflow-hidden">
            <form action="{{ route('update_employe', $employe->id) }}" id="employeForm" method="POST" enctype="multipart/form-data" class="p-6 space-y-6">
                @csrf
                @method('PUT')

                <!-- ÉTAPE 1 : Informations employé -->
                <div id="step1" class="step-content">
                    <div class="space-y-6">
                        <!-- Nom et prénom -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="nom_employe" class="block text-sm font-medium text-slate-300 mb-2">Nom</label>
                                <input type="text" name="nom_employe" id="nom_employe" value="{{ old('nom_employe', $employe->nom_employe) }}" required
                                    class="w-full p-3 bg-slate-700/30 text-white rounded-lg border border-slate-700/50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                            </div>
                            <div>
                                <label for="prenom_employe" class="block text-sm font-medium text-slate-300 mb-2">Prénom</label>
                                <input type="text" name="prenom_employe" id="prenom_employe" value="{{ old('prenom_employe', $employe->prenom_employe) }}" required
                                    class="w-full p-3 bg-slate-700/30 text-white rounded-lg border border-slate-700/50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                            </div>
                        </div>

                        <!-- Adresse et téléphone -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="adresse_employe" class="block text-sm font-medium text-slate-300 mb-2">Adresse</label>
                                <input type="text" name="adresse_employe" id="adresse_employe" value="{{ old('adresse_employe', $employe->adresse_employe) }}" required
                                    class="w-full p-3 bg-slate-700/30 text-white rounded-lg border border-slate-700/50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                            </div>
                            <div>
                                <label for="telephone" class="block text-sm font-medium text-slate-300 mb-2">Téléphone</label>
                                <input type="tel" name="telephone" id="telephone" value="{{ old('telephone', $employe->telephone) }}" required
                                    class="w-full p-3 bg-slate-700/30 text-white rounded-lg border border-slate-700/50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                            </div>
                        </div>

                        <!-- Email -->
                        <div>
                            <label for="email_employe" class="block text-sm font-medium text-slate-300 mb-2">Email</label>
                            <input type="email" name="email_employe" id="email_employe" value="{{ old('email_employe', $employe->email_employe) }}" required
                                class="w-full p-3 bg-slate-700/30 text-white rounded-lg border border-slate-700/50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                        </div>

                        <!-- Poste et département -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="poste" class="block text-sm font-medium text-slate-300 mb-2">Poste</label>
                                <input type="text" name="poste" id="poste" value="{{ old('poste', $employe->poste) }}" required
                                    class="w-full p-3 bg-slate-700/30 text-white rounded-lg border border-slate-700/50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                            </div>
                            <div>
                                <label for="departement" class="block text-sm font-medium text-slate-300 mb-2">Département</label>
                                <select name="departement" id="departement" required
                                    class="w-full p-3 bg-slate-700/30 text-white rounded-lg border border-slate-700/50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                                    <option value="" disabled>Sélectionnez un département</option>
                                    <option value="Direction" {{ old('departement', $employe->departement) == 'Direction' ? 'selected' : '' }}>Direction</option>
                                    <option value="Comptabilité" {{ old('departement', $employe->departement) == 'Comptabilité' ? 'selected' : '' }}>Comptabilité</option>
                                    <option value="Juridique" {{ old('departement', $employe->departement) == 'Juridique' ? 'selected' : '' }}>Juridique</option>
                                    <option value="Informatique" {{ old('departement', $employe->departement) == 'Informatique' ? 'selected' : '' }}>Informatique</option>
                                    <option value="Ressources Humaines" {{ old('departement', $employe->departement) == 'Ressources Humaines' ? 'selected' : '' }}>Ressources Humaines</option>
                                    <option value="Communication" {{ old('departement', $employe->departement) == 'Communication' ? 'selected' : '' }}>Communication</option>
                                    <option value="Commercial" {{ old('departement', $employe->departement) == 'Commercial' ? 'selected' : '' }}>Commercial</option>
                                    <option value="Secrétariat" {{ old('departement', $employe->departement) == 'Secrétariat' ? 'selected' : '' }}>Secrétariat</option>
                                </select>
                            </div>
                        </div>

                        <!-- Salaire -->
                        <div>
                            <label for="salaire" class="block text-sm font-medium text-slate-300 mb-2">Salaire (FCFA)</label>
                            <input type="number" name="salaire" id="salaire" value="{{ old('salaire', $employe->salaire) }}" required
                                class="w-full p-3 bg-slate-700/30 text-white rounded-lg border border-slate-700/50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none">
                        </div>
                    </div>
                </div>

                <!-- ÉTAPE 2 : Gestion des documents -->
                <div id="step2" class="step-content" style="display: none;">
                    <div class="space-y-6">
                        <!-- Documents existants -->
                        @if($dossiers->count() > 0)
                        <div>
                            <h3 class="text-lg font-semibold text-white mb-3 flex items-center gap-2">
                                <svg class="w-5 h-5 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                Documents actuels ({{ $dossiers->count() }})
                            </h3>
                            <div id="existingFilesList" class="space-y-2 max-h-64 overflow-y-auto">
                                @foreach($dossiers as $dossier)
                                <div class="file-item flex items-center justify-between p-3 bg-slate-700/30 rounded-lg border border-slate-700/50" data-id="{{ $dossier->id }}">
                                    <div class="flex items-center gap-3">
                                        <div class="flex-shrink-0">
                                            @if($dossier->type == 'image')
                                                <svg class="w-8 h-8 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                </svg>
                                            @else
                                                <svg class="w-8 h-8 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                                </svg>
                                            @endif
                                        </div>
                                        <div>
                                            <p class="font-medium text-white">{{ $dossier->nom_fichier }}</p>
                                            <p class="text-xs text-slate-400">{{ ucfirst($dossier->type) }}</p>
                                        </div>
                                    </div>
                                    <div class="flex gap-2">
                                        @if($dossier->type == 'image' && filter_var($dossier->chemin, FILTER_VALIDATE_URL))
                                        <a href="{{ $dossier->chemin }}" target="_blank" class="text-indigo-400 hover:text-indigo-300 transition-colors">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                            </svg>
                                        </a>
                                        @endif
                                        <button type="button" onclick="showDeleteModal('{{ $dossier->id }}', '{{ addslashes($dossier->nom_fichier) }}')" class="delete-btn text-red-400 hover:text-red-300 transition-colors">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @endif

                        <!-- Zone d'upload de nouveaux documents -->
                        <div>
                            <h3 class="text-lg font-semibold text-white mb-3 flex items-center gap-2">
                                <svg class="w-5 h-5 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                                </svg>
                                Ajouter de nouveaux documents
                            </h3>
                            <p class="text-sm text-slate-400 mb-3">Glissez-déposez vos fichiers ici (images, PDF, Word, Excel) - Optionnel</p>
                            
                            <div id="dropzone" 
                                 class="border-2 border-dashed border-slate-600 rounded-lg p-8 text-center hover:border-indigo-500 transition-all duration-300 cursor-pointer bg-slate-700/20"
                                 ondragover="event.preventDefault()"
                                 ondragenter="event.preventDefault()">
                                <input type="file" id="fileInput" name="files[]" multiple style="display: none;" accept=".jpg,.jpeg,.png,.gif,.pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.txt">
                                <div class="flex flex-col items-center gap-4">
                                    <svg class="w-16 h-16 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                                    </svg>
                                    <div>
                                        <p class="text-lg font-medium">Glissez-déposez vos fichiers ici</p>
                                        <p class="text-sm text-slate-400 mt-1">ou cliquez pour sélectionner</p>
                                    </div>
                                    <div class="flex gap-3 text-xs text-slate-500">
                                        <span>📷 Images (JPG, PNG, GIF)</span>
                                        <span>📄 Documents (PDF, Word, Excel)</span>
                                        <span>📦 Max 50MB par fichier</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Nouveaux fichiers sélectionnés -->
                        <div id="newFilesSection" class="hidden">
                            <h3 class="text-sm font-medium text-slate-300 mb-3">Nouveaux fichiers :</h3>
                            <div id="newFileList" class="space-y-2 max-h-48 overflow-y-auto">
                                <!-- Les nouveaux fichiers apparaîtront ici -->
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Boutons de navigation -->
                <div class="pt-4 flex gap-4">
                    <button type="button" id="prevBtn" class="hidden px-6 py-3 bg-slate-700 text-white font-medium rounded-lg hover:bg-slate-600 focus:outline-none focus:ring-2 focus:ring-slate-500 focus:ring-offset-2 focus:ring-offset-slate-800 transition-all duration-200 flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                        </svg>
                        Précédent
                    </button>
                    
                    <button type="button" id="nextBtn" class="flex-1 py-3 px-4 bg-gradient-to-r from-indigo-600 to-indigo-700 text-white font-medium rounded-lg hover:from-indigo-700 hover:to-indigo-800 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 focus:ring-offset-slate-800 transition-all duration-200 flex items-center justify-center gap-2">
                        Suivant
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </button>
                    
                    <button type="submit" id="submitBtn" class="hidden flex-1 py-3 px-4 bg-gradient-to-r from-green-600 to-green-700 text-white font-medium rounded-lg hover:from-green-700 hover:to-green-800 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 focus:ring-offset-slate-800 transition-all duration-200 flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Enregistrer les modifications
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Effets décoratifs -->
    <div class="fixed -bottom-32 -left-32 w-64 h-64 bg-indigo-500 rounded-full mix-blend-multiply filter blur-3xl opacity-5"></div>
    <div class="fixed -top-32 -right-32 w-64 h-64 bg-purple-500 rounded-full mix-blend-multiply filter blur-3xl opacity-5"></div>
</main>

<!-- MODAL DE CONFIRMATION DE SUPPRESSION -->
<div id="deleteModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/70 backdrop-blur-sm transition-all duration-300">
    <div class="bg-slate-800 rounded-xl border border-slate-700 shadow-2xl max-w-md w-full mx-4 transform transition-all duration-300 scale-95 opacity-0" id="modalContent">
        <div class="p-6">
            <div class="flex items-center gap-3 mb-4">
                <div class="w-12 h-12 rounded-full bg-red-500/20 flex items-center justify-center">
                    <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-white">Confirmer la suppression</h3>
            </div>
            <p class="text-slate-300 mb-6">
                Êtes-vous sûr de vouloir supprimer le fichier <strong id="deleteFileName" class="text-white"></strong> ?
                <br><span class="text-sm text-slate-400">Cette action est irréversible.</span>
            </p>
            <div class="flex gap-3">
                <button id="cancelDeleteBtn" class="flex-1 px-4 py-2 bg-slate-700 text-white rounded-lg hover:bg-slate-600 transition-all duration-200 font-medium">
                    Annuler
                </button>
                <button id="confirmDeleteBtn" class="flex-1 px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-all duration-200 font-medium flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                    </svg>
                    Supprimer
                </button>
            </div>
        </div>
    </div>
</div>

<script>
let newFiles = [];
const employeId = '{{ $employe->id }}';
let pendingDeleteId = null;
let isDeleting = false;

document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById('employeForm');
    const step1 = document.getElementById('step1');
    const step2 = document.getElementById('step2');
    const nextBtn = document.getElementById('nextBtn');
    const prevBtn = document.getElementById('prevBtn');
    const submitBtn = document.getElementById('submitBtn');
    const dropzone = document.getElementById('dropzone');
    const fileInput = document.getElementById('fileInput');
    const newFileList = document.getElementById('newFileList');
    const newFilesSection = document.getElementById('newFilesSection');
    const deleteModal = document.getElementById('deleteModal');
    const modalContent = document.getElementById('modalContent');
    const cancelDeleteBtn = document.getElementById('cancelDeleteBtn');
    const confirmDeleteBtn = document.getElementById('confirmDeleteBtn');
    
    let currentStep = 1;
    
    // Fonction pour mettre à jour l'affichage des étapes
    function updateSteps() {
        if (currentStep === 1) {
            step1.style.display = 'block';
            step2.style.display = 'none';
            nextBtn.classList.remove('hidden');
            prevBtn.classList.add('hidden');
            submitBtn.classList.add('hidden');
            
            // Mise à jour des indicateurs
            const step1El = document.querySelector('.step-1');
            const step2El = document.querySelector('.step-2');
            if (step1El) {
                step1El.classList.remove('bg-slate-700');
                step1El.classList.add('bg-indigo-600');
            }
            if (step2El) {
                step2El.classList.remove('bg-indigo-600');
                step2El.classList.add('bg-slate-700');
            }
            const step2Text = document.querySelector('.step-2 + .ml-2');
            if (step2Text) {
                step2Text.classList.remove('text-white');
                step2Text.classList.add('text-slate-400');
            }
        } else {
            step1.style.display = 'none';
            step2.style.display = 'block';
            nextBtn.classList.add('hidden');
            prevBtn.classList.remove('hidden');
            submitBtn.classList.remove('hidden');
            
            // Mise à jour des indicateurs
            const step1El = document.querySelector('.step-1');
            const step2El = document.querySelector('.step-2');
            if (step1El) {
                step1El.classList.remove('bg-indigo-600');
                step1El.classList.add('bg-green-600');
            }
            if (step2El) {
                step2El.classList.remove('bg-slate-700');
                step2El.classList.add('bg-indigo-600');
            }
            const step2Text = document.querySelector('.step-2 + .ml-2');
            if (step2Text) {
                step2Text.classList.remove('text-slate-400');
                step2Text.classList.add('text-white');
            }
        }
    }
    
    // Bouton suivant
    nextBtn.addEventListener('click', function() {
        // Valider les champs obligatoires de l'étape 1
        const requiredFields = ['nom_employe', 'prenom_employe', 'adresse_employe', 'telephone', 'email_employe', 'poste', 'departement', 'salaire'];
        let isValid = true;
        
        requiredFields.forEach(field => {
            const input = document.getElementById(field);
            if (input && !input.value.trim()) {
                input.classList.add('border-red-500');
                isValid = false;
            } else if (input) {
                input.classList.remove('border-red-500');
            }
        });
        
        if (!isValid) {
            alert('Veuillez remplir tous les champs obligatoires.');
            return;
        }
        
        currentStep = 2;
        updateSteps();
    });
    
    // Bouton précédent
    prevBtn.addEventListener('click', function() {
        currentStep = 1;
        updateSteps();
    });
    
    // Gestion des nouveaux fichiers
    if (dropzone) {
        dropzone.addEventListener('click', () => {
            fileInput.click();
        });
        
        dropzone.addEventListener('dragover', (e) => {
            e.preventDefault();
            dropzone.classList.add('border-indigo-500', 'bg-slate-700/50');
        });
        
        dropzone.addEventListener('dragleave', (e) => {
            e.preventDefault();
            dropzone.classList.remove('border-indigo-500', 'bg-slate-700/50');
        });
        
        dropzone.addEventListener('drop', (e) => {
            e.preventDefault();
            dropzone.classList.remove('border-indigo-500', 'bg-slate-700/50');
            const files = Array.from(e.dataTransfer.files);
            addNewFiles(files);
        });
    }
    
    if (fileInput) {
        fileInput.addEventListener('change', (e) => {
            const files = Array.from(e.target.files);
            addNewFiles(files);
        });
    }
    
    function addNewFiles(files) {
        const MAX_FILE_SIZE = 50 * 1024 * 1024; // 50MB
        
        files.forEach(file => {
            if (file.size > MAX_FILE_SIZE) {
                alert(`Le fichier ${file.name} dépasse la limite de 50MB`);
                return;
            }
            
            if (!newFiles.some(f => f.name === file.name && f.size === file.size)) {
                newFiles.push(file);
                displayNewFile(file);
            }
        });
        
        updateFileInput();
        
        if (newFiles.length > 0 && newFilesSection) {
            newFilesSection.classList.remove('hidden');
        }
    }
    
    function displayNewFile(file) {
        if (!newFileList) return;
        
        const fileDiv = document.createElement('div');
        fileDiv.className = 'flex items-center justify-between p-2 bg-slate-700/30 rounded-lg border border-slate-700/50';
        
        const fileIcon = file.type.startsWith('image/') ? '🖼️' : '📄';
        
        // Échapper le nom du fichier pour éviter les problèmes avec les apostrophes
        const escapedFileName = file.name.replace(/'/g, "\\'");
        
        fileDiv.innerHTML = `
            <div class="flex items-center gap-2">
                <span class="text-lg">${fileIcon}</span>
                <div>
                    <p class="text-sm font-medium text-white">${escapeHtml(file.name)}</p>
                    <p class="text-xs text-slate-400">${(file.size / 1024 / 1024).toFixed(2)} MB</p>
                </div>
            </div>
            <button type="button" onclick="removeNewFile('${escapedFileName}')" class="text-red-400 hover:text-red-300 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        `;
        
        newFileList.appendChild(fileDiv);
    }
    
    // Fonction utilitaire pour échapper le HTML
    function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }
    
    window.removeNewFile = function(fileName) {
        newFiles = newFiles.filter(f => f.name !== fileName);
        updateNewFileList();
        
        if (newFiles.length === 0 && newFilesSection) {
            newFilesSection.classList.add('hidden');
        }
    };
    
    function updateNewFileList() {
        if (newFileList) {
            newFileList.innerHTML = '';
            newFiles.forEach(file => displayNewFile(file));
        }
        updateFileInput();
    }
    
    function updateFileInput() {
        if (!fileInput) return;
        
        const dataTransfer = new DataTransfer();
        newFiles.forEach(file => {
            dataTransfer.items.add(file);
        });
        fileInput.files = dataTransfer.files;
    }
    
    // Afficher le modal de confirmation
    window.showDeleteModal = function(fileId, fileName) {
        if (isDeleting) return;
        pendingDeleteId = fileId;
        document.getElementById('deleteFileName').innerHTML = escapeHtml(fileName);
        
        // Afficher le modal avec animation
        deleteModal.classList.remove('hidden');
        deleteModal.classList.add('flex');
        
        // Animation d'entrée
        setTimeout(() => {
            modalContent.classList.remove('scale-95', 'opacity-0');
            modalContent.classList.add('scale-100', 'opacity-100');
        }, 10);
    };
    
    // Fermer le modal
    function closeModal() {
        modalContent.classList.remove('scale-100', 'opacity-100');
        modalContent.classList.add('scale-95', 'opacity-0');
        
        setTimeout(() => {
            deleteModal.classList.remove('flex');
            deleteModal.classList.add('hidden');
            pendingDeleteId = null;
        }, 300);
    }
    
    // Confirmer la suppression
    confirmDeleteBtn.addEventListener('click', async function() {
        if (!pendingDeleteId || isDeleting) return;
        
        isDeleting = true;
        const originalButtonText = confirmDeleteBtn.innerHTML;
        
        // Désactiver le bouton et montrer le loading
        confirmDeleteBtn.disabled = true;
        confirmDeleteBtn.innerHTML = `
            <svg class="animate-spin h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
            </svg>
            Suppression...
        `;
        confirmDeleteBtn.classList.add('opacity-70', 'cursor-not-allowed');
        
        try {
            const response = await fetch(`/employe/${employeId}/file/${pendingDeleteId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                }
            });
            
            const data = await response.json();
            
            if (data.success) {
                // Supprimer l'élément du DOM
                const fileElement = document.querySelector(`.file-item[data-id="${pendingDeleteId}"]`);
                if (fileElement) {
                    fileElement.style.opacity = '0';
                    fileElement.style.transform = 'translateX(20px)';
                    setTimeout(() => {
                        fileElement.remove();
                        // Mettre à jour le compteur de documents
                        const remainingFiles = document.querySelectorAll('.file-item').length;
                        const documentsTitle = document.querySelector('#existingFilesList')?.previousElementSibling;
                        if (documentsTitle) {
                            documentsTitle.innerHTML = `
                                <svg class="w-5 h-5 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                Documents actuels (${remainingFiles})
                            `;
                        }
                    }, 200);
                }
                
                closeModal();
            } else {
                alert('Erreur lors de la suppression du fichier');
                closeModal();
            }
        } catch (error) {
            console.error('Error:', error);
            alert('Erreur lors de la suppression du fichier');
            closeModal();
        } finally {
            // Restaurer le bouton
            confirmDeleteBtn.disabled = false;
            confirmDeleteBtn.innerHTML = originalButtonText;
            confirmDeleteBtn.classList.remove('opacity-70', 'cursor-not-allowed');
            isDeleting = false;
        }
    });
    
    // Annuler la suppression
    cancelDeleteBtn.addEventListener('click', closeModal);
    
    // Fermer le modal en cliquant en dehors
    deleteModal.addEventListener('click', function(e) {
        if (e.target === deleteModal) {
            closeModal();
        }
    });
    
    // Empêcher la fermeture en cliquant sur le contenu du modal
    modalContent.addEventListener('click', function(e) {
        e.stopPropagation();
    });
    
    // Soumission du formulaire
    if (form) {
        form.addEventListener('submit', function (e) {
            const submitButton = document.getElementById('submitBtn');
            
            if (submitButton.disabled) {
                e.preventDefault();
                return false;
            }
            
            submitButton.disabled = true;
            submitButton.innerHTML = `
                <span class="flex items-center justify-center gap-2">
                    <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor"
                            d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z">
                        </path>
                    </svg>
                    Enregistrement en cours...
                </span>
            `;
            submitButton.classList.add('opacity-70', 'cursor-not-allowed');
        });
    }
    
    // Initialisation
    updateSteps();
});
</script>
@endsection