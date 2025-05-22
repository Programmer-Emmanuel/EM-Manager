@extends('dashboard_base')

@section('main')
<main class="flex-1 bg-slate-900 text-white shadow-md overflow-hidden relative">
    <div class="absolute inset-0 overflow-y-auto hide-scroll p-5 ">
    <div class="flex items-center justify-center min-h-screen px-4">
        <div class="max-w-4xl w-full p-6 bg-slate-800 rounded-lg shadow-lg space-y-6 animate-fade-in">
            
            <h1 class="text-3xl font-bold text-white">🧠 Conseils générés par notre IA pour vous aider dans la gestion de votre entreprise</h1>

            @if($conseils)
                <div class="bg-slate-700 p-4 rounded shadow text-white whitespace-pre-line leading-relaxed">
                    {{ $conseils }}
                </div>
            @else
                <p class="text-slate-400 italic">Aucun conseil généré pour le moment.</p>
            @endif

        </div>
    </div>
    </div>
</main>

<script>
    document.getElementById('genererConseilsBtn').addEventListener('click', function () {
        fetch('/generer-conseils', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({})
        })
        .then(response => response.json())
        .then(data => {
            document.getElementById('conseilsContainer').innerText = data.conseils;
        })
        .catch(error => {
            document.getElementById('conseilsContainer').innerText = 'Erreur lors de la génération des conseils.';
            console.error('Erreur:', error);
        });
    });
</script>

@endsection
