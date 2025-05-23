@extends('dashboard_base')

@section('main')
    <main class="flex-1 p-8 bg-slate-900 text-white shadow-md overflow-hidden relative">
        <div class="absolute inset-0 overflow-y-auto hide-scroll p-5 ">
            <h1 class="text-3xl font-bold">Bienvenue sur votre l’historique de vos transactions</h1>
        <p class="text-md text-slate-500 italic">Ici vous verrez combien vous avez dépensé, votre revenus et l’historique de vos transactions.</p>
        <div class="flex flex-wrap justify-between items-center">
            @php
                $montant = $comptes->first()->montant ?? null;
                if ($montant === null) {
                    $colorClass = ''; // pas de couleur si non dispo
                } elseif ($montant < 0) {
                    $colorClass = 'text-red-500'; // rouge
                    $texte = "Vous n’avez pas un bon revenu. Vous perdez de l’argent !";
                } elseif ($montant == 0) {
                    $colorClass = 'text-white';   // blanc
                    $texte = "";
                } else {
                    $colorClass = 'text-green-500'; // vert
                    $texte = "Vous avez un bon bénéfice. Vous gagnez de l’argent !";
                }
            @endphp

            <h1 class="text-2xl mt-5 font-semibold text-white bg-slate-800 px-4 py-2 rounded-lg shadow-md inline-block">
                <span class=" font-bold mr-2">Bénéfice du compte:</span>
                <span class="{{ $colorClass }}">
                    {{ $montant !== null ? number_format($montant, 0, ',', ' ') : 'Non disponible' }} FCFA
                </span>
            </h1>


            <a href="{{ route('transactions')}}" class="bg-slate-800 hover:bg-slate-950 p-2 rounded-full flex items-center gap-2 mt-5">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m3.75 9v6m3-3H9m1.5-12H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                </svg>
                <p>Ajouter une transaction</p>
            </a>
        </div>
        <p class="text-slate-500 italic">{{$texte}}</p>
        <div class="mt-8 space-y-3">
            @foreach ($transactions as $transaction)
                <div class="flex flex-col sm:flex-row sm:items-center justify-between p-4 rounded-lg border
                    @if($transaction->type == 'Achat') border-red-600 bg-red-900 text-red-100
                    @elseif($transaction->type == 'Vente') border-green-600 bg-green-900 text-green-100
                    @else border-gray-600 bg-slate-800 text-white
                    @endif
                    shadow-sm
                ">
                    <span class="flex-1 font-semibold text-lg mb-1 sm:mb-0">{{ $transaction->motif }}</span>

                    <span class="sm:w-24 text-center font-semibold uppercase tracking-wide mb-1 sm:mb-0">
                        @if($transaction->type == 'Achat')
                            Achat
                        @elseif($transaction->type == 'Vente')
                            Vente
                        @else
                            {{ $transaction->type }}
                        @endif
                    </span>

                    <span class="sm:w-36 text-right font-bold text-lg">{{ number_format($transaction->montant, 0, ',', ' ') }} FCFA</span>

                    <span class="sm:w-44 text-right text-sm text-slate-300 mt-1 sm:mt-0 font-semibold">{{ $transaction->created_at->format('d/m/Y H:i') }}</span>
                </div>
            @endforeach

            @if ($transactions->isEmpty())
                <p class="italic text-slate-500 mt-4">Aucune transaction pour le moment.</p>
            @endif
        </div>

        </div>

    </main>
@endsection