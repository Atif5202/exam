@extends('layouts.app')

@section('title', 'Tableau de bord')

@section('corps')

<div class="mx-2 md:mx-6 lg:mx-10 my-6">

<div class="mb-6 rounded-xl border border-slate-200 bg-white shadow-sm">
    <dl class="grid grid-cols-2 lg:grid-cols-4 divide-slate-200 divide-y lg:divide-y-0 lg:divide-x">

        <div class="p-6 border-r border-slate-200 lg:border-r-0">
            <dt class="flex items-center gap-2 text-sm text-slate-600">
                <span class="h-2 w-2 rounded-full bg-blue-700"></span> Livres
            </dt>
            <dd class="mt-3 text-4xl font-semibold tracking-tight text-slate-900">{{ $totalLivres }}</dd>
            <p class="mt-1 text-xs text-slate-500">au catalogue</p>
        </div>

        <div class="p-6">
            <dt class="flex items-center gap-2 text-sm text-slate-600">
                <span class="h-2 w-2 rounded-full bg-green-700"></span> Adherents
            </dt>
            <dd class="mt-3 text-4xl font-semibold tracking-tight text-slate-900">{{ $totalAdherents }}</dd>
            <p class="mt-1 text-xs text-slate-500">inscrits</p>
        </div>

        <div class="p-6 border-r border-slate-200 lg:border-r-0">
            <dt class="flex items-center gap-2 text-sm text-slate-600">
                <span class="h-2 w-2 rounded-full bg-amber-500"></span> Emprunts en cours
            </dt>
            <dd class="mt-3 text-4xl font-semibold tracking-tight text-slate-900">{{ $empruntsEnCours }}</dd>
            <p class="mt-1 text-xs text-slate-500">a rendre</p>
        </div>

        <div class="p-6">
            <dt class="flex items-center gap-2 text-sm text-slate-600">
                <span class="h-2 w-2 rounded-full bg-red-600"></span> Retards
            </dt>
            <dd class="mt-3 text-4xl font-semibold tracking-tight {{ $retards > 0 ? 'text-red-700' : 'text-slate-900' }}">{{ $retards }}</dd>
            <p class="mt-1 text-xs text-slate-500">{{ $retards > 0 ? 'a relancer' : 'aucun retard' }}</p>
        </div>

    </dl>
</div>

<div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
    <div class="flex items-center justify-between border-b border-slate-200 px-6 py-5">
        <h2 class="text-base font-semibold text-slate-900">Derniers emprunts en cours</h2>
        <a href="{{ route('emprunts.index') }}" class="text-sm font-medium text-slate-600 underline-offset-4 transition hover:text-slate-900 hover:underline">Voir tout</a>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full text-sm">
            <thead>
                <tr class="border-b border-slate-200 bg-slate-50 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                    <th class="px-6 py-3.5">Livre</th>
                    <th class="px-6 py-3.5">Adherent</th>
                    <th class="px-6 py-3.5">Date emprunt</th>
                    <th class="px-6 py-3.5">Retour prevu</th>
                    <th class="px-6 py-3.5">Statut</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse ($empruntsRecent as $emprunt)
                    <tr class="transition-colors {{ $emprunt->estEnRetard() ? 'bg-red-50/60 hover:bg-red-50' : 'hover:bg-slate-50' }}">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">                                
                                <span class="font-medium text-slate-900">{{ $emprunt->livre->titre }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <span class="text-slate-700">{{ $emprunt->adherent->nom }} {{ $emprunt->adherent->prenom }}</span>
                            </div>
                        </td>
                        <td class="whitespace-nowrap px-6 py-4 text-slate-600">{{ $emprunt->date_emprunt }}</td>
                        <td class="whitespace-nowrap px-6 py-4 {{ $emprunt->estEnRetard() ? 'font-medium text-red-700' : 'text-slate-600' }}">{{ $emprunt->date_retour_prevue }}</td>
                        <td class="px-6 py-4">
                            @if ($emprunt->estEnRetard())
                                <span class="inline-flex items-center gap-1.5 rounded-full bg-red-100 px-3 py-1 text-xs font-medium text-red-800">
                                    <span class="h-1.5 w-1.5 rounded-full bg-red-600"></span> En retard
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 rounded-full bg-amber-100 px-3 py-1 text-xs font-medium text-amber-800">
                                    <span class="h-1.5 w-1.5 rounded-full bg-amber-500"></span> En cours
                                </span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-slate-500">Aucun emprunt en cours</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

</div>

@endsection