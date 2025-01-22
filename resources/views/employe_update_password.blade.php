@extends('employe_dashboard_base')

@section('main')
<main class="flex-1 p-8 bg-slate-900 text-white shadow-md overflow-hidden relative">
<div class="absolute inset-0 overflow-y-auto hide-scroll px-5 py-16 mt-4 ">
        <h2 class="text-2xl font-semibold text-white mb-6 text-center">Changer votre mot de passe</h2>

        <!-- Messages d'erreur -->
        @if ($errors->any())
            <div class="mb-4 p-4 text-sm text-white bg-slate-600 rounded-lg">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>- {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Formulaire -->
        <form action="{{ route('update_put_password') }}" method="POST">
            @csrf
            @method('PUT')

            <!-- Champ Password -->
            <div class="mb-4">
                <label for="password" class="block text-lg font-medium text-gray-300">Nouveau mot de passe</label>
                <input 
                    type="password" 
                    name="password" 
                    id="password" 
                    class="w-full p-3 mt-2 bg-slate-700 text-gray-100 rounded-lg border border-slate-600 focus:outline-none focus:ring-2 focus:ring-slate-500" 
                    placeholder="Entrez votre nouveau mot de passe" >
            </div>

            <!-- Champ Confirm Password -->
            <div class="mb-6">
                <label for="password_confirmation" class="block text-lg font-medium text-gray-300">Confirmer le mot de passe</label>
                <input 
                    type="password" 
                    name="password_confirmation" 
                    id="password_confirmation" 
                    class="w-full p-3 mt-2 bg-slate-700 text-gray-100 rounded-lg border border-slate-600 focus:outline-none focus:ring-2 focus:ring-slate-500" 
                    placeholder="Confirmez votre mot de passe" >
            </div>

            <!-- Bouton de soumission -->
            <button 
                type="submit" 
                class="flex justify-center m-auto  p-3 bg-slate-600 text-white rounded-lg hover:bg-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                Modifier le mot de passe
            </button>
        </form>
    </div>
</main>
@endsection
