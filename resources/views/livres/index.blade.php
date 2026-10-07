@extends('layouts.app')

@section('title', 'Livres')

@section('corps')

<div class="mb-6 flex flex-wrap items-center justify-between gap-3">
    <div>
        <h1 class="text-2xl font-semibold text-slate-900">Livres</h1>
        <p class="mt-1 text-sm text-slate-600">Catalogue de la bibliothèque</p>
    </div>
    <a href="{{ route('livres.create') }}" class="rounded-lg bg-slate-900 px-4 py-2.5 text-sm font-medium text-white transition hover:bg-slate-800 focus:outline-none focus:ring-2 focus:ring-slate-900 focus:ring-offset-2">Ajouter un livre</a>
</div>

<form method="GET" action="{{ route('livres.index') }}" class="mb-6 flex flex-wrap items-end gap-3 rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
    <div class="min-w-52 flex-1">
        <label class="mb-1.5 block text-sm font-medium text-slate-700">Recherche</label>
        <input type="text" name="search" placeholder="Titre ou auteur" value="{{ request('search') }}" class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 focus:border-slate-900 focus:outline-none focus:ring-1 focus:ring-slate-900">
    </div>
    <div class="w-52">
        <label class="mb-1.5 block text-sm font-medium text-slate-700">Categorie</label>
        <select name="categorie" class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 focus:border-slate-900 focus:outline-none focus:ring-1 focus:ring-slate-900">
            <option value="">Toutes les categories</option>
            @foreach ($listeCategories as $cat)
                <option value="{{ $cat }}" {{ request('categorie') == $cat ? 'selected' : '' }}>{{ $cat }}</option>
            @endforeach
        </select>
    </div>
    <label class="flex items-center gap-2 rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-700">
        <input type="checkbox" name="disponible" value="1" {{ request('disponible') ? 'checked' : '' }} class="h-4 w-4">
        Disponibles uniquement
    </label>
    <button type="submit" class="rounded-lg bg-slate-900 px-4 py-2 text-sm font-medium text-white transition hover:bg-slate-800">Filtrer</button>
</form>

<div class="rounded-2xl border border-slate-200 bg-white">
    <div class="overflow-x-auto">
        <table class="min-w-full text-sm">
            <thead>
                <tr class="border-b border-slate-200 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">
                    <th class="px-5 py-3">Titre</th>
                    <th class="px-5 py-3">Auteur</th>
                    <th class="px-5 py-3">Categorie</th>
                    <th class="px-5 py-3">Stock</th>
                    <th class="px-5 py-3">Disponible</th>
                    <th class="px-5 py-3 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse ($livres as $livre)
                    <tr class="hover:bg-slate-50">
                        <td class="px-5 py-3 font-medium text-slate-900">{{ $livre->titre }}</td>
                        <td class="px-5 py-3 text-slate-700">{{ $livre->auteur }}</td>
                        <td class="px-5 py-3 text-slate-700">{{ $livre->categorie ?? '-' }}</td>
                        <td class="px-5 py-3 text-slate-700">{{ $livre->quantite_totale }}</td>
                        <td class="px-5 py-3 text-slate-700">{{ $livre->quantite_disponible }}</td>
                        <td class="px-5 py-3">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('livres.edit', $livre) }}" class="rounded-full bg-amber-100 px-3 py-1 text-xs font-medium text-amber-800 transition hover:bg-amber-200">Modifier</a>
                                <form action="{{ route('livres.destroy', $livre) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="rounded-full bg-red-100 px-3 py-1 text-xs font-medium text-red-800 transition hover:bg-red-200" onclick="return confirm('Supprimer ce livre ?')">Supprimer</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-5 py-8 text-center text-slate-500">Aucun livre</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-4">
    {{ $livres->links() }}
</div>
@endsection
