<?php

namespace App\Http\Controllers;

use App\Models\Adherent;
use App\Models\Emprunt;
use App\Models\Livre;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $totalLivres = Livre::count();
        $totalAdherents = Adherent::count();
        $empruntsEnCours = Emprunt::whereNull('date_retour_effective')->count();
        $retards = Emprunt::whereNull('date_retour_effective')
            ->where('date_retour_prevue', '<', now()->toDateString())
            ->count();

        $livresDisponible = Livre::where('quantite_disponible', '>', 0)->count();

        $empruntsRecent = Emprunt::whereNull('date_retour_effective')
            ->with(['livre', 'adherent'])
            ->latest()
            ->limit(5)
            ->get();

        return view('dashboard', compact(
            'totalLivres',
            'totalAdherents',
            'empruntsEnCours',
            'retards',
            'livresDisponible',
            'empruntsRecent'
        ));
    }
}