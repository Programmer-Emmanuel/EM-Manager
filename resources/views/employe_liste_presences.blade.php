@extends('employe_dashboard_base')

@section('main')
<main class="flex-1 overflow-hidden relative bg-gradient-to-br from-slate-900 via-slate-900 to-slate-800">
    <div class="absolute inset-0 overflow-y-auto hide-scrollbar p-4 md:p-6 lg:p-8">
        <div class="max-w-7xl mx-auto space-y-6 md:space-y-8">
            
            <!-- EN-TÊTE -->
            <div class="relative overflow-hidden">
                <div class="absolute inset-0 bg-gradient-to-r from-blue-600/10 via-purple-600/10 to-pink-600/10 rounded-3xl blur-3xl"></div>
                
                <div class="relative bg-gradient-to-r from-slate-800/80 via-slate-800/60 to-slate-800/80 backdrop-blur-xl rounded-3xl p-6 md:p-8 border border-slate-700/50 shadow-2xl">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">
                        <div class="flex items-center gap-4">
                            <div class="w-16 h-16 bg-gradient-to-br from-purple-500 to-purple-600 rounded-2xl flex items-center justify-center shadow-lg shadow-purple-600/30">
                                <i class="fas fa-clock text-2xl text-white"></i>
                            </div>
                            <div>
                                <h1 class="text-2xl md:text-3xl font-bold text-white">
                                    Mes présences
                                </h1>
                                <p class="text-slate-400 mt-1 flex items-center gap-2">
                                    <i class="fas fa-user text-purple-400"></i>
                                    {{ $employeDetails->prenom_employe }} {{ $employeDetails->nom_employe }}
                                </p>
                            </div>
                        </div>
                        
                        <a href="{{ route('employe.calendrier') }}" class="px-4 py-2 bg-blue-600/30 hover:bg-blue-600/50 rounded-xl border border-blue-500/30 text-blue-400 transition-colors">
                            <i class="fas fa-calendar-alt mr-2"></i> Voir calendrier
                        </a>
                    </div>
                </div>
            </div>

            <!-- STATISTIQUES -->
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                <div class="bg-gradient-to-br from-slate-800 to-slate-900 rounded-xl p-4 border border-slate-700">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-slate-400 text-xs">Total présences</p>
                            <p class="text-2xl font-bold text-white">{{ $statistiques['total'] }}</p>
                        </div>
                        <div class="w-10 h-10 bg-blue-500/20 rounded-lg flex items-center justify-center">
                            <i class="fas fa-calendar-check text-blue-400"></i>
                        </div>
                    </div>
                </div>
                <div class="bg-gradient-to-br from-slate-800 to-slate-900 rounded-xl p-4 border border-slate-700">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-slate-400 text-xs">Ce mois</p>
                            <p class="text-2xl font-bold text-green-400">{{ $statistiques['mois_actuel'] }}</p>
                        </div>
                        <div class="w-10 h-10 bg-green-500/20 rounded-lg flex items-center justify-center">
                            <i class="fas fa-calendar-alt text-green-400"></i>
                        </div>
                    </div>
                </div>
                <div class="bg-gradient-to-br from-slate-800 to-slate-900 rounded-xl p-4 border border-slate-700">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-slate-400 text-xs">Cette semaine</p>
                            <p class="text-2xl font-bold text-purple-400">{{ $statistiques['semaine_actuelle'] }}</p>
                        </div>
                        <div class="w-10 h-10 bg-purple-500/20 rounded-lg flex items-center justify-center">
                            <i class="fas fa-calendar-week text-purple-400"></i>
                        </div>
                    </div>
                </div>
                <div class="bg-gradient-to-br from-slate-800 to-slate-900 rounded-xl p-4 border border-slate-700">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-slate-400 text-xs">Taux présence</p>
                            <p class="text-2xl font-bold text-amber-400">{{ $statistiques['taux_presence'] }}%</p>
                        </div>
                        <div class="w-10 h-10 bg-amber-500/20 rounded-lg flex items-center justify-center">
                            <i class="fas fa-chart-pie text-amber-400"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- STATISTIQUES PAR MOIS -->
            @if($statsParMois->isNotEmpty())
            <div class="bg-gradient-to-br from-slate-800 to-slate-900 rounded-2xl p-6 border border-slate-700">
                <h3 class="text-lg font-semibold text-white mb-4 flex items-center gap-2">
                    <span class="w-1.5 h-6 bg-gradient-to-b from-blue-400 to-blue-600 rounded-full"></span>
                    Résumé par mois
                </h3>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-slate-800/50">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-medium text-slate-400 uppercase">Mois</th>
                                <th class="px-4 py-3 text-center text-xs font-medium text-slate-400 uppercase">Total</th>
                                <th class="px-4 py-3 text-center text-xs font-medium text-slate-400 uppercase">Présents</th>
                                <th class="px-4 py-3 text-center text-xs font-medium text-slate-400 uppercase">Retards</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-700/50">
                            @foreach($statsParMois as $stat)
                                <tr class="hover:bg-slate-800/30 transition-colors">
                                    <td class="px-4 py-3 text-white font-medium">{{ \Carbon\Carbon::create($stat->annee, $stat->mois)->isoFormat('MMMM YYYY') }}</td>
                                    <td class="px-4 py-3 text-center text-slate-300">{{ $stat->total }}</td>
                                    <td class="px-4 py-3 text-center text-green-400">{{ $stat->presents }}</td>
                                    <td class="px-4 py-3 text-center text-yellow-400">{{ $stat->retards }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @endif

            <!-- LISTE DES PRÉSENCES -->
            <div class="bg-gradient-to-br from-slate-800 to-slate-900 rounded-2xl border border-slate-700 overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-700">
                    <h3 class="text-lg font-semibold text-white flex items-center gap-2">
                        <span class="w-1.5 h-6 bg-gradient-to-b from-emerald-400 to-emerald-600 rounded-full"></span>
                        Historique complet
                    </h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-slate-800/50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-slate-400 uppercase tracking-wider">Date</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-slate-400 uppercase tracking-wider">Arrivée</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-slate-400 uppercase tracking-wider">Départ</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-slate-400 uppercase tracking-wider">Durée</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-slate-400 uppercase tracking-wider">Statut</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-slate-400 uppercase tracking-wider">Adresse</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-700/50">
                            @forelse($presences as $presence)
                                <tr class="hover:bg-slate-800/30 transition-colors">
                                    <td class="px-6 py-4 text-white">{{ $presence->date->isoFormat('DD/MM/YYYY') }}</td>
                                    <td class="px-6 py-4 text-slate-300">{{ $presence->heure_arrivee }}</td>
                                    <td class="px-6 py-4 text-slate-300">{{ $presence->heure_depart ?? '-' }}</td>
                                    <td class="px-6 py-4 text-slate-300">
                                        @if($presence->heure_arrivee && $presence->heure_depart)
                                            @php
                                                $arrivee = \Carbon\Carbon::parse($presence->heure_arrivee);
                                                $depart = \Carbon\Carbon::parse($presence->heure_depart);
                                                $diff = $depart->diff($arrivee);
                                            @endphp
                                            {{ $diff->h }}h {{ $diff->i }}min
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="px-2 py-1 rounded-full text-xs font-semibold
                                            {{ $presence->statut == 'present' ? 'bg-green-500/20 text-green-400 border border-green-500/30' : 
                                               ($presence->statut == 'retard' ? 'bg-yellow-500/20 text-yellow-400 border border-yellow-500/30' : 
                                               'bg-red-500/20 text-red-400 border border-red-500/30') }}">
                                            <i class="fas {{ $presence->statut == 'present' ? 'fa-check' : ($presence->statut == 'retard' ? 'fa-clock' : 'fa-times') }} mr-1"></i>
                                            {{ ucfirst($presence->statut) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-slate-400 max-w-[150px] truncate">
                                        {{ $presence->adresse_pointage ? Str::limit($presence->adresse_pointage, 30) : '-' }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-8 text-center text-slate-500">
                                        <i class="fas fa-inbox text-3xl block mb-2 text-slate-600"></i>
                                        Aucune présence enregistrée
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <!-- Pagination -->
                <div class="px-6 py-4 border-t border-slate-700">
                    {{ $presences->links() }}
                </div>
            </div>

        </div>
    </div>
</main>

<style>
.hide-scrollbar {
    scrollbar-width: none;
    -ms-overflow-style: none;
}
.hide-scrollbar::-webkit-scrollbar {
    display: none;
}
</style>
@endsection