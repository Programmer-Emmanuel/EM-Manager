@extends('dashboard_base')

@section('main')
<main class="flex-1 p-3 md:p-8 bg-slate-900 text-white shadow-md">
    <!-- Titre principal -->
    <header class="mb-8">
        <h1 class="text-2xl font-bold text-white text-center">Modifier l'Employé</h1>
    </header>

    <section>
        <form action="{{ route('update_employe', Crypt::encrypt($employe->id)) }}" method="POST" class="bg-slate-800 p-6 rounded-lg shadow-md">
            @csrf
            @method('PUT')

            <!-- Nom et prénom -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label for="nom_employe" class="block text-sm font-medium mb-2">Nom</label>
                    <input type="text" name="nom_employe" id="nom_employe" value="{{ old('nom_employe', $employe->nom_employe) }}" class="w-full px-4 py-2 rounded-lg bg-slate-700 border border-slate-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label for="prenom_employe" class="block text-sm font-medium mb-2">Prénom</label>
                    <input type="text" name="prenom_employe" id="prenom_employe" value="{{ old('prenom_employe', $employe->prenom_employe) }}" class="w-full px-4 py-2 rounded-lg bg-slate-700 border border-slate-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
            </div>

            <!-- Adresse et téléphone -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label for="adresse_employe" class="block text-sm font-medium mb-2">Adresse</label>
                    <input type="text" name="adresse_employe" id="adresse_employe" value="{{ old('adresse_employe', $employe->adresse_employe) }}" class="w-full px-4 py-2 rounded-lg bg-slate-700 border border-slate-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label for="telephone" class="block text-sm font-medium mb-2">Téléphone</label>
                    <input type="text" name="telephone" id="telephone" value="{{ old('telephone', $employe->telephone) }}" class="w-full px-4 py-2 rounded-lg bg-slate-700 border border-slate-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
            </div>

            <!-- Email -->
            <div class="grid grid-cols-1 gap-4 mb-4">
                <div>
                    <label for="email_employe" class="block text-sm font-medium mb-2">Email</label>
                    <input type="email" name="email_employe" id="email_employe" value="{{ old('email_employe', $employe->email_employe) }}" class="w-full px-4 py-2 rounded-lg bg-slate-700 border border-slate-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
            </div>

            <!-- Poste et département -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label for="poste" class="block text-sm font-medium mb-2">Poste</label>
                    <input type="text" name="poste" id="poste" value="{{ old('poste', $employe->poste) }}" class="w-full px-4 py-2 rounded-lg bg-slate-700 border border-slate-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label for="departement" class="block text-sm font-medium mb-2">Département</label>
                    <input type="text" name="departement" id="departement" value="{{ old('departement', $employe->departement) }}" class="w-full px-4 py-2 rounded-lg bg-slate-700 border border-slate-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
            </div>

            <!-- Salaire -->
            <div class="grid grid-cols-1 gap-4 mb-4">
                <div>
                    <label for="salaire" class="block text-sm font-medium mb-2">Salaire</label>
                    <input type="text" name="salaire" id="salaire" value="{{ old('salaire', $employe->salaire) }}" class="w-full px-4 py-2 rounded-lg bg-slate-700 border border-slate-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
            </div>

            <!-- Bouton de soumission -->
            <div class="text-center">
                <button type="submit" class="bg-slate-600 text-white px-6 py-3 rounded-lg shadow hover:bg-slate-700 transition">
                    <i class="fas fa-save"></i> Enregistrer
                </button>
            </div>
        </form>
    </section>
</main>
@endsection
