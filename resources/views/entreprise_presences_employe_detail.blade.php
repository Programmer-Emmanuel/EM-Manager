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
                            <div class="w-14 h-14 bg-gradient-to-br from-purple-500 to-purple-600 rounded-2xl flex items-center justify-center shadow-lg shadow-purple-600/30">
                                <span class="text-xl font-bold text-white">
                                    {{ substr($employe->prenom_employe, 0, 1) }}{{ substr($employe->nom_employe, 0, 1) }}
                                </span>
                            </div>
                            <div>
                                <h1 class="text-2xl font-bold text-white">{{ $employe->prenom_employe }} {{ $employe->nom_employe }}</h1>
                                <p class="text-slate-400 text-sm flex items-center gap-2">
                                    <span class="px-2 py-0.5 bg-slate-700/50 rounded text-xs">{{ $employe->poste }}</span>
                                    <span class="text-slate-500">•</span>
                                    <span>{{ $employe->departement }}</span>
                                </p>
                            </div>
                        </div>
                        <div class="flex items-center gap-3 flex-wrap">
                            <a href="{{ route('entreprise.presences.employes') }}" 
                               class="px-4 py-2 bg-slate-700/30 hover:bg-slate-700/50 rounded-xl border border-slate-600/50 text-slate-300 transition-colors text-sm">
                                <i class="fas fa-arrow-left mr-2"></i> Retour
                            </a>
                            <div class="flex items-center gap-2 px-4 py-2 bg-slate-700/30 rounded-xl border border-slate-600/50">
                                <i class="fas fa-calendar-alt text-blue-400"></i>
                                <span class="text-white text-sm">{{ now()->isoFormat('MMMM YYYY') }}</span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Navigation mois -->
                    <div class="mt-4 pt-4 border-t border-slate-700/50 flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <a href="{{ route('entreprise.presences.employe', ['id' => $employe->id, 'mois' => $moisPrecedent, 'annee' => $anneePrecedent]) }}" 
                               class="px-3 py-1.5 bg-slate-700/30 hover:bg-slate-700/50 rounded-lg border border-slate-600/50 text-white transition-colors text-sm">
                                <i class="fas fa-chevron-left"></i>
                            </a>
                            <span class="text-white font-semibold text-base min-w-[120px] text-center">
                                {{ \Carbon\Carbon::create($annee, $mois, 1)->isoFormat('MMMM YYYY') }}
                            </span>
                            <a href="{{ route('entreprise.presences.employe', ['id' => $employe->id, 'mois' => $moisSuivant, 'annee' => $anneeSuivant]) }}" 
                               class="px-3 py-1.5 bg-slate-700/30 hover:bg-slate-700/50 rounded-lg border border-slate-600/50 text-white transition-colors text-sm">
                                <i class="fas fa-chevron-right"></i>
                            </a>
                            <a href="{{ route('entreprise.presences.employe', ['id' => $employe->id]) }}" 
                               class="px-3 py-1.5 bg-blue-600/20 hover:bg-blue-600/40 rounded-lg border border-blue-500/20 text-blue-400 text-xs transition-colors">
                                <i class="fas fa-undo mr-1"></i> Aujourd'hui
                            </a>
                        </div>
                        
                        <div class="flex items-center gap-4 text-sm">
                            <span class="text-slate-400">Statistiques:</span>
                            <span class="text-green-400"><i class="fas fa-check-circle mr-1"></i>{{ $statsMois['present'] }}</span>
                            <span class="text-yellow-400"><i class="fas fa-clock mr-1"></i>{{ $statsMois['retard'] }}</span>
                            <span class="text-red-400"><i class="fas fa-times-circle mr-1"></i>{{ $statsMois['absent'] }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- LÉGENDE -->
            <div class="flex flex-wrap items-center gap-4 bg-slate-800/50 rounded-xl p-3 border border-slate-700">
                <span class="text-xs text-slate-400 font-medium">Légende :</span>
                <div class="flex items-center gap-1.5">
                    <span class="w-3 h-3 bg-green-500 rounded-full"></span>
                    <span class="text-xs text-slate-300">Présent</span>
                </div>
                <div class="flex items-center gap-1.5">
                    <span class="w-3 h-3 bg-red-500 rounded-full"></span>
                    <span class="text-xs text-slate-300">Absent</span>
                </div>
                <div class="flex items-center gap-1.5">
                    <span class="w-3 h-3 bg-yellow-500 rounded-full"></span>
                    <span class="text-xs text-slate-300">Retard</span>
                </div>
                <div class="flex items-center gap-1.5">
                    <span class="w-3 h-3 bg-blue-500 rounded-full ring-2 ring-blue-300"></span>
                    <span class="text-xs text-slate-300">Aujourd'hui</span>
                </div>
                <div class="flex items-center gap-1.5">
                    <span class="w-3 h-3 bg-slate-600 rounded-full"></span>
                    <span class="text-xs text-slate-300">Week-end</span>
                </div>
            </div>

            <!-- CALENDRIER -->
            <div class="bg-gradient-to-br from-slate-800 to-slate-900 rounded-2xl border border-slate-700 overflow-hidden">
                <!-- Jours de la semaine -->
                <div class="grid grid-cols-7 gap-px bg-slate-700/50">
                    @foreach(['Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam', 'Dim'] as $jour)
                        <div class="bg-slate-800/50 py-2 text-center text-xs font-medium text-slate-400">
                            {{ $jour }}
                        </div>
                    @endforeach
                </div>

                <!-- Cases du calendrier -->
                <div class="grid grid-cols-7 gap-px bg-slate-700/50">
                    @php
                        $aujourdhui = now()->format('Y-m-d');
                        $premierJourMois = \Carbon\Carbon::create($annee, $mois, 1);
                        $dernierJourMois = $premierJourMois->copy()->endOfMonth();
                        $joursDansMois = $dernierJourMois->day;
                        $premierJourSemaine = $premierJourMois->dayOfWeekIso;
                    @endphp

                    <!-- Jours vides -->
                    @for($i = 1; $i < $premierJourSemaine; $i++)
                        <div class="bg-slate-900/50 p-2 min-h-[80px]"></div>
                    @endfor

                    <!-- Jours du mois -->
                    @for($jour = 1; $jour <= $joursDansMois; $jour++)
                        @php
                            $date = \Carbon\Carbon::create($annee, $mois, $jour);
                            $dateKey = $date->format('Y-m-d');
                            $estAujourdhui = $dateKey === $aujourdhui;
                            $estWeekend = $date->isWeekend();
                            $presence = $presencesParJour[$dateKey] ?? null;
                            
                            $couleur = 'bg-slate-800';
                            $statutLabel = '';
                            $iconeStatut = '';
                            
                            if ($presence) {
                                if ($presence->statut === 'present') {
                                    $couleur = 'bg-green-500/20 hover:bg-green-500/30 border-green-500/30';
                                    $statutLabel = 'Présent';
                                    $iconeStatut = 'fa-check';
                                } elseif ($presence->statut === 'retard') {
                                    $couleur = 'bg-yellow-500/20 hover:bg-yellow-500/30 border-yellow-500/30';
                                    $statutLabel = 'Retard';
                                    $iconeStatut = 'fa-clock';
                                } else {
                                    $couleur = 'bg-red-500/20 hover:bg-red-500/30 border-red-500/30';
                                    $statutLabel = 'Absent';
                                    $iconeStatut = 'fa-times';
                                }
                            } else {
                                if ($estWeekend) {
                                    $couleur = 'bg-slate-700/30';
                                } elseif ($date->lt(now()->startOfDay())) {
                                    $couleur = 'bg-red-500/10 border-red-500/20';
                                    $statutLabel = 'Absent';
                                    $iconeStatut = 'fa-times';
                                }
                            }
                            
                            if ($estAujourdhui) {
                                $couleur .= ' ring-2 ring-blue-400 ring-offset-2 ring-offset-slate-900';
                            }
                        @endphp

                        <div class="{{ $couleur }} p-1.5 min-h-[80px] cursor-pointer transition-all duration-200 hover:scale-[1.02] relative border"
                             onclick="openModal('{{ $dateKey }}', '{{ $jour }}', '{{ $statutLabel }}', '{{ $presence ? $presence->heure_arrivee : '' }}', '{{ $presence ? $presence->heure_depart : '' }}', '{{ $presence ? $presence->adresse_pointage : '' }}', '{{ $presence ? $presence->adresse_ip : '' }}', '{{ $presence ? $presence->navigateur : '' }}', '{{ $presence ? $presence->latitude : '' }}', '{{ $presence ? $presence->longitude : '' }}')">
                            <div class="flex justify-between items-start">
                                <span class="text-sm font-semibold {{ $estAujourdhui ? 'text-blue-400' : 'text-white' }}">
                                    {{ $jour }}
                                </span>
                                @if($presence)
                                    <span class="text-[10px] px-1.5 py-0.5 rounded-full {{ $presence->statut === 'present' ? 'bg-green-500/30 text-green-300' : ($presence->statut === 'retard' ? 'bg-yellow-500/30 text-yellow-300' : 'bg-red-500/30 text-red-300') }}">
                                        <i class="fas {{ $iconeStatut }}"></i>
                                    </span>
                                @elseif(!$estWeekend && $date->lt(now()->startOfDay()))
                                    <span class="text-[10px] px-1.5 py-0.5 rounded-full bg-red-500/30 text-red-300">
                                        <i class="fas fa-times"></i>
                                    </span>
                                @endif
                            </div>
                            @if($presence)
                                <div class="mt-1 text-[10px] text-slate-400">
                                    <div><i class="fas fa-sign-in-alt text-blue-400 mr-0.5"></i> {{ $presence->heure_arrivee }}</div>
                                    @if($presence->heure_depart)
                                        <div><i class="fas fa-sign-out-alt text-red-400 mr-0.5"></i> {{ $presence->heure_depart }}</div>
                                    @endif
                                </div>
                            @elseif(!$estWeekend && $date->lt(now()->startOfDay()))
                                <div class="mt-1 text-[10px] text-red-400">
                                    <i class="fas fa-user-slash mr-0.5"></i> Absent
                                </div>
                            @endif
                        </div>
                    @endfor

                    <!-- Jours vides après le dernier jour -->
                    @php
                        $dernierJourSemaine = $dernierJourMois->dayOfWeekIso;
                        $joursRestants = 7 - $dernierJourSemaine;
                    @endphp
                    @for($i = 0; $i < $joursRestants; $i++)
                        <div class="bg-slate-900/50 p-2 min-h-[80px]"></div>
                    @endfor
                </div>
            </div>

            <!-- STATISTIQUES -->
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                <div class="bg-gradient-to-br from-slate-800 to-slate-900 rounded-xl p-3 border border-slate-700">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-slate-400 text-[10px] uppercase tracking-wider">Total</p>
                            <p class="text-xl font-bold text-white">{{ $statsMois['total'] }}</p>
                        </div>
                        <div class="w-8 h-8 bg-blue-500/20 rounded-lg flex items-center justify-center">
                            <i class="fas fa-calendar text-blue-400 text-sm"></i>
                        </div>
                    </div>
                </div>
                <div class="bg-gradient-to-br from-slate-800 to-slate-900 rounded-xl p-3 border border-slate-700">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-slate-400 text-[10px] uppercase tracking-wider">Présents</p>
                            <p class="text-xl font-bold text-green-400">{{ $statsMois['present'] }}</p>
                        </div>
                        <div class="w-8 h-8 bg-green-500/20 rounded-lg flex items-center justify-center">
                            <i class="fas fa-check text-green-400 text-sm"></i>
                        </div>
                    </div>
                </div>
                <div class="bg-gradient-to-br from-slate-800 to-slate-900 rounded-xl p-3 border border-slate-700">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-slate-400 text-[10px] uppercase tracking-wider">Retards</p>
                            <p class="text-xl font-bold text-yellow-400">{{ $statsMois['retard'] }}</p>
                        </div>
                        <div class="w-8 h-8 bg-yellow-500/20 rounded-lg flex items-center justify-center">
                            <i class="fas fa-clock text-yellow-400 text-sm"></i>
                        </div>
                    </div>
                </div>
                <div class="bg-gradient-to-br from-slate-800 to-slate-900 rounded-xl p-3 border border-slate-700">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-slate-400 text-[10px] uppercase tracking-wider">Absents</p>
                            <p class="text-xl font-bold text-red-400">{{ $statsMois['absent'] }}</p>
                        </div>
                        <div class="w-8 h-8 bg-red-500/20 rounded-lg flex items-center justify-center">
                            <i class="fas fa-times text-red-400 text-sm"></i>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</main>

<!-- MODALE AVEC TOUTES LES INFOS -->
<div id="presenceModal" class="fixed inset-0 z-50 hidden bg-black/70 backdrop-blur-sm flex items-center justify-center p-4">
    <div class="bg-gradient-to-br from-slate-800 to-slate-900 rounded-2xl border border-slate-700 max-w-md w-full shadow-2xl transform transition-all max-h-[90vh] overflow-y-auto">
        <div class="p-5">
            <!-- En-tête -->
            <div class="flex justify-between items-center mb-3">
                <h3 class="text-lg font-bold text-white" id="modalDate"></h3>
                <button onclick="closeModal()" class="text-slate-400 hover:text-white transition-colors">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
            
            <!-- Contenu -->
            <div class="space-y-3">
                <div id="modalStatut" class="flex items-center gap-3 p-2.5 rounded-xl"></div>
                
                <div class="grid grid-cols-2 gap-3">
                    <div class="bg-slate-700/30 rounded-lg p-2.5">
                        <p class="text-[10px] text-slate-400"><i class="fas fa-sign-in-alt mr-1"></i> Arrivée</p>
                        <p class="text-white font-semibold text-base" id="modalArrivee">-</p>
                    </div>
                    <div class="bg-slate-700/30 rounded-lg p-2.5">
                        <p class="text-[10px] text-slate-400"><i class="fas fa-sign-out-alt mr-1"></i> Départ</p>
                        <p class="text-white font-semibold text-base" id="modalDepart">-</p>
                    </div>
                </div>

                <div class="bg-slate-700/30 rounded-lg p-2.5">
                    <p class="text-[10px] text-slate-400"><i class="fas fa-map-marker-alt mr-1"></i> Adresse</p>
                    <p class="text-white text-sm mt-0.5" id="modalAdresse">-</p>
                </div>

                <div class="bg-slate-700/30 rounded-lg p-2.5">
                    <p class="text-[10px] text-slate-400"><i class="fas fa-clock mr-1"></i> Durée</p>
                    <p class="text-white font-semibold text-base" id="modalDuree">-</p>
                </div>

                <!-- Informations techniques complètes -->
                <div class="border-t border-slate-700/50 pt-3">
                    <p class="text-xs text-slate-400 mb-2"><i class="fas fa-info-circle mr-1"></i> Informations techniques</p>
                    <div class="grid grid-cols-2 gap-2 text-xs">
                        <div class="bg-slate-700/20 rounded-lg p-2">
                            <p class="text-slate-500">IP</p>
                            <p class="text-slate-300 font-mono" id="modalIp">-</p>
                        </div>
                        <div class="bg-slate-700/20 rounded-lg p-2">
                            <p class="text-slate-500">Navigateur</p>
                            <p class="text-slate-300" id="modalNavigateur">-</p>
                        </div>
                        <div class="bg-slate-700/20 rounded-lg p-2">
                            <p class="text-slate-500">Latitude</p>
                            <p class="text-slate-300 font-mono" id="modalLatitude">-</p>
                        </div>
                        <div class="bg-slate-700/20 rounded-lg p-2">
                            <p class="text-slate-500">Longitude</p>
                            <p class="text-slate-300 font-mono" id="modalLongitude">-</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pied -->
            <div class="mt-4 pt-3 border-t border-slate-700/50 flex justify-end">
                <button onclick="closeModal()" class="px-4 py-1.5 bg-slate-700 hover:bg-slate-600 rounded-lg text-white text-sm transition-colors">
                    <i class="fas fa-times mr-1.5"></i> Fermer
                </button>
            </div>
        </div>
    </div>
</div>

<script>
function openModal(dateKey, jour, statut, arrivee, depart, adresse, ip, navigateur, latitude, longitude) {
    const modal = document.getElementById('presenceModal');
    
    // Date
    const dateObj = new Date(dateKey + 'T00:00:00');
    const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
    document.getElementById('modalDate').textContent = dateObj.toLocaleDateString('fr-FR', options);
    
    // Statut
    const statutDiv = document.getElementById('modalStatut');
    let couleur, icone, label;
    
    if (statut === 'Présent') {
        couleur = 'bg-green-500/20 border-green-500/50 text-green-400';
        icone = 'fa-check-circle';
        label = 'Présent';
    } else if (statut === 'Retard') {
        couleur = 'bg-yellow-500/20 border-yellow-500/50 text-yellow-400';
        icone = 'fa-clock';
        label = 'Retard';
    } else if (statut === 'Absent') {
        couleur = 'bg-red-500/20 border-red-500/50 text-red-400';
        icone = 'fa-times-circle';
        label = 'Absent';
    } else {
        couleur = 'bg-slate-700/30 border-slate-600/50 text-slate-400';
        icone = 'fa-minus-circle';
        label = 'Non travaillé';
    }
    
    statutDiv.className = `flex items-center gap-3 p-2.5 rounded-xl border ${couleur}`;
    statutDiv.innerHTML = `<i class="fas ${icone} text-xl"></i><span class="font-semibold">${label}</span>`;
    
    // Arrivée / Départ
    document.getElementById('modalArrivee').textContent = arrivee || '-';
    document.getElementById('modalDepart').textContent = depart || '-';
    document.getElementById('modalAdresse').textContent = adresse || 'Non renseignée';
    
    // Durée
    if (arrivee && depart) {
        const [h1, m1] = arrivee.split(':');
        const [h2, m2] = depart.split(':');
        const diffMinutes = (parseInt(h2) * 60 + parseInt(m2)) - (parseInt(h1) * 60 + parseInt(m1));
        const heures = Math.floor(diffMinutes / 60);
        const minutes = diffMinutes % 60;
        document.getElementById('modalDuree').textContent = `${heures}h ${minutes}min`;
    } else if (arrivee && !depart) {
        document.getElementById('modalDuree').textContent = 'En cours...';
    } else {
        document.getElementById('modalDuree').textContent = '-';
    }
    
    // Infos techniques
    document.getElementById('modalIp').textContent = ip || '-';
    document.getElementById('modalNavigateur').textContent = navigateur || '-';
    document.getElementById('modalLatitude').textContent = latitude || '-';
    document.getElementById('modalLongitude').textContent = longitude || '-';
    
    modal.classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeModal() {
    document.getElementById('presenceModal').classList.add('hidden');
    document.body.style.overflow = '';
}

// Fermer la modale en cliquant à l'extérieur
document.getElementById('presenceModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeModal();
    }
});

// Fermer avec la touche Echap
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeModal();
    }
});
</script>

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