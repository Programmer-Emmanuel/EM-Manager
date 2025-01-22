@extends('dashboard_base')

@section('main')
<main class="flex-1 p-8 bg-slate-900 text-white shadow-md overflow-hidden relative">
<div class="absolute inset-0 overflow-y-auto hide-scroll p-5 ">
    <!-- Titre principal -->
    <header class="mb-8">
        <h1 class="text-2xl font-bold text-white">Gestion des Employés</h1>
        <p class="text-slate-400 italic">Visualisez, gérez et mettez à jour les informations des employés de votre entreprise.</p>
    </header>

    <!-- Actions rapides -->
    <section class="mb-8">
        <h2 class="text-xl font-bold mb-4 underline">Actions rapides</h2>
        <div class="flex m-auto flex-wrap gap-4 items-center">
            <a href="{{ route('ajout_employe') }}" 
                class="bg-slate-800 text-white px-6 py-3 rounded-lg shadow hover:bg-slate-700 transition w-56">
                <i class="fas fa-user-plus"></i> Ajouter un Employé
            </a>
            <a href="{{ route('export_employe') }}" 
                class="bg-slate-800 text-white px-6 py-3 rounded-lg shadow hover:bg-slate-700 transition w-56">
                <i class="fas fa-file-export"></i> Exporter la Liste
            </a>

        </div>
    </section>

    <!-- Liste des employés -->
    <section>
        <h2 class="text-xl font-bold mb-4">Liste des Employés</h2>
        <div class="overflow-x-auto bg-slate-800 p-6 rounded-lg shadow-md">
            <table class="min-w-full table-auto border-collapse border border-slate-700">
                <thead class="bg-slate-700 text-slate-300">
                    <tr>
                        <th class="px-2 py-1 border border-slate-600 text-sm" style="width: 200px;">Nom complet</th>
                        <th class="px-2 py-1 border border-slate-600 text-sm">Matricule</th>
                        <th class="px-2 py-1 border border-slate-600 text-sm">Email</th>
                        <th class="px-2 py-1 border border-slate-600 text-sm">Telephone</th>
                        <th class="px-2 py-1 border border-slate-600 text-sm">Poste</th>
                        <th class="px-2 py-1 border border-slate-600 text-sm">Département</th>
                        <th class="px-2 py-1 border border-slate-600 text-sm">Date d’embauche</th>
                        <th class="px-2 py-1 border border-slate-600 text-sm" style="width: 100px;">Salaire employé</th>
                        <th class="px-2 py-1 border border-slate-600 text-sm" style="width: 150px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($employes as $employe)
                    <tr>
                        <td class="px-2 py-1 border border-slate-600 text-xs italic text-center">{{ $employe->nom_employe }} {{ $employe->prenom_employe }}</td>
                        <td class="px-2 py-1 border border-slate-600 text-xs italic text-center">{{ $employe->matricule_employe }}</td>
                        <td class="px-2 py-1 border border-slate-600 text-xs italic text-center">{{ $employe->email_employe }}</td>
                        <td class="px-2 py-1 border border-slate-600 text-xs italic text-center">{{ $employe->telephone }}</td>
                        <td class="px-2 py-1 border border-slate-600 text-xs italic text-center">{{ $employe->poste }}</td>
                        <td class="px-2 py-1 border border-slate-600 text-xs italic text-center">{{ $employe->departement }}</td>
                        <td class="px-2 py-1 border border-slate-600 text-xs italic text-center">{{ $employe->date_embauche }}</td>
                        <td class="px-2 py-1 border border-slate-600 text-xs italic text-center">
                        {{ number_format($employe->salaire, 0, ',', ' ') }} F
                        </td>
                        <td class="px-2 py-1 border border-slate-600 text-xs italic">
                        <a href="{{ route('edit_employe', Crypt::encrypt($employe->id)) }}" class="text-yellow-500 hover:text-yellow-700 font-bold">
                            <i class="fas fa-edit"></i> Modifier
                        </a>

                            <form action="{{ route('destroy_employe', Crypt::encryptString($employe->id)) }}" method="POST" class="inline-block" onsubmit="return confirmDelete()" style="margin-top: 10px;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-700 italic font-bold">
                                    <i class="fas fa-trash"></i> Supprimer
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </section>
</div>
</main>

<script>
    function confirmDelete() {
        return confirm('Êtes-vous sûr de vouloir supprimer cet employé ? Cette action est irréversible.');
    }
</script>

@endsection
