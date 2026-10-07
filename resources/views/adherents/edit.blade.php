@extends('layouts.app')

@section('title', 'Modifier adhérent')

@section('corps')

<div class="mb-6 flex flex-wrap items-center justify-between gap-3">
    <div>
        <h1 class="text-2xl font-semibold text-slate-900">Modifier l'adhérent</h1>
        <p class="mt-1 text-sm text-slate-600">{{ $adherent->nom }} {{ $adherent->prenom }}</p>
    </div>
    <a href="{{ route('adherents.index') }}" class="rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-sm font-medium text-slate-700 transition hover:bg-slate-100">Retour</a>
</div>

@if ($errors->any())
    <div class="mb-4 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
        <ul class="list-inside list-disc space-y-1">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form method="POST" action="{{ route('adherents.update', $adherent) }}" class="max-w-2xl rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
    @method('PUT')
    @csrf

    <div class="grid gap-4 sm:grid-cols-2">
        <div class="mb-4">
            <label class="mb-1.5 block text-sm font-medium text-slate-700">Nom *</label>
            <input type="text" name="nom" value="{{ old('nom', $adherent->nom) }}" required class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 focus:border-slate-900 focus:outline-none focus:ring-1 focus:ring-slate-900">
        </div>
        <div class="mb-4">
            <label class="mb-1.5 block text-sm font-medium text-slate-700">Prenom *</label>
            <input type="text" name="prenom" value="{{ old('prenom', $adherent->prenom) }}" required class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 focus:border-slate-900 focus:outline-none focus:ring-1 focus:ring-slate-900">
        </div>
    </div>

    <div class="mb-4">
        <label class="mb-1.5 block text-sm font-medium text-slate-700">Email *</label>
        <input type="email" name="email" value="{{ old('email', $adherent->email) }}" required class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 focus:border-slate-900 focus:outline-none focus:ring-1 focus:ring-slate-900">
    </div>

    <div class="grid gap-4 sm:grid-cols-2">
        <div class="mb-4">
            <label class="mb-1.5 block text-sm font-medium text-slate-700">Telephone</label>
            <input type="text" name="telephone" value="{{ old('telephone', $adherent->telephone) }}" class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 focus:border-slate-900 focus:outline-none focus:ring-1 focus:ring-slate-900">
        </div>
        <div class="mb-4">
            <label class="mb-1.5 block text-sm font-medium text-slate-700">Date inscription</label>
            <input type="date" name="date_inscription" value="{{ old('date_inscription', $adherent->date_inscription) }}" class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 focus:border-slate-900 focus:outline-none focus:ring-1 focus:ring-slate-900">
        </div>
    </div>

    <div class="mt-2 flex items-center gap-3">
        <button type="submit" class="rounded-lg bg-slate-900 px-4 py-2.5 text-sm font-medium text-white transition hover:bg-slate-800 focus:outline-none focus:ring-2 focus:ring-slate-900 focus:ring-offset-2">Enregistrer</button>
        <a href="{{ route('adherents.index') }}" class="text-sm font-medium text-slate-600 hover:text-slate-900">Annuler</a>
    </div>
</form>
@endsection
