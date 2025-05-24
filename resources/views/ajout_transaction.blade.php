@extends('dashboard_base')
@include('aos')

@section('main')
<main class="flex-1 bg-slate-900 text-white overflow-hidden relative">
    <div class="absolute inset-0 overflow-y-auto hide-scroll p-5">
        <div class="w-full max-w-md mx-auto">
            <!-- Carte du formulaire -->
            <div class="bg-slate-800/50 backdrop-blur-sm rounded-xl border border-slate-700/50 shadow-xl overflow-hidden" data-aos="zoom-in" data-aos-duration="500">
                <!-- En-tête -->
                <div class="relative bg-gradient-to-r from-slate-700/50 to-slate-800/50 p-6 border-b border-slate-700/50">
                    <h2 class="text-center text-xl font-bold text-white">Nouvelle Transaction</h2>
                </div>

                <!-- Contenu -->
                <div class="p-6 space-y-6">
                    <!-- Messages d'erreur -->
                    @if ($errors->any())
                        <div class="mb-4 p-4 text-sm text-white bg-slate-700/30 rounded-lg border border-slate-700/50">
                            <ul class="space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li class="flex items-start">
                                        <svg class="w-4 h-4 mt-0.5 mr-2 text-red-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <span>{{ $error }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- Formulaire -->
                    <form action="#" method="POST" class="space-y-6">
                        @csrf

                        <!-- Champ Motif -->
                        <div>
                            <label for="motif" class="block text-sm font-medium text-slate-400 mb-2">Motif</label>
                            <div class="relative">
                                <input 
                                    type="text" 
                                    name="motif" 
                                    id="motif" 
                                    required
                                    class="w-full p-3 bg-slate-700/30 text-white rounded-lg border border-slate-700/50 focus:outline-none focus:ring-2 focus:ring-slate-500 focus:border-transparent placeholder-slate-500" 
                                    placeholder="Entrez le motif">
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <!-- Champ Type -->
                        <div>
                            <label for="type" class="block text-sm font-medium text-slate-400 mb-2">Type de transaction</label>
                            <div class="relative">
                                <select 
                                    name="type" 
                                    id="type" 
                                    required
                                    class="w-full p-3 bg-slate-900 text-white rounded-lg border border-slate-700/50 focus:outline-none focus:ring-2 focus:ring-slate-500 focus:border-transparent appearance-none">
                                    <option value="Entrée">Entrée</option>
                                    <option value="Sortie">Sortie</option>
                                </select>
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l4-4 4 4m0 6l-4 4-4-4" />
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <!-- Champ Montant -->
                        <div>
                            <label for="montant" class="block text-sm font-medium text-slate-400 mb-2">Montant</label>
                            <div class="relative">
                                <input 
                                    type="number" 
                                    name="montant" 
                                    id="montant" 
                                    required
                                    class="w-full p-3 bg-slate-700/30 text-white rounded-lg border border-slate-700/50 focus:outline-none focus:ring-2 focus:ring-slate-500 focus:border-transparent placeholder-slate-500 [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none" 
                                    placeholder="Montant en FCFA">
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <!-- Bouton de soumission -->
                        <div class="pt-2">
                            <button 
                                type="submit" 
                                class="w-full py-3 px-4 bg-gradient-to-r from-slate-700/50 to-slate-800/50 text-white font-medium rounded-lg border border-slate-700/50 hover:from-slate-700 hover:to-slate-800 focus:outline-none focus:ring-2 focus:ring-slate-500 focus:ring-offset-2 focus:ring-offset-slate-900 transition-all duration-200 flex items-center justify-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                Valider la transaction
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Effets décoratifs -->
    <div class="fixed -bottom-32 -left-32 w-64 h-64 bg-indigo-500 rounded-full mix-blend-multiply filter blur-3xl opacity-5"></div>
    <div class="fixed -top-32 -right-32 w-64 h-64 bg-purple-500 rounded-full mix-blend-multiply filter blur-3xl opacity-5"></div>
</main>

<style>
    /* Animation */
    [data-aos="zoom-in"] {
        opacity: 0;
        transform: scale(0.95);
        transition: opacity 0.6s ease-out, transform 0.6s ease-out;
    }
    
    [data-aos="zoom-in"].aos-animate {
        opacity: 1;
        transform: scale(1);
    }
</style>
@endsection