@extends('layouts.app')

@section('title', 'Adhérents')

@section('corps')

<div class="mb-6 flex flex-wrap items-center justify-between gap-3">
    <div>
        <h1 class="text-2xl font-semibold text-slate-900">Adhérents</h1>
        <p class="mt-1 text-sm text-slate-600">Liste des membres de la bibliothèque</p>
    </div>
    <a href="{{ route('adherents.create') }}" class="rounded-lg bg-slate-900 px-4 py-2.5 text-sm font-medium text-white transition hover:bg-slate-800 focus:outline-none focus:ring-2 focus:ring-slate-900 focus:ring-offset-2">Ajouter un adhérent</a>
</div>

<div class="rounded-2xl border border-slate-200 bg-white">
    <div class="overflow-x-auto">
        <table class="min-w-full text-sm">
            <thead>
                <tr class="border-b border-slate-200 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">
                    <th class="px-5 py-3">Nom</th>
                    <th class="px-5 py-3">Prénom</th>
                    <th class="px-5 py-3">Email</th>
                    <th class="px-5 py-3">Téléphone</th>
                    <th class="px-5 py-3">Date inscription</th>
                    <th class="px-5 py-3 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse ($adherents as $adherent)
                    <tr class="hover:bg-slate-50">
                        <td class="px-5 py-3 font-medium text-slate-900">{{ $adherent->nom }}</td>
                        <td class="px-5 py-3 text-slate-700">{{ $adherent->prenom }}</td>
                        <td class="px-5 py-3 text-slate-700">{{ $adherent->email }}</td>
                        <td class="px-5 py-3 text-slate-700">{{ $adherent->telephone ?? '-' }}</td>
                        <td class="px-5 py-3 text-slate-700">{{ $adherent->date_inscription ?? '-' }}</td>
                        <td class="px-5 py-3">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('adherents.show', $adherent) }}" class="rounded-full border border-slate-200 px-3 py-1 text-xs font-medium text-slate-700 transition hover:bg-slate-100">Voir</a>
                                <a href="{{ route('adherents.edit', $adherent) }}" class="rounded-full bg-amber-100 px-3 py-1 text-xs font-medium text-amber-800 transition hover:bg-amber-200">Modifier</a>
                                <form action="{{ route('adherents.destroy', $adherent) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="rounded-full bg-red-100 px-3 py-1 text-xs font-medium text-red-800 transition hover:bg-red-200" onclick="return confirm('Supprimer cet adherent ?')">Supprimer</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-5 py-8 text-center text-slate-500">Aucun adhérent</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-4">
    {{ $adherents->links() }}
</div>
@endsection
