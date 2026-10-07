<?php

namespace App\Http\Controllers;

use App\Models\Adherent;
use Illuminate\Http\Request;

class AdherentController extends Controller
{
    public function index()
    {
        $adherents = Adherent::latest()->paginate(10);
        return view('adherents.index', compact('adherents'));
    }

    public function create()
    {
        return view('adherents.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:adherents,email',
            'telephone' => 'nullable|string|max:20',
            'date_inscription' => 'nullable|date',
        ], [
            'nom.required' => 'Le nom est obligatoire.',
            'prenom.required' => 'Le prenom est obligatoire.',
            'email.required' => 'L email est obligatoire.',
            'email.email' => 'L email n est pas valide.',
            'email.unique' => 'Cet email existe deja.',
        ]);

        Adherent::create($data);

        return redirect()->route('adherents.index')->with('success', 'Adhérent ajouté.');
    }

    public function show(Adherent $adherent)
    {
        $emprunts = $adherent->emprunts()->with('livre')->latest()->get();
        return view('adherents.show', compact('adherent', 'emprunts'));
    }

    public function edit(Adherent $adherent)
    {
        return view('adherents.edit', compact('adherent'));
    }

    public function update(Request $request, Adherent $adherent)
    {
        $data = $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:adherents,email,' . $adherent->id,
            'telephone' => 'nullable|string|max:20',
            'date_inscription' => 'nullable|date',
        ], [
            'nom.required' => 'Le nom est obligatoire.',
            'prenom.required' => 'Le prenom est obligatoire.',
            'email.required' => 'L email est obligatoire.',
            'email.email' => 'L email n est pas valide.',
            'email.unique' => 'Cet email existe deja.',
        ]);

        $adherent->update($data);

        return redirect()->route('adherents.index')->with('success', 'Adhérent modifié.');
    }

    public function destroy(Adherent $adherent)
    {
        if ($adherent->empruntsEnCours()->count() > 0) {
            return back()->with('error', 'Cet adhérent a des emprunts en cours, il ne peut pas être supprimé.');
        }

        $adherent->delete();

        return back()->with('success', 'Adhérent supprimé.');
    }
}