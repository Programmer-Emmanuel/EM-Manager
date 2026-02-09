@extends('dashboard_base')

@section('main')
<main class="flex-1 p-6 bg-slate-900 text-white overflow-hidden relative">
    <div class="absolute inset-0 overflow-y-auto hide-scroll">
        <!-- Header avec titre et boutons d'action -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 p-4 bg-slate-800 rounded-lg shadow">
            <div class="mb-4 md:mb-0">
                <h1 class="text-2xl font-bold text-white">Gestion des Employés</h1>
                <p class="text-slate-400">Gérez efficacement votre équipe</p>
            </div>
            <div class="flex flex-col sm:flex-row gap-3 w-full md:w-auto">
                <a href="{{ route('ajout_employe') }}" 
                   class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center justify-center gap-2 transition-colors">
                    <i class="fas fa-user-plus"></i>
                    <span>Ajouter</span>
                </a>
                <a href="{{ route('export_employe') }}" 
                   class="bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2 rounded-lg flex items-center justify-center gap-2 transition-colors">
                    <i class="fas fa-file-export"></i>
                    <span>Exporter</span>
                </a>
            </div>
        </div>

        <!-- Tableau des employés -->
        <div class="bg-slate-800 rounded-xl shadow-lg overflow-hidden m-6">
            <div class="overflow-x-auto hide-scroll">
                <table class="w-full">
                    <thead class="bg-slate-700 text-slate-300">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Nom complet</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Matricule</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Poste</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Département</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Contact</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Salaire</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Début</th>
                            <th class="px-6 py-3 text-right text-xs font-medium uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-700">
                        @foreach($employes as $employe)
                        <tr class="hover:bg-slate-750 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10 bg-slate-600 rounded-full flex items-center justify-center">
                                        <span class="text-sm font-medium">{{ substr($employe->prenom_employe, 0, 1) }}{{ substr($employe->nom_employe, 0, 1) }}</span>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium">{{ $employe->prenom_employe }} {{ $employe->nom_employe }}</div>
                                        <div class="text-xs text-slate-400">{{ $employe->email_employe }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $employe->matricule_employe }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $employe->poste }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $employe->departement }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <div class="text-sm">{{ $employe->telephone }}</div>
                                <div class="text-xs text-slate-400">{{ $employe->email_employe }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-right font-medium">
                                {{ number_format($employe->salaire, 0, ',', ' ') }} F
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                {{ $employe->date_embauche }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex justify-end space-x-3">
                                    <a href="{{ route('edit_employe', $employe->id) }}" 
                                       class="text-blue-400 hover:text-blue-300 transition-colors"
                                       title="Modifier">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('destroy_employe', $employe->id) }}" 
                                          method="POST" 
                                          onsubmit="return confirmDelete()"
                                          class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="text-red-400 hover:text-red-300 transition-colors"
                                                title="Supprimer">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>

<script>
    function confirmDelete() {
        return confirm('Êtes-vous sûr de vouloir supprimer cet employé ? Cette action est irréversible.');
    }
</script>

@endsection