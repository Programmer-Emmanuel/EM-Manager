@extends('dashboard_base')

@section('main')
<main class="flex-1 bg-slate-900 text-white overflow-hidden relative">
    <div class="absolute inset-0 overflow-y-auto hide-scroll p-5">
        <div class="inset-0 overflow-y-auto hide-scroll p-5 ">
        <!-- En-tête -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-white mb-2">Historique de vos transactions</h1>
            <p class="text-slate-400 italic">Consultez vos dépenses, revenus et l'historique complet de vos transactions.</p>
        </div>

        <!-- Statistiques et actions -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6 mb-8">
            <!-- Bénéfice du compte -->
            <div class="bg-slate-800/50 backdrop-blur-sm p-4 rounded-xl border border-slate-700/50 shadow-md">
                @php
                    $montant = $comptes->first()->montant ?? null;
                    if ($montant === null) {
                        $colorClass = 'text-slate-400';
                        $texte = "Aucune donnée disponible";
                    } elseif ($montant < 0) {
                        $colorClass = 'text-red-400';
                        $texte = "Attention : votre solde est négatif";
                    } elseif ($montant == 0) {
                        $colorClass = 'text-slate-300';
                        $texte = "Votre solde est neutre";
                    } else {
                        $colorClass = 'text-green-400';
                        $texte = "Excellent ! Votre solde est positif";
                    }
                @endphp

                <div class="flex items-center gap-3">
                    <div class="p-2 bg-slate-700 rounded-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm text-slate-400">Bénéfice du compte</p>
                        <p class="text-xl font-bold {{ $colorClass }}">
                            {{ $montant !== null ? number_format($montant, 0, ',', ' ') . ' FCFA' : 'N/A' }}
                        </p>
                    </div>
                </div>
                <p class="mt-2 text-sm {{ $colorClass }} italic">{{ $texte }}</p>
            </div>

            <!-- Bouton Ajouter -->
            <a href="{{ route('transactions') }}" class="flex items-center gap-2 bg-gradient-to-r from-slate-700/50 to-slate-800/50 hover:from-slate-700 hover:to-slate-800 text-white px-4 py-3 rounded-lg border border-slate-700/50 transition-all duration-200">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Nouvelle transaction
            </a>
        </div>

        <!-- Liste des transactions -->
        <div class="space-y-3">
            @forelse ($transactions as $transaction)
                <div class="group flex flex-col sm:flex-row items-start sm:items-center justify-between p-4 rounded-lg border border-slate-700/50 bg-slate-800/30 hover:bg-slate-800/50 backdrop-blur-sm transition-all duration-200">
                    <div class="flex-1 flex items-center gap-3 mb-2 sm:mb-0">
                        <div class="p-2 rounded-lg 
                            @if($transaction->type == 'Sortie') bg-red-900/30 border border-red-800/50
                            @elseif($transaction->type == 'Entrée') bg-green-900/30 border border-green-800/50
                            @else bg-slate-700/30 border border-slate-700/50
                            @endif">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 
                                @if($transaction->type == 'Sortie') text-red-400
                                @elseif($transaction->type == 'Entrée') text-green-400
                                @else text-slate-400
                                @endif" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                @if($transaction->type == 'Sortie')
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                @elseif($transaction->type == 'Entrée')
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                @else
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                                @endif
                            </svg>
                        </div>
                        <div>
                            <p class="font-semibold text-white">{{ $transaction->motif }}</p>
                            <p class="text-xs text-slate-400">{{ $transaction->created_at->format('d/m/Y H:i') }}</p>
                        </div>
                    </div>

                    <div class="flex items-center gap-4">
                        <span class="px-3 py-1 rounded-full text-xs font-semibold 
                            @if($transaction->type == 'Sortie') bg-red-900/30 text-red-400
                            @elseif($transaction->type == 'Entrée') bg-green-900/30 text-green-400
                            @else bg-slate-700/30 text-slate-400
                            @endif">
                            {{ $transaction->type }}
                        </span>
                        
                        <span class="font-bold 
                            @if($transaction->type == 'Sortie') text-red-400
                            @elseif($transaction->type == 'Entrée') text-green-400
                            @else text-white
                            @endif">
                            {{ number_format($transaction->montant, 0, ',', ' ') }} FCFA
                        </span>
                    </div>
                </div>
            @empty
                <div class="text-center py-8">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <p class="mt-2 text-slate-400">Aucune transaction enregistrée</p>
                    <a href="{{ route('transactions') }}" class="mt-4 inline-block text-slate-300 hover:text-white underline">Ajouter une transaction</a>
                </div>
            @endforelse
        </div>
    </div>
    </div>

    <!-- Effets décoratifs -->
    <div class="fixed -bottom-32 -left-32 w-64 h-64 bg-indigo-500 rounded-full mix-blend-multiply filter blur-3xl opacity-5"></div>
    <div class="fixed -top-32 -right-32 w-64 h-64 bg-purple-500 rounded-full mix-blend-multiply filter blur-3xl opacity-5"></div>
</main>
@endsection