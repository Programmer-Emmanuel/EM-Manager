@extends('employe_dashboard_base')

@section('main')
<main class="flex-1 bg-slate-900 text-white overflow-hidden relative mt-10">
    <div class="absolute inset-0 overflow-y-auto hide-scroll p-5">
        <div class="w-full max-w-md mx-auto">
            <!-- Carte du formulaire -->
            <div class="bg-slate-800/50 backdrop-blur-sm rounded-xl border border-slate-700/50 shadow-xl overflow-hidden" data-aos="fade-in">
                <!-- En-tête -->
                <div class="relative bg-gradient-to-r from-slate-700/50 to-slate-800/50 p-6 border-b border-slate-700/50">
                    <h2 class="text-center text-xl font-bold text-white">Changer votre mot de passe</h2>
                </div>

                <!-- Contenu -->
                <div class="p-6 space-y-6">
                    <!-- Messages d'erreur -->
                    @if ($errors->any())
                        <div class="mb-4 p-4 text-sm text-white bg-slate-700/30 rounded-lg border border-slate-700/50">
                            <ul class="space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li class="flex items-start">
                                        <svg class="w-4 h-4 mt-0.5 mr-2 text-red-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <span>{{ $error }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- Formulaire -->
                    <form action="{{ route('update_put_password') }}" method="POST" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <!-- Champ Password -->
                        <div>
                            <label for="password" class="block text-sm font-medium text-slate-400 mb-2">Nouveau mot de passe</label>
                            <div class="relative">
                                <input 
                                    type="password" 
                                    name="password" 
                                    id="password" 
                                    class="w-full p-3 bg-slate-700/30 text-white rounded-lg border border-slate-700/50 focus:outline-none focus:ring-2 focus:ring-slate-500 focus:border-transparent placeholder-slate-500" 
                                    placeholder="Entrez votre nouveau mot de passe">
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <!-- Champ Confirm Password -->
                        <div>
                            <label for="password_confirmation" class="block text-sm font-medium text-slate-400 mb-2">Confirmer le mot de passe</label>
                            <div class="relative">
                                <input 
                                    type="password" 
                                    name="password_confirmation" 
                                    id="password_confirmation" 
                                    class="w-full p-3 bg-slate-700/30 text-white rounded-lg border border-slate-700/50 focus:outline-none focus:ring-2 focus:ring-slate-500 focus:border-transparent placeholder-slate-500" 
                                    placeholder="Confirmez votre mot de passe">
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <!-- Bouton de soumission -->
                        <div class="pt-2">
                            <button 
                                type="submit" 
                                class="w-full py-3 px-4 bg-gradient-to-r from-slate-700/50 to-slate-800/50 text-white font-medium rounded-lg border border-slate-700/50 hover:from-slate-700 hover:to-slate-800 focus:outline-none focus:ring-2 focus:ring-slate-500 focus:ring-offset-2 focus:ring-offset-slate-900 transition-all duration-200 flex items-center justify-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                </svg>
                                Modifier le mot de passe
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Effets décoratifs -->
    <div class="fixed -bottom-32 -left-32 w-64 h-64 bg-indigo-500 rounded-full mix-blend-multiply filter blur-3xl opacity-5"></div>
    <div class="fixed -top-32 -right-32 w-64 h-64 bg-purple-500 rounded-full mix-blend-multiply filter blur-3xl opacity-5"></div>
</main>

<style>
    /* Animation d'apparition */
    [data-aos="fade-in"] {
        opacity: 0;
        transition: opacity 0.6s ease-out, transform 0.6s ease-out;
        transform: translateY(20px);
    }
    
    [data-aos="fade-in"].aos-animate {
        opacity: 1;
        transform: translateY(0);
    }
</style>
@endsection