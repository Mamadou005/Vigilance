<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AgentController;
use App\Http\Controllers\AppelController;
use App\Http\Controllers\RemplacementController;
use App\Http\Controllers\AlerteController;
use App\Http\Controllers\PlanningController;
use App\Http\Controllers\SiteController;
use App\Http\Controllers\PointageController;
use Illuminate\Support\Facades\Route;
use App\Models\Agent;
use App\Models\Alerte;
use App\Models\Remplacement;
use App\Models\Site;
use App\Models\Pointage;

Route::get('/', function () { return view('welcome'); });

Route::get('/dashboard', function () {
    $moisActuel = now()->month;
    $statsAgents = Agent::selectRaw('statut, COUNT(*) as total')->groupBy('statut')->pluck('total','statut')->toArray();
    $alertesNonTraitees = Alerte::where('traitee', false)->count();
    $remplacementsEnCours = Remplacement::whereDate('date_debut', now())->count();
    $totalSanctions = Pointage::where('type', 'absence')->whereMonth('date_pointage', $moisActuel)->sum('montant');
    $nbRemplacements = Pointage::where('type', 'supplementaire')->whereMonth('date_pointage', $moisActuel)->count();
    $sites = Site::with('agents')->get();

    return view('dashboard', compact('statsAgents', 'alertesNonTraitees', 'remplacementsEnCours', 'sites', 'totalSanctions', 'nbRemplacements'));
})->middleware(['auth'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('agents', AgentController::class);
    Route::get('agents/export/{siteId?}', [AgentController::class, 'exportExcel'])->name('agents.exportExcel');

    Route::resource('appels', AppelController::class);
    Route::resource('remplacements', RemplacementController::class);

    // --- ALERTES SECTION ---
    Route::resource('alertes', AlerteController::class);
    Route::get('/alertes/{id}/pdf', [AlerteController::class, 'downloadPDF'])->name('alertes.pdf');

    Route::resource('sites', SiteController::class);

    Route::get('plannings', [PlanningController::class, 'index'])->name('plannings.index');
    Route::get('plannings/secteur', [PlanningController::class, 'site'])->name('plannings.site');
    Route::get('plannings/create/{agentId}', [PlanningController::class, 'create'])->name('plannings.create');
    Route::post('plannings/store/{agentId}', [PlanningController::class, 'store'])->name('plannings.store');
    Route::get('plannings/show/{agentId}', [PlanningController::class, 'show'])->name('plannings.show');
    Route::delete('plannings/{planning}', [PlanningController::class, 'destroy'])->name('plannings.destroy');
    Route::post('plannings/site/{site}/rpe', [PlanningController::class, 'updateRPE'])->name('sites.updateRPE');

    Route::get('/pointages', [PointageController::class, 'index'])->name('pointages.index');
    Route::post('/pointages/store', [PointageController::class, 'store'])->name('pointages.store');
    Route::get('/pointages/{id}/edit', [PointageController::class, 'edit'])->name('pointages.edit');
    Route::put('/pointages/{id}', [PointageController::class, 'update'])->name('pointages.update');
    Route::delete('/pointages/{id}', [PointageController::class, 'destroy'])->name('pointages.destroy');
    Route::get('/pointages/export', [PointageController::class, 'export'])->name('pointages.export');
});

require __DIR__.'/auth.php';
