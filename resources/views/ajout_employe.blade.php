{{-- resources/views/ajout_employe.blade.php --}}
@extends('dashboard_base')

@section('main')
<main class="flex-1 bg-slate-900 text-white overflow-hidden relative">
    <div class="absolute inset-0 overflow-y-auto hide-scroll p-6">
        <!-- En-tête -->
        <div class="mb-8">
            <h1 class="text-2xl font-bold text-white mb-2 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                </svg>
                Ajouter un Employé
            </h1>
            <p class="text-slate-400">Remplissez le formulaire pour ajouter un nouvel employé à votre équipe.</p>
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
            <form id="employeForm" action="{{ route('store_employe') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-6">
                @csrf

                <!-- ÉTAPE 1 : Informations employé -->
                <div id="step1" class="step-content">
                    <div class="space-y-6">
                        <!-- Nom et prénom -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="nom_employe" class="block text-sm font-medium text-slate-300 mb-2">Nom</label>
                                <input type="text" name="nom_employe" id="nom_employe" value="{{ old('nom_employe') }}" required
                                    class="w-full p-3 bg-slate-700/30 text-white rounded-lg border border-slate-700/50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                            </div>
                            <div>
                                <label for="prenom_employe" class="block text-sm font-medium text-slate-300 mb-2">Prénom</label>
                                <input type="text" name="prenom_employe" id="prenom_employe" value="{{ old('prenom_employe') }}" required
                                    class="w-full p-3 bg-slate-700/30 text-white rounded-lg border border-slate-700/50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                            </div>
                        </div>

                        <!-- Adresse et téléphone -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="adresse_employe" class="block text-sm font-medium text-slate-300 mb-2">Adresse</label>
                                <input type="text" name="adresse_employe" id="adresse_employe" value="{{ old('adresse_employe') }}" required
                                    class="w-full p-3 bg-slate-700/30 text-white rounded-lg border border-slate-700/50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                            </div>
                            <div>
                                <label for="telephone" class="block text-sm font-medium text-slate-300 mb-2">Téléphone</label>
                                <input type="tel" name="telephone" id="telephone" value="{{ old('telephone') }}" required
                                    class="w-full p-3 bg-slate-700/30 text-white rounded-lg border border-slate-700/50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                            </div>
                        </div>

                        <!-- Email -->
                        <div>
                            <label for="email_employe" class="block text-sm font-medium text-slate-300 mb-2">Email</label>
                            <input type="email" name="email_employe" id="email_employe" value="{{ old('email_employe') }}" required
                                class="w-full p-3 bg-slate-700/30 text-white rounded-lg border border-slate-700/50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                        </div>

                        <!-- Poste et département -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="poste" class="block text-sm font-medium text-slate-300 mb-2">Poste</label>
                                <input type="text" name="poste" id="poste" value="{{ old('poste') }}" required
                                    class="w-full p-3 bg-slate-700/30 text-white rounded-lg border border-slate-700/50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                            </div>
                            <div>
                                <label for="departement" class="block text-sm font-medium text-slate-300 mb-2">Département</label>
                                <select name="departement" id="departement" required
                                    class="w-full p-3 bg-slate-700/30 text-white rounded-lg border border-slate-700/50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                                    <option value="" disabled {{ old('departement') ? '' : 'selected' }}>Sélectionnez un département</option>
                                    <option value="Direction" {{ old('departement') == 'Direction' ? 'selected' : '' }}>Direction</option>
                                    <option value="Comptabilité" {{ old('departement') == 'Comptabilité' ? 'selected' : '' }}>Comptabilité</option>
                                    <option value="Juridique" {{ old('departement') == 'Juridique' ? 'selected' : '' }}>Juridique</option>
                                    <option value="Informatique" {{ old('departement') == 'Informatique' ? 'selected' : '' }}>Informatique</option>
                                    <option value="Ressources Humaines" {{ old('departement') == 'Ressources Humaines' ? 'selected' : '' }}>Ressources Humaines</option>
                                    <option value="Communication" {{ old('departement') == 'Communication' ? 'selected' : '' }}>Communication</option>
                                    <option value="Commercial" {{ old('departement') == 'Commercial' ? 'selected' : '' }}>Commercial</option>
                                    <option value="Secrétariat" {{ old('departement') == 'Secrétariat' ? 'selected' : '' }}>Secrétariat</option>
                                </select>
                            </div>
                        </div>

                        <!-- Salaire -->
                        <div>
                            <label for="salaire" class="block text-sm font-medium text-slate-300 mb-2">Salaire (FCFA)</label>
                            <input type="number" name="salaire" id="salaire" value="{{ old('salaire') }}" required
                                class="w-full p-3 bg-slate-700/30 text-white rounded-lg border border-slate-700/50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none">
                        </div>
                    </div>
                </div>

                <!-- ÉTAPE 2 : Upload des documents -->
                <div id="step2" class="step-content" style="display: none;">
                    <div class="space-y-6">
                        <div class="text-center mb-4">
                            <p class="text-slate-300">Ajoutez des documents (images, PDF, Word, Excel, etc.) - Étape facultative</p>
                        </div>

                        <!-- Zone de drag and drop -->
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
                                    <span>📦 Max 10MB par fichier</span>
                                </div>
                            </div>
                        </div>

                        <!-- Liste des fichiers sélectionnés -->
                        <div class="mt-4">
                            <h3 class="text-sm font-medium text-slate-300 mb-3">Fichiers sélectionnés :</h3>
                            <div id="fileList" class="space-y-2 max-h-64 overflow-y-auto">
                                <!-- Les fichiers ajoutés apparaîtront ici -->
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
                        Enregistrer l'employé
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Effets décoratifs -->
    <div class="fixed -bottom-32 -left-32 w-64 h-64 bg-indigo-500 rounded-full mix-blend-multiply filter blur-3xl opacity-5"></div>
    <div class="fixed -top-32 -right-32 w-64 h-64 bg-purple-500 rounded-full mix-blend-multiply filter blur-3xl opacity-5"></div>
</main>

<script>
let selectedFiles = [];

document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById('employeForm');
    const step1 = document.getElementById('step1');
    const step2 = document.getElementById('step2');
    const nextBtn = document.getElementById('nextBtn');
    const prevBtn = document.getElementById('prevBtn');
    const submitBtn = document.getElementById('submitBtn');
    const dropzone = document.getElementById('dropzone');
    const fileInput = document.getElementById('fileInput');
    const fileList = document.getElementById('fileList');
    
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
            document.querySelector('.step-1').classList.remove('bg-slate-700');
            document.querySelector('.step-1').classList.add('bg-indigo-600');
            document.querySelector('.step-2').classList.remove('bg-indigo-600');
            document.querySelector('.step-2').classList.add('bg-slate-700');
            document.querySelector('.step-2 + .ml-2').classList.remove('text-white');
            document.querySelector('.step-2 + .ml-2').classList.add('text-slate-400');
        } else {
            step1.style.display = 'none';
            step2.style.display = 'block';
            nextBtn.classList.add('hidden');
            prevBtn.classList.remove('hidden');
            submitBtn.classList.remove('hidden');
            
            // Mise à jour des indicateurs
            document.querySelector('.step-1').classList.remove('bg-indigo-600');
            document.querySelector('.step-1').classList.add('bg-green-600');
            document.querySelector('.step-2').classList.remove('bg-slate-700');
            document.querySelector('.step-2').classList.add('bg-indigo-600');
            document.querySelector('.step-2 + .ml-2').classList.remove('text-slate-400');
            document.querySelector('.step-2 + .ml-2').classList.add('text-white');
        }
    }
    
    // Bouton suivant
    nextBtn.addEventListener('click', function() {
        // Valider les champs obligatoires de l'étape 1
        const requiredFields = ['nom_employe', 'prenom_employe', 'adresse_employe', 'telephone', 'email_employe', 'poste', 'departement', 'salaire'];
        let isValid = true;
        
        requiredFields.forEach(field => {
            const input = document.getElementById(field);
            if (!input.value.trim()) {
                input.classList.add('border-red-500');
                isValid = false;
            } else {
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
    
    // Gestion des fichiers
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
        addFiles(files);
    });
    
    fileInput.addEventListener('change', (e) => {
        const files = Array.from(e.target.files);
        addFiles(files);
    });
    
    function addFiles(files) {
        files.forEach(file => {
            if (file.size > 10 * 1024 * 1024) {
                alert(`Le fichier ${file.name} dépasse la limite de 10MB`);
                return;
            }
            
            // Vérifier si le fichier existe déjà
            if (!selectedFiles.some(f => f.name === file.name && f.size === file.size)) {
                selectedFiles.push(file);
                displayFile(file);
            }
        });
        
        // Mettre à jour l'input du formulaire
        updateFileInput();
    }
    
    function displayFile(file) {
        const fileDiv = document.createElement('div');
        fileDiv.className = 'flex items-center justify-between p-2 bg-slate-700/30 rounded-lg border border-slate-700/50';
        
        const fileIcon = file.type.startsWith('image/') ? '🖼️' : '📄';
        
        fileDiv.innerHTML = `
            <div class="flex items-center gap-2">
                <span class="text-lg">${fileIcon}</span>
                <div>
                    <p class="text-sm font-medium text-white">${file.name}</p>
                    <p class="text-xs text-slate-400">${(file.size / 1024 / 1024).toFixed(2)} MB</p>
                </div>
            </div>
            <button type="button" onclick="removeFile('${file.name}')" class="text-red-400 hover:text-red-300">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        `;
        
        fileList.appendChild(fileDiv);
    }
    
    window.removeFile = function(fileName) {
        selectedFiles = selectedFiles.filter(f => f.name !== fileName);
        updateFileList();
    };
    
    function updateFileList() {
        fileList.innerHTML = '';
        selectedFiles.forEach(file => displayFile(file));
        updateFileInput();
    }
    
    function updateFileInput() {
        // Créer un nouveau DataTransfer pour mettre à jour l'input file
        const dataTransfer = new DataTransfer();
        selectedFiles.forEach(file => {
            dataTransfer.items.add(file);
        });
        fileInput.files = dataTransfer.files;
    }
    
    // Soumission du formulaire
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
    
    // Initialisation
    updateSteps();
});
</script>
@endsection