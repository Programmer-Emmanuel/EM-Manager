@extends('employe_dashboard_base')

@section('main')
<main class="flex-1 p-8 bg-slate-900 text-white shadow-md overflow-hidden relative">
<div class="absolute inset-0 overflow-y-auto hide-scroll p-5 ">
    <!-- Titre principal -->
    <header class="mb-8">
        <h1 class="text-2xl font-bold text-white">Demande de Congé</h1>
        <p class="text-slate-400 italic">Faites votre demande de congé en remplissant soigneusement le formulaire.</p>
    </header>


    @if ($errors->any())
    <div class="bg-red-600 text-white p-4 rounded-lg mb-6">
        <p class="font-semibold">Des erreurs sont survenues :</p>
        <ul class="list-disc pl-5">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif


    <!-- Formulaire de demande de congé -->
    <section class="bg-slate-800 p-6 rounded-lg shadow-md">
        <form action="{{ route('demande_conge_post') }}" method="POST" class="space-y-6">
            @csrf
            <!-- Type de congé -->
            <div>
                <label for="type_conge" class="block text-sm font-medium text-slate-300 mb-2">Type de Congé</label>
                <select id="type_conge" name="type_conge" class="w-full p-3 bg-slate-900 border border-slate-600 rounded-lg text-white">
                    <option value="Vacances">Vacances</option>
                    <option value="Maladie">Maladie</option>
                    <option value="Personnel">Personnel</option>
                    <option value="Autre">Autre</option>
                </select>
            </div>

            <!-- Date de début -->
            <div>
                <label for="date_debut" class="block text-sm font-medium text-slate-300 mb-2">Date de Début</label>
                <input type="date" id="date_debut" name="date_debut" class="w-full p-3 bg-slate-900 border border-slate-600 rounded-lg text-white">
            </div>

            <!-- Date de fin -->
            <div>
                <label for="date_fin" class="block text-sm font-medium text-slate-300 mb-2">Date de Fin</label>
                <input type="date" id="date_fin" name="date_fin" class="w-full p-3 bg-slate-900 border border-slate-600 rounded-lg text-white">
            </div>

            <!-- Bouton de soumission -->
            <div>
                <button type="submit" class="w-full bg-slate-600 hover:bg-slate-700 transition text-white py-3 rounded-lg font-semibold">
                    Soumettre la Demande
                </button>
            </div>
        </form>
    </section>
</div>
</main>
@endsection
