{{-- resources/views/employe/upload_files.blade.php --}}
@extends('dashboard_base')

@section('main')
<main class="flex-1 bg-slate-900 text-white overflow-hidden relative">
    <div class="absolute inset-0 overflow-y-auto hide-scroll p-6">
        <!-- En-tête -->
        <div class="mb-8">
            <h1 class="text-2xl font-bold text-white mb-2 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                </svg>
                Documents de {{ $employe->prenom_employe }} {{ $employe->nom_employe }}
            </h1>
            <p class="text-slate-400">Ajoutez des documents (images, PDF, Word, Excel, etc.) - Étape facultative</p>
        </div>

        <!-- Zone de drag and drop -->
        <div class="bg-slate-800/50 backdrop-blur-sm rounded-xl border border-slate-700/50 shadow-xl overflow-hidden mb-6">
            <div class="p-6">
                <div id="dropzone" 
                     class="border-2 border-dashed border-slate-600 rounded-lg p-8 text-center hover:border-indigo-500 transition-all duration-300 cursor-pointer"
                     ondragover="event.preventDefault()"
                     ondragenter="event.preventDefault()">
                    <input type="file" id="fileInput" multiple style="display: none;" accept=".jpg,.jpeg,.png,.gif,.pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.txt">
                    <div class="flex flex-col items-center gap-4">
                        <svg class="w-16 h-16 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                        </svg>
                        <div>
                            <p class="text-lg font-medium">Glissez-déposez vos fichiers ici</p>
                            <p class="text-sm text-slate-400 mt-1">ou cliquez pour sélectionner</p>
                        </div>
                        <div class="flex gap-2 text-xs text-slate-500">
                            <span>📷 Images (JPG, PNG, GIF)</span>
                            <span>📄 Documents (PDF, Word, Excel)</span>
                            <span>📦 Max 10MB par fichier</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Liste des fichiers uploadés -->
        <div class="bg-slate-800/50 backdrop-blur-sm rounded-xl border border-slate-700/50 shadow-xl overflow-hidden">
            <div class="p-6">
                <h2 class="text-xl font-semibold text-white mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Fichiers ajoutés
                    <span id="fileCount" class="text-sm text-slate-400">(0)</span>
                </h2>
                
                <div id="fileList" class="space-y-3">
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
                            <button onclick="deleteFile('{{ $dossier->id }}')" class="text-red-400 hover:text-red-300 transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                            </button>
                        </div>
                    @endforeach
                </div>
                
                <div id="uploadingIndicator" class="hidden mt-4 text-center">
                    <div class="flex items-center justify-center gap-2">
                        <svg class="animate-spin h-5 w-5 text-indigo-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                        </svg>
                        <span class="text-slate-300">Upload en cours...</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Boutons d'action -->
        <div class="mt-6 flex gap-4">
            <button id="finishBtn" 
                    class="flex-1 py-3 px-4 bg-gradient-to-r from-indigo-600 to-indigo-700 text-white font-medium rounded-lg hover:from-indigo-700 hover:to-indigo-800 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 focus:ring-offset-slate-800 transition-all duration-200 flex items-center justify-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                Terminer
            </button>
            <a href="{{ route('employe.skip_upload', $employe->id) }}" 
               class="flex-1 py-3 px-4 bg-slate-700 text-white font-medium rounded-lg hover:bg-slate-600 focus:outline-none focus:ring-2 focus:ring-slate-500 focus:ring-offset-2 focus:ring-offset-slate-800 transition-all duration-200 flex items-center justify-center gap-2 text-center">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
                Passer cette étape
            </a>
        </div>
    </div>

    <!-- Effets décoratifs -->
    <div class="fixed -bottom-32 -left-32 w-64 h-64 bg-indigo-500 rounded-full mix-blend-multiply filter blur-3xl opacity-5"></div>
    <div class="fixed -top-32 -right-32 w-64 h-64 bg-purple-500 rounded-full mix-blend-multiply filter blur-3xl opacity-5"></div>
</main>

<script>
let uploadedFiles = [];

document.addEventListener("DOMContentLoaded", function() {
    const dropzone = document.getElementById('dropzone');
    const fileInput = document.getElementById('fileInput');
    const finishBtn = document.getElementById('finishBtn');
    
    // Click sur la zone pour ouvrir le sélecteur de fichiers
    dropzone.addEventListener('click', () => {
        fileInput.click();
    });
    
    // Drag and drop
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
        uploadFiles(files);
    });
    
    // Sélection de fichiers
    fileInput.addEventListener('change', (e) => {
        const files = Array.from(e.target.files);
        uploadFiles(files);
    });
    
    // Bouton terminer
    finishBtn.addEventListener('click', () => {
        window.location.href = "{{ route('liste_employe') }}";
    });
});

function uploadFiles(files) {
    if (files.length === 0) return;
    
    const formData = new FormData();
    files.forEach(file => {
        formData.append('files[]', file);
    });
    
    const indicator = document.getElementById('uploadingIndicator');
    indicator.classList.remove('hidden');
    
    fetch("{{ route('employe.upload_files.post', $employe->id) }}", {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            data.files.forEach(file => {
                addFileToList(file);
            });
            updateFileCount();
        }
        indicator.classList.add('hidden');
    })
    .catch(error => {
        console.error('Error:', error);
        indicator.classList.add('hidden');
        alert('Erreur lors de l\'upload des fichiers');
    });
}

function addFileToList(file) {
    const fileList = document.getElementById('fileList');
    const fileDiv = document.createElement('div');
    fileDiv.className = 'file-item flex items-center justify-between p-3 bg-slate-700/30 rounded-lg border border-slate-700/50';
    fileDiv.setAttribute('data-id', file.id);
    
    const fileIcon = file.type === 'image' ? 
        '<svg class="w-8 h-8 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>' :
        '<svg class="w-8 h-8 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>';
    
    fileDiv.innerHTML = `
        <div class="flex items-center gap-3">
            <div class="flex-shrink-0">
                ${fileIcon}
            </div>
            <div>
                <p class="font-medium text-white">${file.nom_fichier}</p>
                <p class="text-xs text-slate-400">${file.type}</p>
            </div>
        </div>
        <button onclick="deleteFile('${file.id}')" class="text-red-400 hover:text-red-300 transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
            </svg>
        </button>
    `;
    
    fileList.appendChild(fileDiv);
}

function updateFileCount() {
    const fileCount = document.querySelectorAll('.file-item').length;
    document.getElementById('fileCount').textContent = `(${fileCount})`;
}

function deleteFile(fileId) {
    if (confirm('Voulez-vous vraiment supprimer ce fichier ?')) {
        fetch(`/employe/{{ $employe->id }}/file/${fileId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const fileElement = document.querySelector(`.file-item[data-id="${fileId}"]`);
                if (fileElement) {
                    fileElement.remove();
                    updateFileCount();
                }
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Erreur lors de la suppression du fichier');
        });
    }
}
</script>
@endsection