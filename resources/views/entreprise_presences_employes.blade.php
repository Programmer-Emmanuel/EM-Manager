@extends('dashboard_base')

@section('main')
<main class="flex-1 overflow-hidden relative bg-gradient-to-br from-slate-900 via-slate-900 to-slate-800">
    <div class="absolute inset-0 overflow-y-auto hide-scrollbar p-4 md:p-6 lg:p-8">
        <div class="max-w-7xl mx-auto space-y-6">
            
            <!-- EN-TÊTE -->
            <div class="relative overflow-hidden">
                <div class="absolute inset-0 bg-gradient-to-r from-blue-600/10 via-purple-600/10 to-pink-600/10 rounded-3xl blur-3xl"></div>
                
                <div class="relative bg-gradient-to-r from-slate-800/80 via-slate-800/60 to-slate-800/80 backdrop-blur-xl rounded-3xl p-6 border border-slate-700/50 shadow-2xl">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                        <div class="flex items-center gap-4">
                            <div class="w-14 h-14 bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl flex items-center justify-center shadow-lg shadow-blue-600/30">
                                <i class="fas fa-fingerprint text-2xl text-white"></i>
                            </div>
                            <div>
                                <h1 class="text-2xl font-bold text-white">Présences des employés</h1>
                                <p class="text-slate-400 text-sm">{{ $entrepriseDetails->nom_entreprise }}</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-3">
                            <span class="text-sm text-slate-400">{{ now()->isoFormat('MMMM YYYY') }}</span>
                            <span class="px-3 py-1 bg-slate-700/50 rounded-lg text-xs text-slate-300">
                                <i class="fas fa-users mr-1"></i> {{ $employes->count() }} employés
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- LISTE DES EMPLOYÉS -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($employes as $employe)
                    <a href="{{ route('entreprise.presences.employe', $employe->id) }}" 
                       class="group bg-gradient-to-br from-slate-800 to-slate-900 rounded-2xl p-5 border border-slate-700 hover:border-blue-500/50 transition-all duration-300 hover:shadow-lg hover:shadow-blue-500/10">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 bg-gradient-to-br from-blue-500/20 to-purple-500/20 rounded-xl flex items-center justify-center border border-slate-600/50 group-hover:border-blue-400/50 transition-colors">
                                <span class="text-lg font-bold text-white">
                                    {{ substr($employe->prenom_employe, 0, 1) }}{{ substr($employe->nom_employe, 0, 1) }}
                                </span>
                            </div>
                            <div class="flex-1 min-w-0">
                                <h3 class="text-white font-semibold truncate">{{ $employe->prenom_employe }} {{ $employe->nom_employe }}</h3>
                                <p class="text-slate-400 text-sm truncate">{{ $employe->poste }}</p>
                            </div>
                            <i class="fas fa-chevron-right text-slate-600 group-hover:text-blue-400 group-hover:translate-x-1 transition-all"></i>
                        </div>
                        
                        <!-- Statistiques rapides -->
                        <div class="mt-4 pt-4 border-t border-slate-700/50 grid grid-cols-3 gap-2 text-center">
                            <div>
                                <p class="text-xs text-slate-400">Présences</p>
                                <p class="text-lg font-bold text-green-400">{{ $employe->total_presences }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-slate-400">Absences</p>
                                <p class="text-lg font-bold text-red-400">{{ $employe->total_absences ?? 0 }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-slate-400">Taux</p>
                                <p class="text-lg font-bold text-blue-400">{{ $employe->taux_presence ?? 0 }}%</p>
                            </div>
                        </div>
                        
                        <!-- Barre de progression -->
                        <div class="mt-3 w-full bg-slate-700/50 rounded-full h-1.5 overflow-hidden">
                            <div class="h-full rounded-full transition-all duration-500 bg-gradient-to-r from-blue-500 to-green-400" 
                                 style="width: {{ $employe->taux_presence ?? 0 }}%"></div>
                        </div>
                    </a>
                @endforeach
            </div>

            @if($employes->isEmpty())
                <div class="text-center py-12 bg-slate-800/50 rounded-2xl border border-slate-700">
                    <i class="fas fa-users text-4xl text-slate-600 mb-4"></i>
                    <p class="text-slate-400">Aucun employé dans cette entreprise</p>
                    <a href="{{ route('ajout_employe') }}" class="inline-block mt-4 px-6 py-2 bg-blue-600 hover:bg-blue-700 rounded-xl text-white transition-colors">
                        <i class="fas fa-plus mr-2"></i> Ajouter un employé
                    </a>
                </div>
            @endif

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