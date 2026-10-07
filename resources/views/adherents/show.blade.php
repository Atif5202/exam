@extends('layouts.app')

@section('title', 'Fiche adhérent')

@section('corps')

<div class="mb-6 flex flex-wrap items-center justify-between gap-3">
    <div>
        <h1 class="text-2xl font-semibold text-slate-900">{{ $adherent->nom }} {{ $adherent->prenom }}</h1>
        <p class="mt-1 text-sm text-slate-600">Fiche de l'adhérent</p>
    </div>
    <div class="flex items-center gap-2">
        <a href="{{ route('adherents.edit', $adherent) }}" class="rounded-lg bg-amber-500 px-4 py-2.5 text-sm font-medium text-white transition hover:bg-amber-600">Modifier</a>
        <a href="{{ route('adherents.index') }}" class="rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-sm font-medium text-slate-700 transition hover:bg-slate-100">Retour</a>
    </div>
</div>

<div class="mb-6 grid gap-4 sm:grid-cols-3">
    <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
        <p class="text-sm text-slate-600">Email</p>
        <p class="mt-1 font-medium text-slate-900">{{ $adherent->email }}</p>
    </div>
    <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
        <p class="text-sm text-slate-600">Telephone</p>
        <p class="mt-1 font-medium text-slate-900">{{ $adherent->telephone ?? '-' }}</p>
    </div>
    <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
        <p class="text-sm text-slate-600">Emprunts en cours</p>
        <p class="mt-1 font-medium text-slate-900">{{ $adherent->empruntsEnCours()->count() }} / 3</p>
    </div>
</div>

<div class="rounded-2xl border border-slate-200 bg-white">
    <div class="border-b border-slate-200 px-5 py-4">
        <h2 class="text-base font-semibold text-slate-900">Historique des emprunts</h2>
    </div>
    <div class="overflow-x-auto">
        <table class="min-w-full text-sm">
            <thead>
                <tr class="border-b border-slate-200 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">
                    <th class="px-5 py-3">Livre</th>
                    <th class="px-5 py-3">Date emprunt</th>
                    <th class="px-5 py-3">Retour prevue</th>
                    <th class="px-5 py-3">Retour effective</th>
                    <th class="px-5 py-3">Statut</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse ($emprunts as $emprunt)
                    <tr class="hover:bg-slate-50">
                        <td class="px-5 py-3 font-medium text-slate-900">{{ $emprunt->livre->titre }}</td>
                        <td class="px-5 py-3 text-slate-700">{{ $emprunt->date_emprunt }}</td>
                        <td class="px-5 py-3 text-slate-700">{{ $emprunt->date_retour_prevue }}</td>
                        <td class="px-5 py-3 text-slate-700">{{ $emprunt->date_retour_effective ?? '-' }}</td>
                        <td class="px-5 py-3">
                            @if($emprunt->date_retour_effective)
                                <span class="inline-block rounded bg-green-100 px-2 py-0.5 text-xs font-medium text-green-800">Rendu</span>
                            @elseif($emprunt->estEnRetard())
                                <span class="badge-retard">En retard</span>
                            @else
                                <span class="inline-block rounded bg-amber-100 px-2 py-0.5 text-xs font-medium text-amber-800">En cours</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-5 py-8 text-center text-slate-500">Aucun emprunt</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
