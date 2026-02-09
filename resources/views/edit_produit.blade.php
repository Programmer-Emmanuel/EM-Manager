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
                Modifier le Produit
            </h1>
            <p class="text-slate-400">Mettez à jour les informations de {{ $produit->nom }}.</p>
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
            <form action="{{ route('update_produit', $produit->id) }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-6">
                @csrf
                @method('POST')

                <!-- Nom du produit -->
                <div>
                    <label for="nom" class="block text-sm font-medium text-slate-300 mb-2">Nom du produit *</label>
                    <input type="text" name="nom" id="nom" value="{{ old('nom', $produit->nom) }}" required
                        class="w-full p-3 bg-slate-700/30 text-white rounded-lg border border-slate-700/50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                        placeholder="Ex: iPhone 14 Pro">
                    @error('nom')
                        <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                

                <!-- Description -->
                <div>
                    <label for="description" class="block text-sm font-medium text-slate-300 mb-2">Description *</label>
                    <textarea name="description" id="description" rows="4" required
                        class="w-full p-3 bg-slate-700/30 text-white rounded-lg border border-slate-700/50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent resize-none"
                        placeholder="Décrivez votre produit en détail...">{{ old('description', $produit->description) }}</textarea>
                    <div class="flex justify-between items-center mt-2">
                        <div class="text-xs text-slate-400">
                            <span id="charCount">{{ strlen(old('description', $produit->description)) }}</span> / 500 caractères
                        </div>
                        @error('description')
                            <p class="text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Image upload -->
                <div>
                    <label class="block text-sm font-medium text-slate-300 mb-2">
                        Image du produit (optionnel)
                    </label>
                    
                    <!-- Image actuelle -->
                    @if($produit->image)
                    <div class="mb-4 p-4 bg-slate-900/30 rounded-lg border border-slate-700/50">
                        <p class="text-sm text-slate-400 mb-3 flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            Image actuelle:
                        </p>
                        <div class="flex flex-col md:flex-row gap-4 items-start">
                            <div class="relative w-32 h-32 rounded-lg overflow-hidden border border-slate-600">
                                <img src="{{ $produit->image }}" 
                                     alt="{{ $produit->nom }}"
                                     class="w-full h-full object-cover">
                            </div>
                            <div class="flex-1">
                                <p class="text-sm text-slate-300">Pour changer l'image, téléchargez une nouvelle image ci-dessous.</p>
                                <p class="text-xs text-slate-500 mt-2">L'ancienne image sera automatiquement remplacée.</p>
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Upload area -->
                    <div id="uploadArea" 
                         class="border-2 border-dashed border-slate-600 rounded-lg p-8 text-center hover:border-slate-500 transition-colors cursor-pointer bg-slate-900/30">
                        <input type="file" 
                               name="image" 
                               id="imageInput" 
                               accept="image/*"
                               class="hidden"
                               onchange="previewFile()">
                        
                        <div class="flex flex-col items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-slate-500 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <p class="text-slate-300 mb-2">
                                <span class="font-medium text-white">
                                    {{ $produit->image ? 'Changer l\'image' : 'Cliquez pour uploader' }}
                                </span> ou glissez-déposez
                            </p>
                            <p class="text-sm text-slate-400">PNG, JPG, GIF jusqu'à 2MB</p>
                        </div>
                    </div>

                    <!-- Preview de la nouvelle image -->
                    <div id="imagePreview" class="mt-4 hidden">
                        <p class="text-sm text-slate-400 mb-2">Nouvelle image :</p>
                        <div class="relative w-32 h-32 rounded-lg overflow-hidden border-2 border-indigo-500/50">
                            <img id="previewImage" class="w-full h-full object-cover">
                            <button type="button" 
                                    onclick="removeImage()"
                                    class="absolute top-2 right-2 bg-red-500 text-white p-1 rounded-full hover:bg-red-600 transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    </div>
                    
                    @error('image')
                        <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Boutons d'action -->
                <div class="pt-4 border-t border-slate-700/50">
                    <div class="flex flex-col sm:flex-row gap-4 items-center justify-between">
                        <a href="{{ route('liste_produits') }}" 
                           class="px-6 py-3 border border-slate-600 text-slate-300 rounded-lg hover:bg-slate-700/50 transition-colors flex items-center gap-2 w-full sm:w-auto justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            Annuler
                        </a>
                        
                        <div class="flex gap-3 w-full sm:w-auto">
                            <!-- <button type="button" 
                                    onclick="confirmDelete()"
                                    class="px-6 py-3 bg-red-600/20 text-red-400 rounded-lg hover:bg-red-600/30 hover:text-red-300 transition-colors flex items-center gap-2 w-full sm:w-auto justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                                Supprimer
                            </button> -->
                            
                            <button type="submit"
                                    class="px-6 py-3 bg-gradient-to-r from-indigo-600 to-indigo-700 text-white font-medium rounded-lg border border-indigo-700 hover:from-indigo-700 hover:to-indigo-800 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 focus:ring-offset-slate-800 transition-all duration-200 flex items-center justify-center gap-2 w-full sm:w-auto">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                Mettre à jour
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <!-- Informations -->
        <div class="mt-6 p-4 bg-slate-800/30 rounded-lg border border-slate-700/50">
            <div class="flex items-start">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-400 mt-0.5 mr-3 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <div>
                    <h4 class="font-medium text-slate-300 mb-1">Informations importantes</h4>
                    <p class="text-sm text-slate-400">
                        • La suppression est définitive et ne peut pas être annulée.<br>
                        • Les images sont automatiquement optimisées et stockées de manière sécurisée.<br>
                        • Les champs marqués d'un * sont obligatoires.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Effets décoratifs -->
    <div class="fixed -bottom-32 -left-32 w-64 h-64 bg-indigo-500 rounded-full mix-blend-multiply filter blur-3xl opacity-5"></div>
    <div class="fixed -top-32 -right-32 w-64 h-64 bg-purple-500 rounded-full mix-blend-multiply filter blur-3xl opacity-5"></div>
</main>

<script>
// Compteur de caractères pour la description
document.getElementById('description').addEventListener('input', function(e) {
    const charCount = e.target.value.length;
    document.getElementById('charCount').textContent = charCount;
    
    // Limiter à 500 caractères
    if (charCount > 500) {
        e.target.value = e.target.value.substring(0, 500);
        document.getElementById('charCount').textContent = 500;
        document.getElementById('charCount').classList.add('text-red-400');
    } else {
        document.getElementById('charCount').classList.remove('text-red-400');
    }
});

// Gestion de l'upload d'image
const uploadArea = document.getElementById('uploadArea');
const imageInput = document.getElementById('imageInput');
const imagePreview = document.getElementById('imagePreview');
const previewImage = document.getElementById('previewImage');

uploadArea.addEventListener('click', () => {
    imageInput.click();
});

uploadArea.addEventListener('dragover', (e) => {
    e.preventDefault();
    uploadArea.classList.add('border-indigo-500');
    uploadArea.style.backgroundColor = 'rgba(30, 41, 59, 0.5)';
});

uploadArea.addEventListener('dragleave', () => {
    uploadArea.classList.remove('border-indigo-500');
    uploadArea.style.backgroundColor = '';
});

uploadArea.addEventListener('drop', (e) => {
    e.preventDefault();
    uploadArea.classList.remove('border-indigo-500');
    uploadArea.style.backgroundColor = '';
    
    if (e.dataTransfer.files.length) {
        imageInput.files = e.dataTransfer.files;
        previewFile();
    }
});

function previewFile() {
    const file = imageInput.files[0];
    if (file) {
        // Vérifier la taille du fichier (2MB max)
        if (file.size > 2 * 1024 * 1024) {
            alert('Le fichier est trop volumineux. Maximum 2MB.');
            imageInput.value = '';
            return;
        }
        
        // Vérifier le type de fichier
        if (!file.type.match('image.*')) {
            alert('Veuillez sélectionner une image valide.');
            imageInput.value = '';
            return;
        }
        
        const reader = new FileReader();
        reader.onload = (e) => {
            previewImage.src = e.target.result;
            imagePreview.classList.remove('hidden');
        };
        reader.readAsDataURL(file);
    }
}

function removeImage() {
    imageInput.value = '';
    imagePreview.classList.add('hidden');
}

// Confirmation de suppression
// function confirmDelete() {
//     const productName = document.getElementById('nom').value;
//     if (confirm(`Êtes-vous sûr de vouloir supprimer "${productName}" ? Cette action est irréversible.`)) {
//         // Créer un formulaire de suppression caché
//         const form = document.createElement('form');
//         form.method = 'POST';
//         form.action = `{{ route('destroy_produit', $produit->id) }}`;
//         form.style.display = 'none';
        
//         const csrfInput = document.createElement('input');
//         csrfInput.type = 'hidden';
//         csrfInput.name = '_token';
//         csrfInput.value = '{{ csrf_token() }}';
        
//         const methodInput = document.createElement('input');
//         methodInput.type = 'hidden';
//         methodInput.name = '_method';
//         methodInput.value = 'DELETE';
        
//         form.appendChild(csrfInput);
//         form.appendChild(methodInput);
//         document.body.appendChild(form);
//         form.submit();
//     }
// }

// Style pour cacher la scrollbar
const style = document.createElement('style');
style.textContent = `
    .hide-scroll {
        -ms-overflow-style: none;
        scrollbar-width: none;
    }
    .hide-scroll::-webkit-scrollbar {
        display: none;
    }
    
    /* Animation pour les champs */
    input, textarea, button, a {
        transition: all 0.2s ease;
    }
`;
document.head.appendChild(style);
</script>
@endsection