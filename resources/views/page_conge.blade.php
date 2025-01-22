@extends('employe_dashboard_base')

@section('main')
<main class="flex-1 p-8 bg-slate-900 text-white shadow-md overflow-hidden relative">
<div class="absolute inset-0 overflow-y-auto hide-scroll p-5 ">
    <!-- Titre principal -->
    <header class="mb-8">
        <h1 class="text-2xl font-bold text-white">Mes Demandes de Congé</h1>
        <p class="text-slate-400 italic">Consultez vos demandes de congé et soumettez-en de nouvelles.</p>
    </header>

    <!-- Actions rapides -->
    <section class="mb-8">
        <h2 class="text-xl font-bold mb-4 underline">Actions rapides</h2>
        <div class="flex m-auto flex-wrap gap-4 items-center">
            <a href="{{route('demande_conge')}}" 
                class="bg-slate-800 text-white px-6 py-3 rounded-lg shadow hover:bg-slate-700 transition w-56">
                <i class="fas fa-paper-plane"></i> Nouvelle Demande
            </a>
        </div>
    </section>

    <!-- Liste des demandes de congé -->
    <section>
        <h2 class="text-xl font-bold mb-4">Historique des Congés</h2>
        @if($conges->isEmpty())
            <p class="text-slate-400 italic">Aucune demande de congé trouvée.</p>
        @else
            <div class="overflow-x-auto bg-slate-800 p-6 rounded-lg shadow-md">
                <table class="min-w-full table-auto border-collapse border border-slate-700">
                    <thead class="bg-slate-700 text-slate-300">
                        <tr>
                            <th class="px-2 py-1 border border-slate-600 text-sm">Type de Congé</th>
                            <th class="px-2 py-1 border border-slate-600 text-sm">Date de Début</th>
                            <th class="px-2 py-1 border border-slate-600 text-sm">Date de Fin</th>
                            <th class="px-2 py-1 border border-slate-600 text-sm">Statut</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($conges as $conge)
                        <tr>
                            <td class="px-2 py-1 border border-slate-600 text-xs italic text-center">{{ $conge->type_conge }}</td>
                            <td class="px-2 py-1 border border-slate-600 text-xs italic text-center">{{ $conge->date_debut }}</td>
                            <td class="px-2 py-1 border border-slate-600 text-xs italic text-center">{{ $conge->date_fin }}</td>
                            <td class="px-2 py-1 border border-slate-600 text-xs italic text-center">
                                @if($conge->statut == 'Approuvé')
                                    <span class="text-green-500 font-semibold">Approuvé</span>
                                @elseif($conge->statut == 'Rejeté')
                                    <span class="text-red-500 font-semibold">Rejeté</span>
                                @else
                                    <span class="text-yellow-500 font-semibold">En attente</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </section>
</div>
</main>
@endsection
