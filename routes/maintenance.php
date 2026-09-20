<?php

use App\Http\Controllers\Maintenance\BalaiController;
use App\Http\Controllers\Maintenance\ClientController;
use App\Http\Controllers\Maintenance\EmplacementController;
use App\Http\Controllers\Maintenance\InstrumentController;
use App\Http\Controllers\Maintenance\MesureIsolementController;
use App\Http\Controllers\Maintenance\MoteurBalaiPositionController;
use App\Http\Controllers\Maintenance\MoteurController;
use App\Http\Controllers\Maintenance\ReleveBalaiController;
use App\Http\Controllers\Maintenance\SiteController;
use Illuminate\Support\Facades\Route;

Route::prefix('maintenance')->name('maintenance.')->middleware('auth')->group(function () {
    Route::resource('clients', ClientController::class);
    Route::resource('sites', SiteController::class);
    Route::resource('emplacements', EmplacementController::class);
    Route::resource('instruments', InstrumentController::class)->except('show');
    Route::resource('balais', BalaiController::class)->except('show');
    Route::resource('moteurs', MoteurController::class);
    Route::get('moteurs/{moteur}/qr.svg', [MoteurController::class, 'qrCode'])->name('moteurs.qr');

    Route::get('moteurs/{moteur}/mesures-isolement/creer', [MesureIsolementController::class, 'create'])->name('moteurs.mesures.create');
    Route::post('moteurs/{moteur}/mesures-isolement', [MesureIsolementController::class, 'store'])->name('moteurs.mesures.store');
    Route::get('mesures-isolement/{mesure}', [MesureIsolementController::class, 'show'])->name('mesures.show');
    Route::get('mesures-isolement/{mesure}/editer', [MesureIsolementController::class, 'edit'])->name('mesures.edit');
    Route::put('mesures-isolement/{mesure}', [MesureIsolementController::class, 'update'])->name('mesures.update');
    Route::delete('mesures-isolement/{mesure}', [MesureIsolementController::class, 'destroy'])->name('mesures.destroy');

    Route::get('moteurs/{moteur}/positions/creer', [MoteurBalaiPositionController::class, 'create'])->name('moteurs.positions.create');
    Route::post('moteurs/{moteur}/positions', [MoteurBalaiPositionController::class, 'store'])->name('moteurs.positions.store');
    Route::get('positions/{position}/editer', [MoteurBalaiPositionController::class, 'edit'])->name('positions.edit');
    Route::put('positions/{position}', [MoteurBalaiPositionController::class, 'update'])->name('positions.update');
    Route::delete('positions/{position}', [MoteurBalaiPositionController::class, 'destroy'])->name('positions.destroy');

    Route::get('positions/{position}/releves/creer', [ReleveBalaiController::class, 'create'])->name('positions.releves.create');
    Route::post('positions/{position}/releves', [ReleveBalaiController::class, 'store'])->name('positions.releves.store');
    Route::delete('releves/{releve}', [ReleveBalaiController::class, 'destroy'])->name('releves.destroy');
});
