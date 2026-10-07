<?php

namespace App\Http\Controllers;

use App\Models\Adherent;
use App\Models\Emprunt;
use App\Models\Livre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;

class EmpruntController extends Controller
{
    public function index()
    {
        $emprunts = Emprunt::whereNull('date_retour_effective')
            ->with(['livre', 'adherent'])
            ->latest()
            ->paginate(10);

        return view('emprunts.index', compact('emprunts'));
    }

    public function create()
    {
        $livresDisponible = Livre::where('quantite_disponible', '>', 0)->get();
        $adherents = Adherent::orderBy('nom')->get();

        return view('emprunts.create', compact('livresDisponible', 'adherents'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'livre_id' => 'required|exists:livres,id',
            'adherent_id' => 'required|exists:adherents,id',
            'date_emprunt' => 'required|date',
            'date_retour_prevue' => 'required|date|after_or_equal:date_emprunt',
        ], [
            'livre_id.required' => 'Choisissez un livre.',
            'adherent_id.required' => 'Choisissez un adherent.',
            'date_retour_prevue.after_or_equal' => 'La date de retour prevue doit etre apres la date d emprunt.',
        ]);

        $livre = Livre::find($data['livre_id']);
        $adherent = Adherent::find($data['adherent_id']);

        if ($livre->quantite_disponible <= 0) {
            return back()->withInput()->with('error', 'Ce livre n\'est pas disponible.');
        }

        $empruntsEnCours = $adherent->empruntsEnCours()->count();
        if ($empruntsEnCours >= 3) {
            return back()->withInput()->with('error', 'Cet adhérent a déjà 3 emprunts en cours.');
        }

        if ($adherent->aRetard()) {
            return back()->withInput()->with('error', 'Cet adhérent a un retard, il ne peut pas emprunter.');
        }

        DB::transaction(function () use ($data, $livre, $adherent) {
            Emprunt::create($data);
            $livre->decrement('quantite_disponible');
        });

        return redirect()->route('emprunts.index')->with('success', 'Emprunt enregistré.');
    }

    public function editRetour(Emprunt $emprunt)
    {
        if ($emprunt->date_retour_effective) {
            return redirect()->route('emprunts.index')->with('error', 'Ce livre a deja ete rendu.');
        }

        return view('emprunts.retour', compact('emprunt'));
    }

    public function updateRetour(Request $request, Emprunt $emprunt)
    {
        if ($emprunt->date_retour_effective) {
            return redirect()->route('emprunts.index')->with('error', 'Ce livre a deja ete rendu.');
        }

        $data = $request->validate([
            'date_retour_effective' => 'required|date|after_or_equal:' . $emprunt->date_emprunt->toDateString(),
        ], [
            'date_retour_effective.required' => 'La date de retour est obligatoire.',
            'date_retour_effective.after_or_equal' => 'La date de retour ne peut pas etre avant la date d emprunt.',
        ]);

        DB::transaction(function () use ($emprunt, $data) {
            $emprunt->update($data);
            $emprunt->livre->increment('quantite_disponible');
        });

        return redirect()->route('emprunts.index')->with('success', 'Retour enregistré.');
    }

    public function exportCsv()
    {
        $emprunts = Emprunt::whereNull('date_retour_effective')
            ->with(['livre', 'adherent'])
            ->latest()
            ->get();

        $filename = 'emprunts_en_cours_' . now()->format('Y-m-d') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $columns = ['Livre', 'Auteur', 'Adherent', 'Email', 'Date emprunt', 'Retour prevue', 'Jours de retard'];

        $callback = function () use ($emprunts, $columns) {
            $file = fopen('php://output', 'w');
            fwrite($file, "\xEF\xBB\xBF");
            fputcsv($file, $columns, ';');

            foreach ($emprunts as $e) {
                fputcsv($file, [
                    $e->livre->titre,
                    $e->livre->auteur,
                    $e->adherent->nom . ' ' . $e->adherent->prenom,
                    $e->adherent->email,
                    $e->date_emprunt->format('Y-m-d'),
                    $e->date_retour_prevue->format('Y-m-d'),
                    $e->estEnRetard() ? 'En retard' : 'En cours',
                ], ';');
            }

            fclose($file);
        };

        return Response::stream($callback, 200, $headers);
    }
}