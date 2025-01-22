@extends('dashboard_base')

@section('main')
<main class="flex-1 p-8 bg-slate-900 text-white shadow-md overflow-hidden relative">
    <div class="absolute inset-0 overflow-y-auto hide-scroll p-5 ">
        <!-- Titre principal -->
        <header class="mb-8">
            <h1 class="text-2xl font-bold text-white">Gestion des Congés</h1>
            <p class="text-slate-400 italic">Approuvez ou rejetez les demandes de congé soumises par vos employés.</p>
        </header>

        <!-- Liste des demandes de congés -->
        <section>
            <h2 class="text-xl font-bold mb-4">Demandes de Congés</h2>
            @if($conges->isEmpty())
                <p class="text-slate-400 italic">Aucune demande de congé à traiter.</p>
            @else
                <div class="overflow-x-auto bg-slate-800 p-6 rounded-lg shadow-md">
                    <table class="min-w-full table-auto border-collapse border border-slate-700">
                    <thead class="bg-slate-700 text-slate-300">
    <tr>
        <th class="px-2 py-1 border border-slate-600 text-sm">Employé</th>
        <th class="px-2 py-1 border border-slate-600 text-sm">Type de Congé</th>
        <th class="px-2 py-1 border border-slate-600 text-sm">Date de Début</th>
        <th class="px-2 py-1 border border-slate-600 text-sm">Date de Fin</th>
        <th class="px-2 py-1 border border-slate-600 text-sm">Durée</th>
        <th class="px-2 py-1 border border-slate-600 text-sm">Statut</th>
        <th class="px-2 py-1 border border-slate-600 text-sm">Actions</th>
    </tr>
</thead>
<tbody>
    @foreach($conges as $conge)
    <tr>
        <td class="px-2 py-1 border border-slate-600 text-xs italic text-center">
            {{$conge->nom_employe}} {{$conge->prenom_employe}}
        </td>
        <td class="px-2 py-1 border border-slate-600 text-xs italic text-center">{{ $conge->type_conge }}</td>
        <td class="px-2 py-1 border border-slate-600 text-xs italic text-center">{{ $conge->date_debut }}</td>
        <td class="px-2 py-1 border border-slate-600 text-xs italic text-center">{{ $conge->date_fin }}</td>
        <td class="px-2 py-1 border border-slate-600 text-xs italic text-center">{{ $conge->duree }}</td>
        <td class="px-2 py-1 border border-slate-600 text-xs italic text-center">
            @if($conge->statut == 'Approuvé')
                <span class="text-green-500 font-semibold">Approuvé</span>
            @elseif($conge->statut == 'Rejeté')
                <span class="text-red-500 font-semibold">Rejeté</span>
            @else
                <span class="text-yellow-500 font-semibold">En attente...</span>
            @endif
        </td>
        <td class="px-2 py-1 border border-slate-600 text-xs italic text-center">
            @if($conge->statut == 'En attente...')
            <div class="flex justify-center gap-2">
                <form action="{{ route('conge_approuver', $conge->id) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="text-green-500 hover:text-green-700">
                        <i class="fas fa-check"></i> Approuver
                    </button>
                </form>
                <form action="{{ route('conge_rejeter', $conge->id) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="text-red-500 hover:text-red-700">
                        <i class="fas fa-times"></i> Rejeter
                    </button>
                </form>
                </div>
                @else
                <span class="text-slate-400 italic">Aucune action requise</span>
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
