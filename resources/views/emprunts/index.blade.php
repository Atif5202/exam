@extends('layouts.app')

@section('title', 'Emprunts')

@section('corps')

<div class="mb-6 flex flex-wrap items-center justify-between gap-3">
    <div>
        <h1 class="text-2xl font-semibold text-slate-900">Emprunts en cours</h1>
        <p class="mt-1 text-sm text-slate-600">Les lignes rouges sont en retard</p>
    </div>
    <div class="flex items-center gap-2">
        <a href="{{ route('emprunts.csv') }}" class="rounded-lg bg-green-700 px-4 py-2.5 text-sm font-medium text-white transition hover:bg-green-800">Exporter CSV</a>
        <a href="{{ route('emprunts.create') }}" class="rounded-lg bg-slate-900 px-4 py-2.5 text-sm font-medium text-white transition hover:bg-slate-800 focus:outline-none focus:ring-2 focus:ring-slate-900 focus:ring-offset-2">Nouvel emprunt</a>
    </div>
</div>

<div class="rounded-2xl border border-slate-200 bg-white">
    <div class="overflow-x-auto">
        <table class="min-w-full text-sm">
            <thead>
                <tr class="border-b border-slate-200 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">
                    <th class="px-5 py-3">Livre</th>
                    <th class="px-5 py-3">Adherent</th>
                    <th class="px-5 py-3">Date emprunt</th>
                    <th class="px-5 py-3">Retour prevue</th>
                    <th class="px-5 py-3">Statut</th>
                    <th class="px-5 py-3 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse ($emprunts as $emprunt)
                    <tr class="{{ $emprunt->estEnRetard() ? 'ligne-retard' : 'hover:bg-slate-50' }}">
                        <td class="px-5 py-3 font-medium text-slate-900">{{ $emprunt->livre->titre }}</td>
                        <td class="px-5 py-3 text-slate-700">{{ $emprunt->adherent->nom }} {{ $emprunt->adherent->prenom }}</td>
                        <td class="px-5 py-3 text-slate-700">{{ $emprunt->date_emprunt }}</td>
                        <td class="px-5 py-3 text-slate-700">{{ $emprunt->date_retour_prevue }}</td>
                        <td class="px-5 py-3">
                            @if($emprunt->estEnRetard())
                                <span class="badge-retard">En retard</span>
                            @else
                                <span class="inline-block rounded bg-amber-100 px-2 py-0.5 text-xs font-medium text-amber-800">En cours</span>
                            @endif
                        </td>
                        <td class="px-5 py-3">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('emprunts.retour', $emprunt) }}" class="rounded-full bg-green-100 px-3 py-1 text-xs font-medium text-green-800 transition hover:bg-green-200">Retour</a>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-5 py-8 text-center text-slate-500">Aucun emprunt en cours</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-4">
    {{ $emprunts->links() }}
</div>
@endsection
