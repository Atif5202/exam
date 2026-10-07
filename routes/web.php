<?php

use App\Http\Controllers\AdherentController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmpruntController;
use App\Http\Controllers\LivreController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.store');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/livres', [LivreController::class, 'index'])->name('livres.index');
    Route::get('/livres/create', [LivreController::class, 'create'])->name('livres.create');
    Route::post('/livres', [LivreController::class, 'store'])->name('livres.store');
    Route::get('/livres/{livre}/edit', [LivreController::class, 'edit'])->name('livres.edit');
    Route::put('/livres/{livre}', [LivreController::class, 'update'])->name('livres.update');
    Route::delete('/livres/{livre}', [LivreController::class, 'destroy'])->name('livres.destroy');

    Route::get('/adherents', [AdherentController::class, 'index'])->name('adherents.index');
    Route::get('/adherents/create', [AdherentController::class, 'create'])->name('adherents.create');
    Route::post('/adherents', [AdherentController::class, 'store'])->name('adherents.store');
    Route::get('/adherents/{adherent}', [AdherentController::class, 'show'])->name('adherents.show');
    Route::get('/adherents/{adherent}/edit', [AdherentController::class, 'edit'])->name('adherents.edit');
    Route::put('/adherents/{adherent}', [AdherentController::class, 'update'])->name('adherents.update');
    Route::delete('/adherents/{adherent}', [AdherentController::class, 'destroy'])->name('adherents.destroy');

    Route::get('/emprunts/csv', [EmpruntController::class, 'exportCsv'])->name('emprunts.csv');
    Route::get('/emprunts', [EmpruntController::class, 'index'])->name('emprunts.index');
    Route::get('/emprunts/create', [EmpruntController::class, 'create'])->name('emprunts.create');
    Route::post('/emprunts', [EmpruntController::class, 'store'])->name('emprunts.store');
    Route::get('/emprunts/{emprunt}/retour', [EmpruntController::class, 'editRetour'])->name('emprunts.retour');
    Route::put('/emprunts/{emprunt}/retour', [EmpruntController::class, 'updateRetour'])->name('emprunts.retour.update');
});
