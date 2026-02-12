@extends('employe_dashboard_base')

@section('main')
<main class="flex-1 overflow-hidden relative bg-gradient-to-br from-slate-900 via-slate-900 to-slate-800">
    <div class="absolute inset-0 overflow-y-auto hide-scroll p-4 md:p-6 lg:p-8">
        <div class="max-w-7xl mx-auto space-y-6 md:space-y-8">
            
            <!-- EN-TÊTE -->
            <div class="relative overflow-hidden">
                <div class="absolute inset-0 bg-gradient-to-r from-blue-600/10 via-purple-600/10 to-pink-600/10 rounded-3xl blur-3xl"></div>
                <div class="relative bg-gradient-to-r from-slate-800/80 via-slate-800/60 to-slate-800/80 backdrop-blur-xl rounded-3xl p-6 md:p-8 border border-slate-700/50 shadow-2xl">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">
                        <div class="flex items-center gap-4">
                            <div class="relative">
                                <div class="absolute inset-0 rounded-2xl blur-xl opacity-50"></div>
                                <div class="relative w-16 h-16  rounded-2xl flex items-center justify-center ">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8 text-white">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 6.375c0 2.278-3.694 4.125-8.25 4.125S3.75 8.653 3.75 6.375 7.444 2.25 12 2.25s8.25 1.847 8.25 4.125Zm0 4.5c0 2.278-3.694 4.125-8.25 4.125S3.75 13.153 3.75 10.875m16.5 0c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125m16.5 4.5c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125" />
                                    </svg>
                                </div>
                            </div>
                            <div>
                                <h1 class="text-2xl md:text-2xl font-bold text-white">
                                    Catalogue produits
                                </h1>
                                <p class="text-slate-400 mt-2 flex items-center gap-2">
                                    <i class="fas fa-building text-slate-400"></i>
                                    {{ $entreprise->nom_entreprise ?? 'Entreprise' }} · 
                                    <span class="text-slate-500">{{ $produits->count() }} produit(s)</span>
                                </p>
                            </div>
                        </div>
                        
                        <div class="flex items-center gap-3 px-4 py-2 bg-slate-700/30 rounded-xl border border-slate-600/50">
                            <i class="fas fa-box text-slate-400"></i>
                            <span class="text-white font-medium">Catalogue entreprise</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- GRILLE DES PRODUITS -->
            @if($produits->isNotEmpty())
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    @foreach($produits as $produit)
                    <div class="group relative bg-gradient-to-br from-slate-800 to-slate-900 rounded-2xl overflow-hidden border border-slate-700 hover:border-slate-500/50 transition-all duration-500 hover:shadow-2xl hover:shadow-slate-500/20">
                        
                        <!-- Image du produit -->
                        <div class="relative h-48 overflow-hidden bg-slate-700">
                            @if($produit->image)
                                <img src="{{ $produit->image }}" 
                                     alt="{{ $produit->nom }}"
                                     class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                            @else
                                <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-slate-700 to-slate-800">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-16 h-16 text-slate-500">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 6.375c0 2.278-3.694 4.125-8.25 4.125S3.75 8.653 3.75 6.375 7.444 2.25 12 2.25s8.25 1.847 8.25 4.125Zm0 4.5c0 2.278-3.694 4.125-8.25 4.125S3.75 13.153 3.75 10.875m16.5 0c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125m16.5 4.5c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125" />
                                    </svg>
                                </div>
                            @endif
                            
                            <!-- Badge date -->
                            <div class="absolute top-3 right-3 px-2 py-1 bg-black/60 backdrop-blur-sm rounded-lg text-xs text-white border border-white/20">
                                {{ $produit->created_at->format('d/m/Y') }}
                            </div>
                        </div>
                        
                        <!-- Informations produit -->
                        <div class="p-5">
                            <h3 class="text-lg font-bold text-white mb-2 line-clamp-1 group-hover:text-slate-400 transition-colors">
                                {{ $produit->nom }}
                            </h3>
                            <p class="text-sm text-slate-400 line-clamp-3 mb-4">
                                {{ $produit->description }}
                            </p>
                            
                            <!-- Footer -->
                            <div class="flex items-center justify-between pt-3 border-t border-slate-700/50">
                                <span class="text-xs text-slate-500 flex items-center gap-1">
                                    <i class="far fa-clock"></i>
                                    {{ $produit->created_at->diffForHumans() }}
                                </span>
                                <span class="px-2 py-1 bg-slate-900/30 text-slate-400 rounded-lg text-xs border border-slate-800/50">
                                    Produit
                                </span>
                            </div>
                        </div>
                        
                        <!-- Hover effect -->
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-600/0 via-slate-600/0 to-slate-600/0 group-hover:from-slate-600/10 group-hover:via-transparent group-hover:to-transparent pointer-events-none transition-all duration-500"></div>
                    </div>
                    @endforeach
                </div>
            @else
                <!-- AUCUN PRODUIT -->
                <div class="bg-gradient-to-br from-slate-800 to-slate-900 rounded-3xl p-12 md:p-16 border border-slate-700 text-center">
                    <div class="relative">
                        <div class="absolute inset-0 bg-slate-500/5 rounded-full blur-3xl"></div>
                        <div class="relative w-28 h-28 bg-slate-900 rounded-full flex items-center justify-center mx-auto mb-6">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-14 h-14 text-slate-400">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 6.375c0 2.278-3.694 4.125-8.25 4.125S3.75 8.653 3.75 6.375 7.444 2.25 12 2.25s8.25 1.847 8.25 4.125Zm0 4.5c0 2.278-3.694 4.125-8.25 4.125S3.75 13.153 3.75 10.875m16.5 0c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125m16.5 4.5c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125" />
                            </svg>
                        </div>
                        <h2 class="text-2xl md:text-3xl font-bold text-white mb-4">
                            Aucun produit disponible
                        </h2>
                        <p class="text-slate-400 max-w-md mx-auto mb-8 text-lg">
                            L'entreprise n'a pas encore ajouté de produits à son catalogue.
                        </p>
                        <div class="inline-flex items-center gap-2 px-6 py-3 bg-slate-700/50 text-slate-300 rounded-xl border border-slate-600">
                            <i class="fas fa-store"></i>
                            <span>Revenez plus tard</span>
                        </div>
                    </div>
                </div>
            @endif

            

        </div>
    </div>
</main>

<!-- Style pour les lignes tronquées -->
<style>
.line-clamp-1 {
    display: -webkit-box;
    -webkit-line-clamp: 1;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
.line-clamp-3 {
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
.hide-scroll {
    scrollbar-width: none;
    -ms-overflow-style: none;
}
.hide-scroll::-webkit-scrollbar {
    display: none;
}
</style>
@endsection