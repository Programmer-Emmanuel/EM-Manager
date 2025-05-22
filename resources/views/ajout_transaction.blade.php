@extends('dashboard_base')
@include('aos')

@section('main')
<main class="flex-1 bg-slate-900 text-white shadow-md overflow-hidden relative">
    <div class="flex items-center justify-center min-h-screen px-4" data-aos="zoom-in" data-aos-duration="1500">
        <form action="#" method="POST" class="space-y-6 bg-slate-800 p-8 rounded-lg shadow-lg w-full max-w-md">
            @csrf
            @if ($errors->any())
                <div class="text-red-500">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <h2 class="text-2xl font-bold text-center border-b border-slate-700 pb-4">Nouvelle Transaction</h2>

            <div>
                <label for="motif" class="block mb-2 font-semibold text-slate-200">Motif</label>
                <input type="text" name="motif" id="motif" required
                    class="w-full px-4 py-2 rounded bg-slate-700 text-white border border-slate-600 focus:outline-none focus:ring-2 focus:ring-slate-500"
                    placeholder="Entrez le motif">
            </div>

            <div>
                <label for="type" class="block mb-2 font-semibold text-slate-200">Type de transaction</label>
                <select name="type" id="type" required
                    class="w-full px-4 py-2 rounded bg-slate-700 text-white border border-slate-600 focus:outline-none focus:ring-2 focus:ring-slate-500">
                    <option value="Achat">Achat</option>
                    <option value="Vente">Vente</option>
                </select>
            </div>

            <div>
                <label for="montant" class="block mb-2 font-semibold text-slate-200">Montant</label>
                <input type="number" name="montant" id="montant" required
                    class="w-full px-4 py-2 rounded bg-slate-700 text-white border border-slate-600 focus:outline-none focus:ring-2 focus:ring-slate-500"
                    placeholder="Montant en FCFA">
            </div>

            <button type="submit"
                class="w-full bg-slate-600 hover:bg-slate-500 text-white px-6 py-2 rounded font-semibold transition duration-200 ease-in-out">
                Valider
            </button>
        </form>
    </div>
</main>
@endsection
