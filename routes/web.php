<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AgentController;
use App\Http\Controllers\SiteController;
use App\Http\Controllers\AssignmentController;

Route::get('/', function () {
    return redirect()->route('agents.index');
});

// Protéger les ressources derrière l'authentification si installée
Route::middleware('auth')->group(function () {
    Route::resource('agents', AgentController::class);
    Route::resource('sites', SiteController::class);
    Route::resource('assignments', AssignmentController::class);
});

// Si tu veux des routes publiques, déplace les routes hors du middleware ci-dessus.
