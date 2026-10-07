<?php

namespace App\Http\Controllers;

use App\Models\Livre;
use Illuminate\Http\Request;

class LivreController extends Controller
{
    public function index(Request $request)
    {
        $query = Livre::query();

        $search = $request->input('search');
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('titre', 'like', '%' . $search . '%')
                  ->orWhere('auteur', 'like', '%' . $search . '%');
            });
        }

        $categorie = $request->input('categorie');
        if ($categorie) {
            $query->where('categorie', $categorie);
        }

        $disponible = $request->input('disponible');
        if ($disponible) {
            $query->where('quantite_disponible', '>', 0);
        }

        $livres = $query->latest()->paginate(10)->appends($request->only(['search', 'categorie', 'disponible']));

        $listeCategories = Livre::distinct()->whereNotNull('categorie')->pluck('categorie')->sort()->values();

        return view('livres.index', compact('livres', 'listeCategories'));
    }

    public function create()
    {
        return view('livres.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'titre' => 'required|string|max:255',
            'auteur' => 'required|string|max:255',
            'isbn' => 'required|string|max:20|unique:livres,isbn',
            'categorie' => 'nullable|string|max:100',
            'annee' => 'nullable|integer|min:1000|max:' . now()->year,
            'quantite_totale' => 'required|integer|min:0',
        ], [
            'titre.required' => 'Le titre est obligatoire.',
            'auteur.required' => 'L auteur est obligatoire.',
            'isbn.required' => 'L ISBN est obligatoire.',
            'isbn.unique' => 'Cet ISBN existe deja.',
            'quantite_totale.required' => 'La quantite totale est obligatoire.',
            'quantite_totale.min' => 'La quantite ne peut pas etre negative.',
            'annee.integer' => 'L annee doit etre un nombre.',
        ]);

        $data['quantite_disponible'] = $data['quantite_totale'];

        Livre::create($data);

        return redirect()->route('livres.index')->with('success', 'Livre ajouté.');
    }

    public function edit(Livre $livre)
    {
        return view('livres.edit', compact('livre'));
    }

    public function update(Request $request, Livre $livre)
    {
        $data = $request->validate([
            'titre' => 'required|string|max:255',
            'auteur' => 'required|string|max:255',
            'isbn' => 'required|string|max:20|unique:livres,isbn,' . $livre->id,
            'categorie' => 'nullable|string|max:100',
            'annee' => 'nullable|integer|min:1000|max:' . now()->year,
            'quantite_totale' => 'required|integer|min:0',
        ], [
            'titre.required' => 'Le titre est obligatoire.',
            'auteur.required' => 'L auteur est obligatoire.',
            'isbn.required' => 'L ISBN est obligatoire.',
            'isbn.unique' => 'Cet ISBN existe deja.',
            'quantite_totale.required' => 'La quantite totale est obligatoire.',
            'quantite_totale.min' => 'La quantite ne peut pas etre negative.',
            'annee.integer' => 'L annee doit etre un nombre.',
        ]);

        $empruntsEnCours = $livre->empruntsEnCours()->count();
        $nouvelleDisponible = $data['quantite_totale'] - $empruntsEnCours;

        if ($nouvelleDisponible < 0) {
            return back()->withInput()->with('error', 'La quantité totale ne peut pas devenir inférieure au nombre d\'exemplaires empruntés (' . $empruntsEnCours . ').');
        }

        $data['quantite_disponible'] = $nouvelleDisponible;
        $livre->update($data);

        return redirect()->route('livres.index')->with('success', 'Livre modifié.');
    }

    public function destroy(Livre $livre)
    {
        if ($livre->empruntsEnCours()->count() > 0) {
            return back()->with('error', 'Ce livre a des emprunts en cours, il ne peut pas être supprimé.');
        }

        $livre->delete();

        return back()->with('success', 'Livre supprimé.');
    }
}