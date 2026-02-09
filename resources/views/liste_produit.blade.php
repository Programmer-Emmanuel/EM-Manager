@extends('dashboard_base')

@section('main')
<main class="flex-1 p-6 bg-slate-900 text-white overflow-hidden relative">
    <div class="absolute inset-0 overflow-y-auto hide-scroll p-6">
        <!-- Header avec titre, recherche et boutons d'action -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 p-6 bg-slate-800/90 backdrop-blur-sm rounded-xl border border-slate-700/50 shadow-lg">
            <div class="mb-4 md:mb-0">
                <h1 class="text-2xl font-bold text-white">Gestion des Produits</h1>
                <p class="text-slate-400">Liste de tous vos produits</p>
            </div>
            
            <div class="flex flex-col sm:flex-row items-stretch sm:items-center w-full md:w-auto">
                <!-- Barre de recherche -->
                <div class="relative p-5">
                    <input type="text" 
                           id="searchInput"
                           class="w-full sm:w-64 pl-4 pr-4 py-3 bg-slate-700/50 border border-slate-600 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-300"
                           placeholder=" Rechercher un produit...">
                </div>
                
                <a href="{{ route('ajout_produit') }}" 
                   class="bg-indigo-600 hover:bg-indigo-700 text-white pl-4 pr-3 py-3 rounded-lg flex items-center justify-center gap-2 transition-all duration-300 hover:shadow-lg hover:shadow-indigo-500/25 whitespace-nowrap font-medium">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    <span>Ajouter un produit</span>
                </a>
            </div>
        </div>

        <!-- Statistiques -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8 px-6">
            <div class="bg-slate-800/90 backdrop-blur-sm rounded-xl p-6 border border-slate-700/50 shadow-lg hover:border-indigo-500/30 transition-all duration-300">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-400 text-sm font-medium">Total Produits</p>
                        <p class="text-2xl font-bold text-white mt-2" id="totalCount">{{ $produits->count() }}</p>
                    </div>
                    <div class="p-3 bg-indigo-500/20 rounded-xl">
                        <svg class="w-7 h-7 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-slate-800/90 backdrop-blur-sm rounded-xl p-6 border border-slate-700/50 shadow-lg hover:border-emerald-500/30 transition-all duration-300">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-400 text-sm font-medium">Avec Images</p>
                        <p class="text-2xl font-bold text-white mt-2" id="withImagesCount">
                            {{ $produits->whereNotNull('image')->count() }}
                        </p>
                    </div>
                    <div class="p-3 bg-emerald-500/20 rounded-xl">
                        <svg class="w-7 h-7 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-slate-800/90 backdrop-blur-sm rounded-xl p-6 border border-slate-700/50 shadow-lg hover:border-amber-500/30 transition-all duration-300">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-400 text-sm font-medium">Dernier ajout</p>
                        <p class="text-lg font-semibold text-white mt-2" id="lastAdded">
                            @if($produits->count() > 0)
                                {{ $produits->first()->created_at->diffForHumans() }}
                            @else
                                Aucun produit
                            @endif
                        </p>
                    </div>
                    <div class="p-3 bg-amber-500/20 rounded-xl">
                        <svg class="w-7 h-7 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tableau des produits -->
        <div class="bg-slate-800/90 backdrop-blur-sm rounded-xl border border-slate-700/50 shadow-lg overflow-hidden mx-6 mb-6">
            <div class="overflow-x-auto hide-scrollbar">
                <table class="w-full min-w-max">
                    <thead class="bg-slate-900/80 text-slate-300">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider">Produit</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider">Description</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider">Date d'ajout</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-700/50" id="productsTable">
                        @forelse($produits as $produit)
                        <tr class="hover:bg-slate-750/50 transition-all duration-300 product-row" 
                            data-name="{{ strtolower($produit->nom) }}"
                            data-image="{{ $produit->image ? 'true' : 'false' }}">
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    @if($produit->image)
                                    <div class="flex-shrink-0 h-12 w-12 rounded-lg overflow-hidden border border-slate-600">
                                        <img class="h-full w-full object-cover" 
                                             src="{{ $produit->image }}" 
                                             alt="{{ $produit->nom }}">
                                    </div>
                                    @else
                                    <div class="flex-shrink-0 h-12 w-12 bg-slate-700 rounded-lg flex items-center justify-center border border-slate-600">
                                        <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                    </div>
                                    @endif
                                    <div class="ml-4">
                                        <div class="text-sm font-semibold text-white">{{ $produit->nom }}</div>
                                        @if($produit->categorie)
                                        <div class="text-xs text-slate-400 mt-1">
                                            <span class="px-2 py-1 bg-slate-700/50 rounded-full">{{ $produit->categorie }}</span>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-300 max-w-xs">
                                    {{ Str::limit($produit->description, 120) }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">
                                {{ $produit->created_at->format('d/m/Y') }}
                                <div class="text-xs text-slate-400">{{ $produit->created_at->format('H:i') }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex items-center gap-3">
                                    <a href="{{ route('edit_produit', $produit->id) }}" 
                                       class="text-amber-400 hover:text-amber-300 transition-colors p-2 hover:bg-amber-500/10 rounded-lg"
                                       title="Modifier">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                  d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                    </a>
                                    <form action="{{ route('destroy_produit', $produit->id) }}" 
                                          method="POST" 
                                          onsubmit="return confirmDelete(event, '{{ $produit->nom }}')"
                                          class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="text-red-400 hover:text-red-300 transition-colors p-2 hover:bg-red-500/10 rounded-lg"
                                                title="Supprimer">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                      d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-6 py-16 text-center">
                                <div class="max-w-md mx-auto">
                                    <div class="w-20 h-20 mx-auto mb-6 bg-slate-700/50 rounded-full flex items-center justify-center">
                                        <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                                        </svg>
                                    </div>
                                    <h3 class="text-xl font-semibold text-white mb-2">Aucun produit</h3>
                                    <p class="text-slate-400 mb-6">Commencez par ajouter votre premier produit.</p>
                                    <a href="{{ route('ajout_produit') }}" 
                                       class="inline-flex items-center gap-2 px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-lg transition-all duration-300 hover:shadow-lg hover:shadow-indigo-500/25">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                        </svg>
                                        Ajouter un produit
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>

<!-- Script pour la suppression et recherche -->
<script>
function confirmDelete(event, productName) {
    event.preventDefault();
    
    if (confirm(`Êtes-vous sûr de vouloir supprimer "${productName}" ? Cette action est irréversible.`)) {
        event.target.closest('form').submit();
    }
}

// Fonction de recherche
document.getElementById('searchInput')?.addEventListener('input', function(e) {
    const searchTerm = e.target.value.toLowerCase();
    const rows = document.querySelectorAll('.product-row');
    let visibleCount = 0;
    let withImagesCount = 0;
    let lastAdded = '';
    
    rows.forEach(row => {
        const productName = row.getAttribute('data-name');
        const hasImage = row.getAttribute('data-image') === 'true';
        
        if (productName.includes(searchTerm)) {
            row.classList.remove('hidden');
            row.style.opacity = '1';
            row.style.transform = 'translateX(0)';
            visibleCount++;
            
            if (hasImage) {
                withImagesCount++;
            }
            
            // Récupérer la date du dernier ajout visible
            if (visibleCount === 1) {
                const dateCell = row.querySelector('td:nth-child(3)');
                if (dateCell) {
                    lastAdded = dateCell.textContent.split('\n')[0].trim();
                }
            }
        } else {
            row.classList.add('hidden');
            row.style.opacity = '0';
            row.style.transform = 'translateX(-20px)';
        }
    });
    
    // Mettre à jour les statistiques
    const totalCount = document.getElementById('totalCount');
    const withImagesCountElement = document.getElementById('withImagesCount');
    const lastAddedElement = document.getElementById('lastAdded');
    
    if (totalCount) totalCount.textContent = visibleCount;
    if (withImagesCountElement) withImagesCountElement.textContent = withImagesCount;
    
    if (visibleCount > 0 && lastAddedElement) {
        lastAddedElement.textContent = lastAdded;
    } else if (lastAddedElement) {
        lastAddedElement.textContent = 'Aucun produit';
    }
});

// Ajouter la classe pour cacher la scrollbar
document.addEventListener('DOMContentLoaded', function() {
    const style = document.createElement('style');
    style.textContent = `
        .hide-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
        .hide-scrollbar::-webkit-scrollbar {
            display: none;
        }
        
        /* Animation pour les lignes du tableau */
        .product-row {
            transition: all 0.3s ease;
        }
        
        /* Style pour les boutons hover */
        button, a {
            transition: all 0.2s ease;
        }
        
        /* Style pour les statistiques */
        [id$="Count"], #lastAdded {
            transition: transform 0.3s ease;
        }
    `;
    document.head.appendChild(style);
    
    // Initialiser les animations
    const rows = document.querySelectorAll('.product-row');
    rows.forEach((row, index) => {
        row.style.animationDelay = `${index * 0.05}s`;
        row.style.animation = 'slideIn 0.5s ease forwards';
        row.style.opacity = '0';
    });
    
    // Définir l'animation slideIn
    const animationStyle = document.createElement('style');
    animationStyle.textContent = `
        @keyframes slideIn {
            from { 
                opacity: 0; 
                transform: translateY(10px); 
            }
            to { 
                opacity: 1; 
                transform: translateY(0); 
            }
        }
    `;
    document.head.appendChild(animationStyle);
});
</script>
@endsection